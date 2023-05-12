<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.index');
});
Route::get('index' , [AdminController::class, 'index'])->name('home');
Route::get('showusers' , [AdminController::class, 'Allusers'])->name('allusers');

Route::get('adduser' , [AdminController::class, 'adduser']);
Route::post('uploaduser' , [AdminController::class, 'uploaduser']);
Route::get('showuser/{id}' , [AdminController::class, 'showuser']);
Route::get('show/{id}' , [AdminController::class, 'show']);

Route::get('block/{id}' , [AdminController::class, 'block']);
Route::get('unblock/{id}' , [AdminController::class, 'unblock']);
Route::post('update/{id}' , [AdminController::class, 'updateuser']);
Route::get('delete/{id}' , [AdminController::class, 'delete']);
Route::get('payments' , [AdminController::class, 'payments'])->name('allpayments');
Route::get('action/{id}' , [AdminController::class, 'action'])->name('action');
Route::get('verify/{id}' , [AdminController::class, 'verify'])->name('verify');
Route::get('reject/{id}' , [AdminController::class, 'reject'])->name('reject');
Route::get('investments' , [AdminController::class, 'investment'])->name('investment');

Route::controller(ProfitController::class)->group(function(){
    Route::get('profit/{id}' ,'userdetail')->name('addprofit');
    Route::post('userprofit/{id}' ,'userprofit')->name('userprofit');


});
