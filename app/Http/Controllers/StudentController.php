<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Demande;
use App\Models\Societe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function home()
    {
        if (!auth('web')->check()) {
            return redirect('/student/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $user = Auth::guard('web')->user();
        $societes = Societe::all();
        $demandes = $user->demandes;
        $users = User::where('id', '!=', $user->id)->get();
        $filter = false;
        return view('student.index', compact('demandes', 'societes', 'users', 'filter'));
    }

    public function back(Request $request)
    {
        if (!auth('web')->check()) {
            return redirect('/student/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $user = Auth::guard('web')->user();
        $societes = Societe::all();
        $demandes = $user->demandes;
        $users = User::where('id', '!=', $user->id)->get();
        $filter = false;

        if ($request->header('HX-Request')) {
            return view('student.partials.main', compact('demandes', 'societes', 'users'));
        } else {
            return view('student.index', compact('demandes', 'societes', 'users', 'filter'));
        }
    }

    public function createRequest(StudentRequest $request)
    {
        // dd($request);
        $user = Auth::guard('web')->user();
        $latestDemande = $user->demandes()->latest()->first();

        $partner = User::find($request->validated()['partner_id']);
        if ($partner) {
            if ($partner->parcours_id != $user->parcours_id) {
                return redirect()->back()->with('error', 'Vous ne pouvez pas faire une demande avec un étudiant d\'un autre parcours.');
            };

            if ($partner->diplome_prepare_id != $user->diplome_prepare_id) {
                return redirect()->back()->with('error', 'Vous ne pouvez pas faire une demande avec un étudiant qui prepare un diplôme autre que le votre.');
            };

            if ($partner->demandes()->latest()->first() && $partner->demandes()->latest()->first()->request_status == null) {
                return redirect()->back()->with('error', 'Votre partenaire a déjà une demande en cours de traitement.');
            }

            if ($partner->demandes()->latest()->first() && $partner->demandes()->latest()->first()->request_status == 1) {
                return redirect()->back()->with('error', 'Votre partenaire a déjà un professeur suiveur.');
            }
        }

        if ($latestDemande && $latestDemande->request_status == null) {
            return redirect()->back()->with('error', 'Vous avez déjà une demande en cours de traitement(pourquoi tu veux faire une requête encore ahy man).');
        }

        if ($latestDemande && $latestDemande->request_status == 1) {
            return redirect()->back()->with('error', 'Vous avez déjà un professeur suiveur(pourquoi tu veux faire une requête encore ahy man).');
        }

        $societe_id = $request->input('choice') ? Societe::create([
            'name' => $request->validated()['company_name'],
            'contact' => $request->validated()['company_contact']
        ])->id : $request->validated()['societe_id'];

        $deposit_date = Carbon::now();
        $demande = Demande::create([
            'theme' => $request->validated()['theme'],
            'memory_problems' => $request->validated()['memory_problems'],
            'global_objective' => $request->validated()['global_objective'],
            'specific_objective' => $request->validated()['specific_objective'],
            'expected_result' => $request->validated()['expected_result'],
            'deposit_date' => $deposit_date,
            'societe_id' => $societe_id
        ]);

        Auth::guard('web')->user()->demandes()->attach($demande->id);
        if ($partner) {
            $partner->demandes()->attach($demande->id);
        }


        return redirect()->back();
    }

    public function viewRequest(Demande $demande, Request $request)
    {

        if (!auth('web')->check()) {
            return redirect('/student/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $users = User::where('id', '!=', Auth::guard('web')->user()->id)->get();
        $societes = Societe::all();

        if ($request->header('HX-Request')) {
            return view('student.partials.show', [
                'demande' => $demande,

            ]);
        } else {
            return view('student.show', [
                'demande' => $demande,
                'users' => $users,
                'societes' => $societes
            ]);
        }
    }

    public function filterRequests(Request $request)
    {
        if (!auth('web')->check()) {
            return redirect('/student/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $demandes = Demande::query();

        if ($request->input('request_status')) {
            if ($request->input('request_status') == 2) {
                $demandes->where('request_status', null);
            } else {
                $demandes->where('request_status', $request->input('request_status'));
            }
        }

        $demandes->whereHas('users', function ($query) {
            $query->where('id', Auth::guard('web')->user()->id);
        });

        $demandes = $demandes->get();

        // return view('student.partials.demandes', compact('demandes'));

        // $demandes = $demandes->with('users')->get();
        if ($request->header('HX-Request')) {
            return view('student.partials.demandes', [
                'demandes' => $demandes,
                'request_status' => $request->input('request_status')
            ]);
        } else {
            return view('student.index', [
                'demandes' => $demandes,
                'request_status' => $request->input('request_status'),
                'users' => User::all(),
                'societes' => Societe::all(),
                'filter' => true,
            ]);
        }
    }
}
