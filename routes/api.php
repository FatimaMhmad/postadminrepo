<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use App\Models\Category;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//auth
Route::group([
    'prefix'     => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});



Route::middleware(['jwt.verify'])->group(function () {
//auth
Route::group([
    'prefix'     => 'auth'
], function ($router)
{
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});

//category
Route::get('/category/index',         [CategoryController::class,'index'])  ;
Route::get('/category/show/{id}',     [CategoryController::class,'show']);
Route::post('/category/store',        [CategoryController::class,'store']);
Route::post('/category/update/{category}',  [CategoryController::class,'update']);
Route::post ('/category/destroy/{category}', [CategoryController::class,'destroy']);

//tag
Route::get ('/tag/index',         [TagController::class,'index']);
Route::post('/tag/store',         [TagController::class,'store']);
Route::post('/tag/update/{tag}',  [TagController::class,'update']);
Route::post ('/tag/destroy/{tag}', [TagController::class,'destroy']);

//post
Route::get ('/post/index',              [PostController::class,'index']);
Route::post('/post/store',              [PostController::class,'store']);
Route::post ('/post/update/{post}',     [PostController::class,'update']);
Route::post ('/post/destroy/{post}',     [PostController::class,'destroy']);

//publish
Route::post ('/post/republishnow/{post}',[PostController::class,'republishnow']);
});

Route::get ('/post/publish',            [PostController::class,'publish']);
