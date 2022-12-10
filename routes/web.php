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
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home/{page}', [App\Http\Controllers\IndexController::class, 'index']);
Route::get('/home/', [App\Http\Controllers\IndexController::class, 'index']);

Route::get('/test', [App\Http\Controllers\IndexController::class, 'test']);

//todo
Route::get('/diary/createform', [App\Http\Controllers\DiaryController::class, 'createForm']);

Route::get('/diary/edit/{diary}', [App\Http\Controllers\DiaryController::class, 'editForm']);
Route::get('/diary/{diary}', [App\Http\Controllers\DiaryController::class, 'show'])->middleware(\App\Http\Middleware\Whitelist::class);;
Route::post('/diary/create', [App\Http\Controllers\DiaryController::class, 'create']);
Route::get("/diary/whitelist/add/{user}/{diary}", [App\Http\Controllers\DiaryController::class, 'addwhitelist']);
Route::get("/diary/whitelist/delete/{user}/{diary}", [App\Http\Controllers\DiaryController::class, 'deletewhitelist']);
Route::get("/diary/whitelist/on/{diary}/{status}", [App\Http\Controllers\DiaryController::class, 'setWhitelist']);

Route::Post('/post/{diary}', [App\Http\Controllers\PostController::class, 'create']);
Route::get('/editpost/{diary}/{post}', [App\Http\Controllers\PostController::class, 'updateForm']);
Route::Post('/editpost/{diary}/{post}', [App\Http\Controllers\PostController::class, 'update']);
Route::get('/deletepost/{diary}/{post}', [App\Http\Controllers\PostController::class, 'delete']);


Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
Route::Post('/user', [App\Http\Controllers\UserController::class, 'update']);
Route::Post('/user/findusers/', [App\Http\Controllers\UserController::class, 'getUsersByStr']);

Route::Post('/status/create', [App\Http\Controllers\StatusController::class, 'create'])->middleware(\App\Http\Middleware\setstatus::class);

Route::get('/status/deletestatus/{status}', [App\Http\Controllers\StatusController::class, 'deletestatus'])->middleware(\App\Http\Middleware\setstatus::class);
Route::get('/status/{user}/{status}', [App\Http\Controllers\StatusController::class, 'delete'])->middleware(\App\Http\Middleware\setstatus::class);
Route::post('/status/{user}', [App\Http\Controllers\StatusController::class, 'set'])->middleware(\App\Http\Middleware\setstatus::class);



Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);


Route::post('api-login', [ApiController::class, 'authenticate']);
Route::post('api-register', [ApiController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('api-logout', [ApiController::class, 'logout']);
    Route::post('api-get_user', [ApiController::class, 'get_user']);
    Route::get('api-dashboard', [\App\Http\Controllers\RESTApiController::class, 'index']);
    Route::get('api-diary/{diary}', [\App\Http\Controllers\RESTApiController::class, 'diary']);

});
