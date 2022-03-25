<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home/{page}', [App\Http\Controllers\IndexController::class, 'index']);
Route::get('/home/', [App\Http\Controllers\IndexController::class, 'index']);

Route::get('/test', [App\Http\Controllers\IndexController::class, 'test']);

//todo
Route::get('/diary/createform', [App\Http\Controllers\DiaryController::class, 'createForm']);

Route::get('/diary/{diary}', [App\Http\Controllers\DiaryController::class, 'show']);
Route::post('/diary/create', [App\Http\Controllers\DiaryController::class, 'create']);


Route::Post('/post/{diary}', [App\Http\Controllers\PostController::class, 'create']);
Route::get('/editpost/{diary}/{post}', [App\Http\Controllers\PostController::class, 'updateForm']);
Route::Post('/editpost/{diary}/{post}', [App\Http\Controllers\PostController::class, 'update']);
Route::get('/deletepost/{diary}/{post}', [App\Http\Controllers\PostController::class, 'delete']);


Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
//get userId from auth()
Route::Post('/user', [App\Http\Controllers\UserController::class, 'update']);

Route::Post('/status/create', [App\Http\Controllers\StatusController::class, 'create'])->middleware(\App\Http\Middleware\setstatus::class);

Route::get('/status/deletestatus/{status}', [App\Http\Controllers\StatusController::class, 'deletestatus'])->middleware(\App\Http\Middleware\setstatus::class);
Route::get('/status/{user}/{status}', [App\Http\Controllers\StatusController::class, 'delete'])->middleware(\App\Http\Middleware\setstatus::class);
Route::post('/status/{user}', [App\Http\Controllers\StatusController::class, 'set'])->middleware(\App\Http\Middleware\setstatus::class);



Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
