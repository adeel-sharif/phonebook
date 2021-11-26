<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
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

Route::post('client/login',[LoginController::class, 'userLogin'])->name('userLogin');

Route::group( ['prefix' => 'client','middleware' => ['auth:client','scopes:user'] ],function(){
   // authenticated staff routes here 
    Route::get('dashboard',[LoginController::class, 'userDashboard']);

     //contact routes

    Route::get('contacts/{client_id}',[ContactController::class, 'clients_contacts']);
    Route::post('contact',[ContactController::class, 'store']);
    Route::get('contact/{id}',[ContactController::class, 'show']);
    Route::put('contact/{id}',[ContactController::class, 'update']);
    Route::delete('contact/{id}',[ContactController::class, 'destroy']);
});   