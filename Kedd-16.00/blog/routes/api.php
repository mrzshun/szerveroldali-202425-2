<?php

use App\Http\Controllers\ApiController;
use App\Http\Middleware\ValidateURIParams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [ApiController::class,'register'])->name('api.register');
Route::post('login',    [ApiController::class,'login'])->name('api.login');


// Route::get('/user',     [ApiController::class,'user'])->name('api.user')->middleware('auth:sanctum');
// Route::post('/logout',  [ApiController::class,'logout'])->name('api.logout')->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user',                 [ApiController::class,'user'])      ->name('api.user');
    Route::post('/logout',              [ApiController::class,'logout'])    ->name('api.logout');
    Route::post('/categories',          [ApiController::class,'store'])     ->name('api.category.store')    ->where('id','[0-9]+');
    Route::put('/categories/{id}',      [ApiController::class,'update'])    ->name('api.category.update')   ->where('id','[0-9]+');
    Route::delete('/categories/{id}',   [ApiController::class,'destroy'])   ->name('api.category.destroy')  ->where('id','[0-9]+');

    Route::post('posts',                [ApiController::class,'storePost'])     ->name('api.posts.store')   ->where('id','[0-9]+');
    Route::put('posts/{id}',            [ApiController::class,'updatePost'])    ->name('api.posts.update')  ->where('id','[0-9]+');
    Route::delete('posts/{id}',         [ApiController::class,'destroyPost'])   ->name('api.posts.destroy') ->where('id','[0-9]+');

});


Route::get('uri-validation/{number}/{string}/{optional?}',function ($number, $string, $optional) {
    return response()->json([
        'number' => $number,
        'string' => $string,
        'optional' => $optional,
    ]);
})->middleware([ValidateURIParams::class]);

Route::get('categories/{id?}',  [ApiController::class,'getCategories']) ->name('api.category.get')  ->where('id','[0-9]+');
Route::get('posts/{id?}',       [ApiController::class,'getPosts'])      ->name('api.posts.get')     ->where('id','[0-9]+');

Route::get('postsPaginated',    [ApiController::class,'getPostsPaginated']) ->name('api.posts.getPaginated');

