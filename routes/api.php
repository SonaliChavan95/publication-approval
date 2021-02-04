<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicationController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

// Route::get('/publications', [PublicationController::class, 'index']);
// Route::post('/publications', [PublicationController::class, 'store']);

// Route::prefix('/publication')->group(function() {
//   // Route::post('/store', [PublicationController::class, 'store']);
//   Route::put('/{id}', [PublicationController::class, 'update']);
//   // Route for approval / rejection
//   Route::put('/{id}/update_status', [PublicationController::class, 'update_status']);
// });

Route::get('/publications/{publication}/approve', [PublicationController::class, 'approve']);
Route::get('/publications/{publication}/reject', [PublicationController::class, 'reject']);
Route::apiResource('publications', PublicationController::class);