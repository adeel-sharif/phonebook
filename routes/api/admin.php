<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('admin/login',[LoginController::class, 'adminLogin'])->name('admin_Login');
Route::post('admin/register',[LoginController::class, 'adminRegister'])->name('admin_Register');
Route::group( ['prefix' => 'admin','middleware' => ['auth:admin','scope:admin' ]],function(){
   // authenticated staff routes here 
    Route::get('dashboard',[LoginController::class, 'adminDashboard']);

    //clients routes
    Route::get('clients',[ClientController::class, 'index']);
    Route::post('client',[ClientController::class, 'store']);
    Route::get('client/{id}',[ClientController::class, 'show']);
    Route::put('client/{id}',[ClientController::class, 'update']);
    Route::delete('client/{id}',[ClientController::class, 'destroy']);

    //contact routes

    Route::get('contacts',[ContactController::class, 'index']);
    Route::post('contact',[ContactController::class, 'store']);
    Route::get('contact/{id}',[ContactController::class, 'show']);
    Route::put('contact/{id}',[ContactController::class, 'update']);
    Route::delete('contact/{id}',[ContactController::class, 'destroy']);
});