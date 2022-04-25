<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
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


Route::middleware('auth')->group(function () {

    //File Routes
    Route::get('/', [FileController::class, 'index'])->name('homepage');
    Route::post('/like-post/{file}',[FileController::class,'likeFile'])->name('like.file');
    Route::post('/unlike-post/{file}',[FileController::class,'unlikeFile'])->name('unlike.file');
    Route::get('my-files', [FileController::class, 'userFiles'])->name('user.files');
    Route::get('/details/{id}', [FileController::class, 'showDetails'])->name('file.details');
    Route::get('new-file', [FileController::class, 'createForm'])->name("create-file.form");
    Route::post('add-file', [FileController::class, 'addFile'])->name("add.file");
    Route::middleware('owner')->group(function () {
        Route::get('update/{file}', [FileController::class, 'updateForm'])->name("update-file.form");
        Route::post('update/{file}', [FileController::class, 'updateFile'])->name("update.file");
        Route::delete('file/{file}', [FileController::class, 'deleteFile'])->name("delete.file");
    });
    Route::delete('file/{file}', [FileController::class, 'deleteFile'])
        ->middleware('admin-owner')->name("delete.file");
    Route::get('download/{file:generated_file_name}', [FileController::class, 'downloadFile'])
        ->middleware('owner-public')->name("file.download");

    //Comment Routes
    Route::post('add-comment', [CommentController::class, 'createComment'])->name("add.comment");
    Route::delete('comment/{comment}', [CommentController::class, 'deleteComment'])
        ->middleware('admin-owner')->name("delete.comment");

    //Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('admin', [AdminController::class, 'index'])->name('admin');
        Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
        Route::post('/update-user/{user}', [AdminController::class, 'changeRole'])->name('update.role');
        Route::delete('delete-user/{user}', [AuthController::class, 'delete'])->name("delete.user");
    });

    Route::get('signout', [AuthController::class, 'signOut'])->name('signout');
});


Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');

    //Registration Routes
    Route::get('registration', [AuthController::class, 'registration'])->name('register');
    Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');
});


