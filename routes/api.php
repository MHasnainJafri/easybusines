<?php

use App\Http\Controllers\AdminnumberController;
use App\Http\Controllers\InvestmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\UserprofileControlller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//  Authorization group


Route::middleware('auth:sanctum')->group(function () {
    Route::post('changepin', [MainController::class, 'changepin']);
    Route::post('logout', [MainController::class, 'logout']);
    // Route::post('homeprofile', [MainController::class, 'homeprofile']);


    Route::get('investment' , [InvestmentController::class , 'Investment']);
    Route::get('totalinvestments' , [InvestmentController::class , 'totalinvestments']);
    Route::get('totalprofit' , [ProfitController::class , 'totalprofit']);
    Route::get('investmentgraph' , [InvestmentController::class , 'investmentgraph']);

    // User controller in auth


    Route::get('showprofile', [UserprofileControlller::class , 'showprofile']);
    Route::post('updateprofile' , [UserprofileControlller::class , 'updateprofile'] );
    Route::post('addcash' ,[PaymentController::class, 'addcash']);
    Route::post('addcash' ,[PaymentController::class, 'addcash']);

});
Route::controller(MainController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('Registerotp', 'Registerotp');
    Route::post('setpin', 'storepin');
    Route::post('login', 'login');
    Route::post('verifyphone', 'Verifyphone');
    Route::post('verifyotp', 'otpverify');
    Route::post('verifyuserpayment/{id}' , 'verifyuserpayment');
    Route::post('createpin' , 'createNewPin');
    // Route::get('login' , 'login');
});

Route::post('adminnumber' ,[AdminnumberController::class,'adminnumber']);
Route::get('showadminnumber' ,[AdminnumberController::class,'showadminnumber']);


// Route::post('verifyuserpayment/{id}' , [MainController::class , 'verifyuserpayment']);




///testing working webhooks
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