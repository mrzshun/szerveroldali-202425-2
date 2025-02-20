<?php

use App\Models\Blogpost;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/{id?}', function ($id = -1) {
    return view('hello',[
        'id' => $id
    ]);
})->where('id','[0-9]+');


Route::get('/alma', function () {
    return view('alma',[
        'name' => 'Zsigmond',
        'classes' => [
            'szerveroldali',
            'algoritmusok',
        ],
    ]);
});


Route::get('/blog/{id}', function ($id) {
    return view('blog',[
        //'posts' => Post::all(),
        'id' => $id,
        'posts' => Blogpost::all(), //Post::find($id),
    ]);
});
