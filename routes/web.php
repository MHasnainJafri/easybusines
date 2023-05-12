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
//web hook added
Route::post('/webhook', function () {
    // Get the payload from the GitHub webhook request
    $payload = json_decode(request()->getContent());

    // Check if the payload is valid and contains the correct event type
    if (!$payload || request()->header('X-GitHub-Event') !== 'push') {
        return response()->json(['error' => 'Invalid payload or event type'], 400);
    }

    // Specify the branch to pull changes from
    $branch = 'master';

    // Change to the root directory of your Laravel project on the cPanel server
    chdir('/home/uaedubaivisa/public_html/easybussiness2');

    // Pull the latest changes from the GitHub repository for the specified branch
    exec('git pull origin ' . $branch);

    return response()->json(['message' => 'Webhook successfully executed'], 200);
});
