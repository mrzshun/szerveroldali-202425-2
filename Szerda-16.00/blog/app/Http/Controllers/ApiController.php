<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiController extends Controller
{
    // *** POSTS ***

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
        $token = $user->createToken($user->email,$user->is_admin ? ["admin"]:["*"]);
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
