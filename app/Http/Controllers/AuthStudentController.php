<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthStudentLogInRequest;
use App\Http\Requests\AuthStudentSignUpRequest;
use App\Http\Requests\StudentRequest;
use App\Models\Demande;
use App\Models\Diplome;
use App\Models\DiplomePrepare;
use App\Models\Parcours;
use App\Models\Societe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthStudentController extends Controller
{
    public function signup(): View
    {
        $parcours = Parcours::select('id', 'name')->get();
        $d_prepare = DiplomePrepare::select('id', 'name')->get();
        return view('student.auth.signup', [
            'parcours' => $parcours,
            'd_preparé' => $d_prepare,
        ]);
    }

    public function doSignup(AuthStudentSignUpRequest $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $user_exists = User::where('email', $request->validated()['email'])->exists();

        if ($user_exists) {
            return redirect()->back()->withErrors(['email' => 'Cette adresse email est déjà prise'])->withInput();
        }

        // dd($request->validated());
        $user = User::create($request->validated());

        if ($request->input('bac') && $request->input('bac_option')) {
            diplome::create([
                'name' => 'BAC',
                'school_year' => $request->input('bac'),
                'user_id' => $user->id,
            ]);
        }

        if ($request->input('bts') && $request->input('bts_option')) {
            Diplome::create([
                'name' => 'BTS',
                'school_year' => $request->input('bts'),
                'user_id' => $user->id,
            ]);
        }

        if ($request->input('licence') && $request->input('licence_option')) {
            Diplome::create([
                'name' => 'Licence',
                'school_year' => $request->input('licence'),
                'user_id' => $user->id,
            ]);
        }

        if ($request->input('master') && $request->input('master_option')) {
            Diplome::create([
                'name' => 'Master',
                'school_year' => $request->input('master'),
                'user_id' => $user->id,
            ]);
        }
        return redirect('/student/login')->with('success', 'Votre compte a été créé avec succès. Connectez-vous pour continuer.');
    }

    public function login(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('student.auth.login');
    }

    public function doLogin(AuthStudentLogInRequest $request): RedirectResponse
    {
        $credentials = $request->validated();


        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/student/home');
        }

        return back()->withErrors([
            'email' => 'Adresse email ou mot de passe invalide'
        ])->onlyInput('email');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('web')->logout();
        return to_route('student.login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
    }

    public function forgotPassword(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('student.auth.forgot_password');
    }

    public function doForgotPassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $status = Password::broker('users')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordForm($token){
        return view('student.auth.reset_password_form', ['token' => $token]);
    }

    public function doResetPassword(Request $request){
//        dd($request);
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);


        $status = Password::broker('users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );


        return $status === Password::PASSWORD_RESET
            ? redirect()->route('student.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);

    }
}
