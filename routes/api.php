<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\showController;


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
    Route::get('/profile', function (Request $request) {
        return auth()->user()->name;
    });

    Route::post('/oilrigdesignregistration', [App\Http\Controllers\API\OrdcController::class, 'store']);
    Route::post('/fracturingfluiddesignregistration', [App\Http\Controllers\API\FfdController::class, 'store']);
    Route::post('/stocktradingregistration', [App\Http\Controllers\API\StockController::class, 'store']);
    Route::post('/petrosmartregistration', [App\Http\Controllers\API\PetrosmartController::class, 'store']);
    Route::post('/paperregistration', [App\Http\Controllers\API\PaperController::class, 'store']);
    Route::post('/businesscaseregistration', [App\Http\Controllers\API\BusinessController::class, 'store']);
    Route::post('/casestudyregistration', [App\Http\Controllers\API\CaseController::class, 'store']);
    // Route::post('/careertalksregistration', [App\Http\Controllers\API\PetrolidacareertalksController::class,'store']);



    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});
