<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('posts.index');
});


Route::resource('posts', PostController::class);

Route::resource('categories', CategoryController::class);


// Route::get('/posts', function () {
//     return view('posts.index',[
//         'posts' => Post::all(),
//         'categories' => Category::all(),
//         'users' => User::all(),
//     ]);
// })->name('posts.index');

// Route::get('/posts/create', function () {
//     return view('posts.create');
// })->name('posts.create');

// Route::get('/posts/x', function () {
//     return view('posts.show');
// });

// Route::get('/posts/x/edit', function () {
//     return view('posts.edit');
// });

// // -----------------------------------------

// Route::get('/categories/create', function () {
//     return view('categories.create');
// })->name('categories.create');

// Route::get('/categories/x', function () {
//     return view('categories.show');
// });

// // -----------------------------------------

Auth::routes();

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
