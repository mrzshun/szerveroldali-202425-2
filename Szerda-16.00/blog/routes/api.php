<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('categories/{id?}', function (Request $request, $id = null) {
    if($id) {
        return Category::findOrFail($id);
    }
    return Category::all();
})->where('id','[0-9]+');
