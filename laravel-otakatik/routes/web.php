<?php

use App\Http\Controllers\Halo\HaloController;
use App\Http\Controllers\Todo\TodoController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
}); 


// Route::get('halo', [HaloController::class, 'coba']);

// Route::get('/todo', function () {
//    return view("todo.app");
// });

Route::middleware('auth')->group(function(){
    Route::get('/todo',[TodoController::class,'index'])->name('todo');
    Route::post('/todo',[TodoController::class,'store'])->name('todo.post');
    Route::put('/todo/{id}',[TodoController::class,'update'])->name('todo.update');
    Route::delete('/todo/{id}',[TodoController::class,'destroy'])->name('todo.delete');
    Route::get('/user/update-data',[UserController::class,'updateData'])->name('user.updatedata');
    Route::post('/user/update-data',[UserController::class,'doUpdateData'])->name('user.updatedata.post');
});


Route::middleware('guest')->group(function(){
    Route::get('/user/login', [UserController::class, 'login'])->name('login');
    Route::post('/user/login', [UserController::class, 'doLogin'])->name('login.post');
    Route::get('/user/register', [UserController::class, 'register'])->name('register');
    Route::post('/user/register', [UserController::class, 'doRegister'])->name('register.post');
    Route::get('/user/verifyaccount/{token}', [UserController::class, 'verifyAccount'])->name('user.verifyaccount');
    Route::get('/user/forgotpassword', [ForgotPasswordController::class, 'forgotPasswordForm'])->name('forgotpassword');
    Route::post('/user/forgotpassword', [ForgotPasswordController::class, 'doForgotPasswordForm'])->name('forgotpassword.post');

    Route::get('/user/resetpassword/{token}',[ForgotPasswordController::class, 'resetPassword'])->name('resetpassword');
    Route::post('/user/resetpassword',[ForgotPasswordController::class, 'doResetPassword'])->name('resetpassword.post');
});


Route::get('/user/logout', [UserController::class, 'logout'])->name('logout');

