<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth')->group(function (){
    //File Routes
    Route::get('/', [FileController::class, 'index'])->name('homepage');
    Route::get('my-files', [FileController::class, 'userFiles'])->name('user.files');
    Route::get('new-file', [FileController::class, 'createForm'])->name("create-file.form");
    Route::post('add-file', [FileController::class, 'addFile'])->name("add.file");
    Route::get('signout', [AuthController::class, 'signOut'])->name('signout');
});


Route::middleware('guest')->group(function (){
    // Login Routes
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');


    //Registration Routes
    Route::get('registration', [AuthController::class, 'registration'])->name('register');
    Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');
});


