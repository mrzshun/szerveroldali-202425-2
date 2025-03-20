<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('posts.index', [
            'posts' => Post::all(),
            'categories' => Category::all(),
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create',[
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|min:5|max:256',
            'description'   => 'nullable',
            'text'          => 'required',
            'categories'    => 'nullable|array',
            'categories.*'  => 'numeric|integer|exists:categories,id',
            'cover_image'   => 'nullable|file|mimes:jpg,bmp,png|max:4096'
        ]);
        //fájl objektum feldolgozása, képfájl nevének generálása, elmentése publikus storage-ba
        $cover_image_path = null;
        if($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $cover_image_path = 'cover_image_'. Str::random(10).'.'.$file->getClientOriginalExtension();
            Storage::disk('public')->put(
                 $cover_image_path,$file->get()
            );
        }
        //objektum létrehozása és mentése
        $post = Post::factory()->create([
            'title'             => $validated['title'],
            'description'       => $validated['description'],
            'text'              => $validated['text'],
            'cover_image_path'  => $cover_image_path,
        ]);
        if(isset($validated['categories']))
        {
            $post->categories()->sync($validated['categories']);
        }
        //redirect
        return redirect()->route('posts.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
