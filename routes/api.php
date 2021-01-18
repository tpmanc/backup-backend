<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DatabaseController;
use App\Http\Controllers\Api\DatabaseBackupsController;
use App\Http\Controllers\Api\FilesController;
use App\Http\Controllers\Api\FilesBackupsController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\ServerController;
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

 Route::middleware('auth:api')->group( function(){
     Route::get('/projects', [ProjectsController::class, 'all']);
 });


Route::get('/project/{id}', [ProjectsController::class, 'get']);
Route::post('/project/save', [ProjectsController::class, 'save']);
Route::post('/project/delete', [ProjectsController::class, 'delete']);

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

Route::get('/servers', [ServerController::class, 'all']);
Route::get('/server/{id}', [ServerController::class, 'get']);
Route::post('/server/save', [ServerController::class, 'save']);
Route::post('/server/delete', [ServerController::class, 'delete']);

Route::get('/databases', [DatabaseController::class, 'all']);
Route::get('/database/{id}', [DatabaseController::class, 'get']);
Route::post('/database/save', [DatabaseController::class, 'save']);
Route::post('/database/run', [DatabaseController::class, 'run']);

Route::get('/files', [FilesController::class, 'all']);
Route::get('/files/{id}', [FilesController::class, 'get']);
Route::post('/files/save', [FilesController::class, 'save']);
Route::post('/files/delete', [FilesController::class, 'delete']);
Route::post('/files/run', [FilesController::class, 'run']);

Route::get('/database-backups', [DatabaseBackupsController::class, 'all']);
Route::get('/files-backups', [FilesBackupsController::class, 'all']);
