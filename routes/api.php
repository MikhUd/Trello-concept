<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('desks', [\App\Http\Controllers\SpaController::class, 'getDesks']);

Route::post('desks', [\App\Http\Controllers\SpaController::class, 'createDesk']);

Route::get('desks/{id}', [\App\Http\Controllers\SpaController::class, 'showDesk']);

Route::post('desks/{id}', [\App\Http\Controllers\SpaController::class, 'deleteDesk']);

Route::put('desks/{id}', [\App\Http\Controllers\SpaController::class, 'updateDesk']);
///

///
Route::post('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'createTask']);

Route::get('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'getTasks']);

Route::put('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'changeDesk']);

Route::post('task/done/{id}', [\App\Http\Controllers\TaskController::class, 'doneTask']);

Route::post('task/{id}', [\App\Http\Controllers\TaskController::class, 'deleteTask']);

