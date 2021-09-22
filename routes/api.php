<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\StudentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//=================Api endpoints====================

Route::post('createProduct', [ApiController::class, 'createProduct']);
Route::get('listProducts', [ApiController::class, 'listProducts']);
Route::get('searchProduct/{name}', [ApiController::class, 'searchProduct']);
Route::get('singleProduct/{id}', [ApiController::class, 'singleProduct']);
Route::put('updateProduct/{id}', [ApiController::class, 'updateProduct']);
Route::delete('deleteProduct/{id}', [ApiController::class, 'deleteProduct']);

//=================STUDENTS====================

Route::post('register', [StudentController::class, 'register']);
Route::post('login', [StudentController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('profile', [StudentController::class, 'profile']);
    Route::get('logout', [StudentController::class, 'logout']);

    //project
    Route::post('createProject', [ProjectController::class, 'createProject']);
    Route::get('litProjects', [ProjectController::class, 'litProjects']);
    Route::get('projectDetails/{id}', [ProjectController::class, 'projectDetails']);
    Route::delete('deleteProject/{id}', [ProjectController::class, 'deleteProject']);

});