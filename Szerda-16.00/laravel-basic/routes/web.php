<?php

use App\Models\Blogpost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::redirect('/', '/test');

Route::get('/hello', function () {
    return response('<h1>Hello world!</h1>')->header('Content-Type','text/plain');
});

Route::get('/test/{id?}', function ($id = -1) {
    return view('test',[
        'id' => $id,
        'name' => 'Gipsz Jakab',
        'to_iterate' => [
            'alma',
            'korte',
            'banan',
            'dio' 
        ]
    ]);
})->where('id', '[0-9]+');

Route::get('/search', function (Request $request) {
    return response($request->name.' '.$request->id);
});


// Route::get('/blog/{id?}', function ($id = -1) {
//     return view('blog',[
//         'id' => $id,
//         'posts' => Post::all(),
//         'post' => Post::find($id),
//     ]);
// })->where('id', '[0-9]+');


Route::get('/blog/{id?}', function ($id = -1) {
    return view('blog',[
        'id' => $id,
        'posts' => Blogpost::all(),
        'post' => Blogpost::find($id),
    ]);
})->where('id', '[0-9]+');
