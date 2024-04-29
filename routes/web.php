<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthStudentController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    \App\Models\Admin::create([
//        'full_name' => 'John Doe',
//        'email' => 'john@example.com',
//        'password' => Hash::make('0000'),
//        'phone_number' => '1234567890',
//    ]);
    return view('welcome');
});

//Gérer l'authentification des étudiants
Route::prefix('/student')->controller(AuthStudentController::class)->group(function () {
    //register
    Route::get('/register', 'signup')->name('student.signup');
    Route::post('/register', 'doSignup');

    //login
    Route::get('/login', 'login')->name('student.login');
    Route::post('/login', 'doLogin');

    //logout
    Route::post('/logout', 'logout')->name('logout');
});

//Gérer la navigation apres la connexion
Route::prefix('/student')->controller(StudentController::class)->group(function () {
    //home
    Route::get('/home', 'home')->name('home');

    //Créer une demande
    Route::post('/request','createRequest')->name('student.createRequest');
});


Route::prefix('/admin')->controller(AuthAdminController::class)->group(function () {
    //login
    Route::get('/login', 'login')->name('admin.login');
    Route::post('/login', 'doLogin');

    //logout
    Route::post('/logout', 'logout')->name('admin.logout');
});

//Gérer la navigation apres connexion de l'admin
Route::prefix('/dashboard')->controller(AdminController::class)->group(function(){
    //dashboard
    Route::get('/', 'dashboard')->name('dashboard');

    //Voir toutes les demandes
    Route::get('/demandes', 'viewRequests')->name('admin.viewRequestsAll');

    //Voir toutes les demandes en attentes
    Route::get('/demandes/attente', 'viewsRequestPending')->name('admin.viewRequestsPending');

    //Voir toutes les demandes traitées
    Route::get('/demandes/traité', 'viewsRequestCompleted')->name('admin.viewsRequestCompleted');

    //Voir une demande en particulier
    Route::get('/demande/{demande}', 'viewRequest')->where([
        'request' => '[0-9]+'
    ])->name('admin.viewRequest');

    //Modifier le statut d'une demande
    Route::post('/demande/{demande}', 'updateRequest')->where([
        'request' => '[0-9]+'
    ])->name('admin.update');

    //Comment user's request
    Route::post('/comment_request/{demande_id}', 'commentRequest')->name('admin.commentRequest');

    //Filtrer les demandes
    Route::get('/filter/demandes', 'filterRequests')->name('admin.filterRequests');
});
