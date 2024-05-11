<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCommentRequest;
use App\Models\Commentaire;
use App\Models\Demande;
use App\Models\DiplomePrepare;
use App\Models\Parcours;
use App\Models\Professeur;
use App\Models\Societe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client as TwilioClient;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $demandes = Demande::all();
        $societes = Societe::all();
        $diplomes = DiplomePrepare::all();
        return view('admin.dashboard', [
            'demandes' => $demandes,
            'societes' => $societes,
            'diplomes' => $diplomes
        ]);
    }

    public function viewRequests(Request $request)
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $demandes = Demande::all();
        $societes = Societe::all();
        $diplomes = DiplomePrepare::all();
        if ($request->header('HX-Request')) {
            return view('admin.partials.main_demande', [
                'demandes' => $demandes,
                'societes' => $societes,
                'diplomes' => $diplomes
            ]);
        } else {
            return view('admin.dashboard', [
                'demandes' => $demandes,
                'societes' => $societes,
                'diplomes' => $diplomes
            ]);
        }
    }

    public function viewStudents()
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $users = User::all();
        $parcours = Parcours::all();
        $diplomes = DiplomePrepare::all();
        if (request()->header('HX-Request')) {
            return view('admin.partials.main_students', [
                'users' => $users,
                'parcours' => $parcours,
                'diplomes' => $diplomes
            ]);
        } else {
            return view('admin.dashboard_students', [
                'users' => $users,
                'parcours' => $parcours,
                'diplomes' => $diplomes
            ]);
        }
    }

    public function viewTeachers()
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $teachers = Professeur::all();
        //        $parcours = Parcours::all();
        if (request()->header('HX-Request')) {
            return view('admin.partials.main_teachers', [
                'teachers' => $teachers,
                //                'parcours' =>$parcours,
            ]);
        } else {
            return view('admin.dashboard_teachers', [
                'teachers' => $teachers,
                //                'parcours' =>$parcours,
            ]);
        }
    }

    public function viewRequest(Demande $demande, Request $request)
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $teachers = Professeur::all();
        if ($request->header('HX-Request')) {
            return view('admin.partials.show', [
                'demande' => $demande,
                'teachers' => $teachers
            ]);
        } else {
            return view('admin.show', [
                'demande' => $demande,
                'teachers' => $teachers
            ]);
        }
    }

    public function updateRequest(Demande $demande, Request $request)
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        if ($request->input('status')) {
            if ($request->input('status') == 'validated') {
                $demande->update([
                    'request_status' => true
                ]);
            } else {
                $demande->update([
                    'request_status' => false
                ]);
            }
        }

        return view('admin.partials.show', [
            'demande' => $demande,
            'teachers' => Professeur::all()
        ]);
    }

    public function commentRequest(AdminCommentRequest $request, $demande_id)
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }


        $comment = Commentaire::create($request->validated());

        $demande = Demande::find($demande_id);
        $demande->commentaire_id = $comment->id;
        $demande->save();

        //        $user->professeur_id = $request->validated()['professeur_id'];
        //        $user->save();

        $user = $demande->users->first();
        if ($user) {
            $user->professeur_id = $request->validated()['professeur_id'];
            $user->save();

            //Envoyé un message à l'utilisateur
            $sid    = env('TWILIO_SID');
            $token  = env('TWILIO_TOKEN');
            $twilio = app(TwilioClient::class, [$sid, $token]);

            $message = $twilio->messages
                ->create(
                    '+225' . $user->phone_number,
                    [
                        "from" => env('TWILIO_PHONE_NUMBER'),
                        "body" => "Administration Pigier. Bonjour {$user->full_name}, votre demande a été traitée. Vous pouvez vous rendre sur le site et consulter votre réponse. Merci de votre confiance.",
                    ]
                );
        };

        if ($demande->users->count() >= 2) {
            $partner = $demande->users[1];
            $partner->professeur_id = $request->validated()['professeur_id'];
            $partner->save();

            //Envoyé un message au partenaire
            $sid    = env('TWILIO_SID');
            $token  = env('TWILIO_TOKEN');
            $twilio = app(TwilioClient::class, [$sid, $token]);

            $message = $twilio->messages
                ->create(
                    '+225' . $partner->phone_number,
                    [
                        "from" => env('TWILIO_PHONE_NUMBER'),
                        "body" => "Administration Pigier. Bonjour {$partner->full_name}, votre demande a été traitée. Vous pouvez vous rendre sur le site et consulter votre réponse. Merci de votre confiance.",
                    ]
                );
        }

        Session::flash('success', 'Commentaire ajouté avec succès');

        return view('admin.partials.show', [
            'demande' => $demande,
            'teachers' => Professeur::all(),
        ])->with('success', 'Commentaire ajouté avec succès');
    }

    public function filterRequests(Request $request)
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }
        ////        dd($request->all());
        //        Session::put('societe_id', $request->input('societe_id'));
        //        Session::put('diplome_prepare_id', $request->input('diplome_prepare_id'));
        $demandes = Demande::query();

        if ($request->input('societe_id')) {
            $demandes->where('societe_id', $request->input('societe_id'));
        }

        if ($request->input('diplome_prepare_id')) {
            $diplome_prepare_id = $request->input('diplome_prepare_id');
            $demandes->whereHas('users', function ($query) use ($diplome_prepare_id) {
                $query->where('diplome_prepare_id', $diplome_prepare_id);
            });
        }

        if ($request->input('request_status')) {
            if ($request->input('request_status') == 2) {
                $demandes->where('request_status', null);
            } else {
                $demandes->where('request_status', $request->input('request_status'));
            }
        }

        $demandes = $demandes->with('users')->get();
        if ($request->header('HX-Request')) {
            return view('admin.partials.table', [
                'demandes' => $demandes,
                'societe_id' => $request->input('societe_id'),
                'diplome_prepare_id' => $request->input('diplome_prepare_id'),
                'request_status' => $request->input('request_status')
            ]);
        } else {
            return view('admin.dashboard', [
                'demandes' => $demandes,
                'societes' => Societe::all(),
                'diplomes' => DiplomePrepare::all(),
                'societe_id' => $request->input('societe_id'),
                'diplome_prepare_id' => $request->input('diplome_prepare_id'),
                'request_status' => $request->input('request_status')
            ]);
        }
    }

    public function filterStudents(Request $request)
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $users = User::query();

        if ($request->input('diplome_prepare_id')) {
            $users->where('diplome_prepare_id', $request->input('diplome_prepare_id'));
        }

        if ($request->input('parcours_id')) {
            $users->where('parcours_id', $request->input('parcours_id'));
        }

        $users = $users->get();

        if ($request->header('HX-Request')) {
            return view('admin.partials.table_students', [
                'users' => $users,
                'diplome_prepare_id' => $request->input('diplome_prepare_id'),
                'p_id' => $request->input('parcours_id')
            ]);
        } else {
            return view('admin.dashboard_students', [
                'users' => $users,
                'parcours' => Parcours::all(),
                'diplomes' => DiplomePrepare::all(),
                'diplome_prepare_id' => $request->input('diplome_prepare_id'),
                'p_id' => $request->input('parcours_id')
            ]);
        }
    }

    public function filterTeachers(Request $request)
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $teachers = Professeur::query();

        if ($request->input('filter_teachers')) {
            if ($request->input('filter_teachers') == 1) {
                $teachers->whereHas('users');
            }
            if ($request->input('filter_teachers') == 00) {
                $teachers->whereDoesntHave('users');
            }
        }

        $teachers = $teachers->get();

        if (request()->header('HX-Request')) {
            return view('admin.partials.table_teachers', [
                'teachers' => $teachers,
                'filter_teachers' => $request->input('filter_teachers')
            ]);
        } else {
            return view('admin.dashboard_teachers', [
                'teachers' => $teachers,
                'filter_teachers' => $request->input('filter_teachers')
            ]);
        }
    }
}
