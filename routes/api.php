<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SubjectController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth'])->get('/subjects', [SubjectController::class, 'get']);
Route::middleware(['auth'])->get('/subject/{id}', [SubjectController::class, 'getOne']);
Route::middleware(['auth'])->post('/subject', [SubjectController::class, 'store']);
Route::middleware(['auth'])->put('/subject/{id}', [SubjectController::class, 'update']);
Route::middleware(['auth'])->delete('/subject/{id}', [SubjectController::class, 'destroy']);


