<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Demande;
use App\Models\Societe;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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
        $demandes = $user->demandes;
        return view('student.index', compact('demandes'));

    }

    public function createRequest(StudentRequest $request)
    {
//        $user = Auth::guard('web')->user();
//        $demandes = $user->demandes;

        $company_id = null;
        if ($request->input('company_id')) {
            $company_id = $request->input('company_id');
        }
        if ($request->input('company_name') && $request->input('company_contact')) {
            $company = Societe::create([
                'name' => $request->input('company_name'),
                'contact' => $request->input('company_contact')
            ]);
        }

        $deposit_date = Carbon::now();
        $demande = Demande::create([
            'theme' => $request->validated()['theme'],
            'memory_problems' => $request->validated()['memory_problems'],
            'global_objective' => $request->validated()['global_objective'],
            'specific_objective' => $request->validated()['specific_objective'],
            'expected_result' => $request->validated()['expected_result'],
            'deposit_date' => $deposit_date,
            'societe_id' => $company_id ? $company_id : $company->id
        ]);

        Auth::guard('web')->user()->demandes()->attach($demande->id);


        return redirect('/student/home');


    }
}
