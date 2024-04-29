<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCommentRequest;
use App\Http\Requests\AuthAdminLogInRequest;
use App\Models\Commentaire;
use App\Models\Demande;
use App\Models\DiplomePrepare;
use App\Models\Societe;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthAdminController extends Controller
{
    public function login(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.auth.login');
    }

    public function doLogin(AuthAdminLogInRequest $request): RedirectResponse
    {
        $credentials = $request->validated();


        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Adresse email ou mot de passe invalide'
        ])->onlyInput('email');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('error', 'Vous devez être connecter pour accéder à cette page.');
    }


}
