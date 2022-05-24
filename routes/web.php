<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PrivateFileController;
use App\Http\Controllers\SearchController;
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
    Route::post('/like-post/{file:generated_file_name}', [FileController::class, 'likeFile'])->name('like.file');
    Route::post('/unlike-post/{file:generated_file_name}', [FileController::class, 'unlikeFile'])->name('unlike.file');
    Route::get('my-files', [FileController::class, 'userFiles'])->name('user.files');
    Route::get('/details/{file:generated_file_name}', [FileController::class, 'showDetails'])->name('file.details');
    Route::get('new-file', [FileController::class, 'createForm'])->name("create-file.form");
    Route::post('add-file', [FileController::class, 'addFile'])->name("add.file");

    Route::middleware('owner')->group(function () {
        Route::get('update/{file:generated_file_name}', [FileController::class, 'updateForm'])->name("update-file.form");
        Route::put('update/{file}', [FileController::class, 'updateFile'])->name("update.file");

        // Private File Share Routes
        Route::get('/private-file-share/{file:generated_file_name}', [PrivateFileController::class, 'showSharePrivateFileForm'])->name('private.file.share.get');
        Route::post('/private-file-share/{file}', [PrivateFileController::class, 'sendPrivateDownloadEmail'])->name('private.file.share.post');
    });
    Route::delete('file/{file:generated_file_name}', [FileController::class, 'deleteFile'])
        ->middleware('admin-owner')->name("delete.file");
    Route::get('download/{file:generated_file_name}', [FileController::class, 'downloadFile'])
        ->middleware('owner-public')->name("file.download");

    Route::delete('/delete-private-file-share/{id}', [PrivateFileController::class, 'deleteShare'])->name('delete.private.share');
    Route::get('download-private-file/{file:generated_file_name}/{receiver_email}', [PrivateFileController::class, 'downloadPrivateFile'])
        ->middleware('can-download-private')->name('download.private.file.get');

    //Comment Routes
    Route::post('add-comment', [CommentController::class, 'createComment'])->name("add.comment");
    Route::delete('comment/{comment}', [CommentController::class, 'deleteComment'])
        ->middleware('admin-owner')->name("delete.comment");

    //Search Routes
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/search-results', [SearchController::class, 'search'])->name('search.results');

    //Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('admin', [AdminController::class, 'index'])->name('admin');
        Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
        Route::put('/update-user/{user}', [AdminController::class, 'changeRole'])->name('update.role');
        Route::delete('delete-user/{user}', [AuthController::class, 'delete'])->name("delete.user");
    });

    Route::get('signout', [AuthController::class, 'signOut'])->name('signout');
});


Route::middleware('guest')->group(function () {
    //Login Routes
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('custom-login', [AuthController::class, 'customLogin'])->middleware("throttle:8,2")->name('login.custom');

    //Registration Routes
    Route::get('registration', [AuthController::class, 'registration'])->name('register');
    Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');

    //Forgot Password Routes
    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forget.password.get');
    Route::post('forgot-password', [ForgotPasswordController::class, 'submitForgotPassword'])->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

});


