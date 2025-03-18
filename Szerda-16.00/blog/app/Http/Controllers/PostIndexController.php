<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostIndexController extends Controller
{
    /**

     * Show the profile for a given user.

     */

    public function show(): View
    {
        return view('posts.index', [
            'posts' => Post::all(),
            'categories' => Category::all(),
            'users' => User::all(),
        ]);
    }
}
