<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\showController;
use App\Http\Controllers\API\PetrosmartformsController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user()->name;
    });

    Route::post('/oilrigdesignregistration', [App\Http\Controllers\API\OilrigformsController::class,'store']);
    Route::post('/fracturingfluiddesignregistration', [App\Http\Controllers\API\FracturingfluidformsController::class,'store']);
    Route::post('/stocktradingregistration', [App\Http\Controllers\API\StocktradingformsController::class,'store']);
    Route::post('/petrosmartregistration', [App\Http\Controllers\API\PetrosmartformsController::class,'store']);
    Route::post('/paperregistration', [App\Http\Controllers\API\PaperformsController::class,'store']);
    Route::post('/businesscaseregistration', [App\Http\Controllers\API\BusinesscaseformsController::class,'store']);
    Route::post('/casestudyregistration', [App\Http\Controllers\API\CasestudyformsController::class,'store']);
    Route::post('/careertalksregistration', [App\Http\Controllers\API\PetrolidacareertalksController::class,'store']);

     
    
    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});