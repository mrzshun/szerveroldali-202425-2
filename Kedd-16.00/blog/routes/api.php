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
    Route::get('/user',             [ApiController::class,'user'])  ->name('api.user');
    Route::post('/logout',          [ApiController::class,'logout'])->name('api.logout');
    Route::post('/categories',      [ApiController::class,'store']) ->name('api.store');
    Route::put('/categories/{id}',  [ApiController::class,'update'])->name('api.update');
});

Route::get('uri-validation/{number}/{string}/{optional?}',function ($number, $string, $optional) {
    return response()->json([
        'number' => $number,
        'string' => $string,
        'optional' => $optional,
    ]);
})->middleware([ValidateURIParams::class]);

Route::get('categories/{id?}',[ApiController::class,'getCategories'])->where('id','[0-9]+');

