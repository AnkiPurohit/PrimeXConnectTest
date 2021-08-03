<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\StockController;

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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'products', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
    Route::post('/import', [ProductController::class, 'import']);

});

Route::group(['prefix' => 'stock', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [StockController::class, 'index']);
    Route::post('/', [StockController::class, 'store']);
    Route::post('/import', [StockController::class, 'import']);
});

Route::prefix('_testing')
    ->middleware(['testing'])
    ->group(__DIR__ . '/it_testing.php');