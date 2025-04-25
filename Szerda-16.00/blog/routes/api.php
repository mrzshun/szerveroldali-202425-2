<?php

use App\Http\Controllers\ApiController;
use App\Http\Middleware\ValidateParams;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// authentikációs végpontok
Route::post('/register',    [ApiController::class,'register'])  ->name('api.register');
Route::post('/login',       [ApiController::class,'login'])     ->name('api.login');

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout',  [ApiController::class,'logout'])    ->name('api.logout');
    Route::get('/user',     [ApiController::class,'user'])      ->name('api.user');
});

// Category műveletek
Route::get('categories/{id?}',  [ApiController::class,'getCategories'])     ->name('api.categories.get')    ->where('id','[0-9]+');


Route::middleware('auth:sanctum')->group(function() {
    Route::post('categories',       [ApiController::class,'storeCategory'])             ->name('api.categories.store');
    Route::put('categories/{id}',   [ApiController::class,'updateCategory'])            ->name('api.categories.update') ->where('id','[0-9]+');
    Route::delete('categories/{id}',[ApiController::class,'destroyCategory'])           ->name('api.categories.destroy')->where('id','[0-9]+');
});

Route::get('posts/{id?}',  [ApiController::class,'getPosts'])->name('api.posts.get')->where('id','[0-9]+');

Route::middleware('auth:sanctum')->group(function() {
    Route::post('posts',       [ApiController::class,'storePost'])             ->name('api.posts.store');
    Route::put('posts/{id}',   [ApiController::class,'updatePost'])            ->name('api.posts.update');
    Route::delete('posts/{id}',[ApiController::class,'destroyPost'])           ->name('api.posts.destroy');
});


// request URI paraméterek validálása
Route::get('uri-params1/{number}/{string}/{optional?}', function ($number, $string, $optional = null) {
    return response()->json([
        'number' => $number,
        'string' => $string,
        'optional' => $optional,
    ]);
})->where('number','[0-9]+')->where('string','[a-zA-Z0-9]+');

Route::get('uri-params2/{number}/{string}/{optional?}', function ($number, $string, $optional = null) {
    return response()->json([
        'number' => $number,
        'string' => $string,
        'optional' => $optional,
    ]);
})->middleware(ValidateParams::class);





