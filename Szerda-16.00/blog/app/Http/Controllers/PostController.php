<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        // if(!Auth::check()) {
        //     return redirect('posts');
        // }
        return view('posts.create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('posts');
        }
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
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $cover_image_path = 'cover_image_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put(
                $cover_image_path,
                $file->get()
            );
        }
        //objektum létrehozása és mentése
        $post = Post::factory()->create([
            'title'             => $validated['title'],
            'description'       => $validated['description'],
            'text'              => $validated['text'],
            'cover_image_path'  => $cover_image_path,
            'author_id'         => Auth::id(), // $request->user()->id, //Auth::id()
        ]);
        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }
        //redirect
        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }
        Session::flash('post_created');
        //redirect
        return redirect()->route('posts.show',$post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post,
        ]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // if(!($post->author && Auth::id() == $post->author->id))
        // {
        //     return redirect()->route('posts.index');
        // }
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if(!($post->author && Auth::id() == $post->author->id))
        {
            return redirect()->route('posts.index');
        }
        $validated = $request->validate([
            'title'                 => 'required|min:5|max:256',
            'description'           => 'nullable',
            'text'                  => 'required',
            'categories'            => 'nullable|array',
            'categories.*'          => 'numeric|integer|exists:categories,id',
            'cover_image'           => 'nullable|file|mimes:jpg,bmp,png|max:4096',
            'remove_cover_image'    => 'nullable|boolean',
        ]);
        //fájl objektum feldolgozása, képfájl nevének generálása, elmentése publikus storage-ba
        $cover_image_path = $post->cover_image_path;
        if(isset($validated['remove_cover_image'])) {
            $cover_image_path = null;
        }
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $cover_image_path = 'cover_image_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put(
                $cover_image_path,
                $file->get()
            );
        }
        if($cover_image_path != $post->cover_image_path && $post->cover_image_path != null) {
            Storage::disk('public')->delete($post->cover_image_path);
        }
        //objektum létrehozása és mentése
        $post->title = $validated['title'];
        $post->description = $validated['description'];
        $post->text = $validated['text'];
        $post->cover_image_path = $cover_image_path;
        $post->save();
        
        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }
        Session::flash('post_updated');
        //redirect
        return redirect()->route('posts.show',$post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
