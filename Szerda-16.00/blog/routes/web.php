<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostIndexController;
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
Route::get('/home', function () {
    return redirect()->route('posts.index');
});


// Route::get('/posts', function () {
//     return view('posts.index',[
//         'posts' => Post::all(),
//         'categories' => Category::all(),
//         'users' => User::all(),
//     ]);
// })->name('posts.index');


Route::resources([
    'categories' => CategoryController::class,
    'posts' => PostController::class,
]);


// Route::get('/posts', [PostIndexController::class, 'show'])->name('posts.index');


// Route::get('/posts/create', function () {
//     return view('posts.create');
// })->name('post.create');

// Route::get('/posts/{id?}', function ($id) {
//     return view('posts.show',[
//         'post' => Post::find($id),
//     ]);
// })->name('posts.show');

// Route::get('/posts/x/edit', function () {
//     return view('posts.edit');
// });

// // -----------------------------------------

// Route::get('/categories/create', function () {
//     return view('categories.create');
// })->name('category.create');

// Route::get('/categories/x', function () {
//     return view('categories.show');
// });

// -----------------------------------------

Auth::routes();
