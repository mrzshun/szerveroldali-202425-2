<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    // ** ÖSSZETETTEBB VÉGPONTOK ***

    public function usersByCategory(Request $request, $id) {
        $category = Category::findOrFail($id);
        $posts = $category->posts;
        $users = collect([]);
        foreach($posts as $post) {
            if(isset($post->author)) {
                $users[] = $post->author;
            }
        }
        $users = $users->unique();
        return UserResource::collection($users);
    }
    

    public function relatedPosts(Request $request, $id) {
        $post = Post::findOrFail($id);
        $categories = $post->categories;
        $relatedPosts = collect([]);
        foreach($categories as $category) {
            $relatedPosts = $relatedPosts->concat($category->posts);
        }
        $relatedPosts = $relatedPosts->unique('id')->sortBy('id')->values()->all();
        return response()->json($relatedPosts);
    }


    // *** POSTS ***
    // File feltöltés

    public function addFileToPost(Request $request, $id) {
        $post = Post::findOrFail($id);
        $validated = $request->validate([
            'file' => 'required|file|mimes:jpg,png|max:4096',
        ]);
        if(isset($post->cover_image_path)) {
            Storage::disk('public')->delete($post->cover_image_path);
        }
        $file = $request->file('file');
        $cover_image_path = 'cover_image_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put(
            $cover_image_path,
            $file->get()
        );
        $post->cover_image_path = $cover_image_path;
        $post->save();
        return new PostResource($post->load('author')->load('categories'));

    }



    public function getPosts(Request $request, string|null $id = null) {
        if($id) {
            return new PostResource(Post::with('categories')->findOrFail($id));
        }
        return PostResource::collection(Post::with('categories')->get());
    }

    public function storePost(StorePostRequest $request) {
        //adatok validálása
        $validated = $request->validated();
        //fájl objektum feldolgozása, képfájl nevének generálása, elmentése publikus storage-ba
        $cover_image_path = null;

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
        return response(new PostResource($post->load('author')),201);
    }

    public function updatePost(UpdatePostRequest $request, $id) {
        //adatok validálása
        $validated = $request->validated();

        //objektum létrehozása és mentése
        $post = Post::findOrFail($id);

        $post->title = $validated['title'];
        $post->description = $validated['description'];
        $post->text = $validated['text'];

        $post->categories()->sync(isset($validated['categories']) ? $validated['categories'] : []);
        //redirect
        return response(new PostResource($post->load('author')->load('categories')),201);
    }


    public function destroyPost(Request $request, $id) {

        $post = Post::findOrFail($id);
        if(!($request->user()->tokenCan('admin') || ($post->author != null && $post->author->id == $request->user()->id))) {
            return response()->json([
                "message" => "Nincs jogod törölni az adott postot"
            ],403);
        }
        $post->delete();
        //redirect
        return response(status: 204);
    }


    // *** CATEGORIES ***

    public function getCategories(Request $request, string|null $id = null) {
        if($id) {
            return new CategoryResource(Category::with('posts')->findOrFail($id));
        }
        return CategoryResource::collection(Category::with('posts')->get());
    }

    public function storeCategory(StoreCategoryRequest $request) {
        //adatok validálása
        $validated = $request->validated();
        //objektum létrehozása és mentése
        $category = Category::factory()->create($validated);
        //redirect
        return response()->json($category,201);
    }

    public function updateCategory(Request $request, $id) {
        //adatok validálása
        $validated = $request->validate([
            'name' => 'required|min:3|max:12|unique:categories',
            'style' => [
                'required',
                Rule::in(Category::$styles),
            ],
        ]);
        
        //objektum létrehozása és mentése
        $category = Category::findOrFail($id);
        $category->update($validated);
        //redirect
        return response()->json($category,201);
    }

    public function destroyCategory(Request $request,$id) {
        $category = Category::findOrFail($id);

        if(!$request->user()->tokenCan('admin')){
            return response()->json([
                'error' => 'nincs jogosultságod törölni, mert nem vagy admin!',
            ],403);
        }
        $category->delete();
        return response(status:204);
    }

    public function register(Request $request) {
        // validálás
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:5',
        ]);
        if($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()
            ],400);
        }
        // elmentés
        $validated = $validator->validate();
        $user = User::create($validated);
        return response()->json($user);
    }

    public function login(Request $request) {
        // validálás
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()
            ],400);
        }
        // elmentés
        $validated = $validator->validate();

        $user = User::where('email',$validated['email'])->first();
        if(!$user) {
            return response()->json([
                'error' => 'Hibás az email cím',
            ],404);
        }
        if(Auth::attempt($validated)) {
        $token = $user->createToken($user->email,$user->is_admin ? ["admin"]:[""]);
            return response()->json([
                'token' => $token->plainTextToken,
            ]);
        }
        else {
            return response()->json([
                'error' => 'hibás jelszó'
            ], 401);
        }

        return response()->json($user);

    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([],204);
    }


    public function user(Request $request) {
        return $request->user();
    }
}
