<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCommentRequest;
use App\Models\Commentaire;
use App\Models\Demande;
use App\Models\DiplomePrepare;
use App\Models\Societe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function viewRequests(Request $request){
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $demandes = Demande::all();
        if($request->header('HX-Request')){
            return view('admin.partials.table', [
                'demandes' => $demandes,
            ]);
        }else{
            return view('admin.dashboard', [
                'demandes' => $demandes,
                'societes' => Societe::all(),
                'diplomes' => DiplomePrepare::all()
            ]);
        }
    }

    public function viewsRequestPending(Request $request){
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $demandes = Demande::where('request_status', null)->get();
        if ($request->header('HX-Request')) {
            return view('admin.partials.table', [
                'demandes' => $demandes,
            ]);
        }else{
            return view('admin.dashboard', [
                'demandes' => $demandes,
                'societes' => Societe::all(),
                'diplomes' => DiplomePrepare::all()
            ]);
        }
    }

    public function viewsRequestCompleted(Request $request){
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $demandes = Demande::where('request_status', '!=' ,null)->get();
        if($request->header('HX-Request')) {
            return view('admin.partials.table', [
                'demandes' => $demandes,
            ]);
        }else{
            return view('admin.dashboard', [
                'demandes' => $demandes,
                'societes' => Societe::all(),
                'diplomes' => DiplomePrepare::all()
            ]);
        }
    }

    public function viewRequest(Demande $demande, Request $request)
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        if ($request->header('HX-Request')) {
            return view('admin.partials.show', [
                'demande' => $demande
            ]);
        } else {
            return view('admin.show', [
                'demande' => $demande
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
            'demande' => $demande
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

        Session::flash('success', 'Commentaire ajouté avec succès');

        return view('admin.show', [
            'demande' => $demande
        ]);

    }

    public function filterRequests(Request $request)
    {
        if (!auth('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }
//        dd($request->all());
        Session::put('societe_id', $request->input('societe_id'));
        Session::put('diplome_prepare_id', $request->input('diplome_prepare_id'));
        $demandes = Demande::query();

        if($request->input('societe_id')){

            $demandes->where('societe_id', $request->input('societe_id'));
        }

        if($request->input('diplome_prepare_id')){
            $diplome_prepare_id = $request->input('diplome_prepare_id');
            $demandes->whereHas('users', function($query) use ($diplome_prepare_id){
                $query->where('diplome_prepare_id', $diplome_prepare_id);
            });
        }

        $demandes = $demandes->with('users')->get();
        if ($request->header('HX-Request')) {
            return view('admin.partials.table', [
                'demandes' => $demandes,
            ]);
        }else{
            return view('admin.dashboard', [
                'demandes' => $demandes,
                'societes' => Societe::all(),
                'diplomes' => DiplomePrepare::all()
            ]);
        }

    }
}
