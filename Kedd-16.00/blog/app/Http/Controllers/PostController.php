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
use PharIo\Manifest\Author;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('posts.index', [
            'posts'     => Post::paginate(6),
            'categories' => Category::all(),
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        return view('posts.create',[
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::check()) {
            return redirect()->route('posts.index');
        }
        $validated = $request->validate([
            'title'         => 'required|min:4|max:10',
            'description'   => 'nullable',
            'text'          => 'required',
            'categories'    => 'nullable|array',
            'categories.*'  => 'numeric|integer|exists:categories,id',
            'cover_image'   => 'file|mimes:jpg,png|max:4096'
        ]);
        $cover_image_path = '';
        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $cover_image_path = 'cover_image_'.Str::random(10).'.'.$file->getClientOriginalExtension();
            Storage::disk('public')->put($cover_image_path,$file->get());
        }
        $post = Post::factory()->create([
            'title'             => $validated['title'],
            'description'       => $validated['description'],
            'text'              => $validated['text'],
            'cover_image_path'  => $cover_image_path == '' ? NULL : $cover_image_path,
            'author_id'         => $request->user()->id,
        ]);
        if(isset($validated['categories']))
        {
            $post->categories()->sync($validated['categories']);
        }
        Session::flash('post_created',$validated['title']);
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if($this->user()->cannot('update',$post)) {
            Session::flash('cannot_delete_post',$post['title']);
            return redirect()->route('posts.index');
        }
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
        // if(!Auth::check() || ($post->author != null && Auth::user()->id != $post->author->id)) {
        //     return redirect()->route('posts.index');
        // }
        if($request->user()->cannot('update',$post)) {
            Session::flash('cannot_delete_post',$post['title']);
            return redirect()->route('posts.index');
        }
        $validated = $request->validate([
            'title'                 => 'required|min:4|max:10',
            'description'           => 'nullable',
            'text'                  => 'required',
            'categories'            => 'nullable|array',
            'categories.*'          => 'numeric|integer|exists:categories,id',
            'cover_image'           => 'file|mimes:jpg,png|max:4096',
            'remove_cover_image'    => 'nullable|boolean',
        ]);
        $cover_image_path = ($post->cover_image_path != null ? $post->cover_image_path : '');
        if(isset($validated['remove_cover_image'])) {
            $cover_image_path = null;
        }
        elseif($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $cover_image_path = 'cover_image_'.Str::random(10).'.'.$file->getClientOriginalExtension();
            Storage::disk('public')->put($cover_image_path,$file->get());
        }
        if($post->cover_image_path != $cover_image_path) {
            Storage::disk('public')->delete($post->cover_image_path);
        }

        $post->title            = $validated['title'];
        $post->description      = $validated['description'];
        $post->text             = $validated['text'];
        $post->cover_image_path = ($cover_image_path == '' ? NULL : $cover_image_path);
        $post->save();

        if(isset($validated['categories']))
        {
            $post->categories()->sync($validated['categories']);
        }

        Session::flash('post_updated',);
        return redirect()->route('posts.show',$post);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //Auth::user()->can('delete',$post);
        $this->authorize('delete',$post);
        Session::flash('post_deleted',$post['title']);
        $post->delete();
        return redirect()->route('posts.index');
        //
    }
}
