<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Post;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ApiController extends Controller
{


    public function usersByCat(Request $request, string|null $id = null){
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

    public function relatedPosts(Request $request, string|null $id = null){
        $post = Post::findOrFail($id);
        $categories = $post->categories;
        $relatedPosts = collect([]);
        foreach($categories as $cat) {
            $relatedPosts = $relatedPosts->concat($cat->posts);
        }
        $relatedPosts = $relatedPosts->unique('id');
        return response($relatedPosts);
    }


    // POSTS
    public function getPosts(Request $request, string|null $id = null)
    {
        if (isset($id)) {
            return new PostResource(Post::with('categories')->findOrFail($id));
        }
        return PostResource::collection(Post::all());
    }

    public function getPostsPaginated(Request $request)
    {
        return new PostCollection(Post::with('author')->paginate(3));
    }
    
    public function storePost(StorePostRequest $request) {
        //validáció
        $validated = $request->validated();
        //létrehozás
        $cover_image_path = '';
        $post = Post::factory()->create([
            'title'             => $validated['title'],
            'description'       => $validated['description'],
            'text'              => $validated['text'],
            'cover_image_path'  => $cover_image_path == '' ? NULL : $cover_image_path,
            'author_id'         => $request->user()->id,
        ]);
        $post->categories()->sync(isset($validated['categories']) ? $validated['categories'] : []);

        return new PostResource($post->load('author')->load('categories'));
    }

    public function updatePost(UpdatePostRequest $request, $id) {
        //validáció
        $validated = $request->validated();
        //létrehozás
        $post = Post::findOrFail($id);

        $post->title            = $validated['title'];
        $post->description      = $validated['description'];
        $post->text             = $validated['text'];

        $post->save();

        $post->categories()->sync(isset($validated['categories']) ? $validated['categories'] : []);

        return new PostResource($post->load('author')->load('categories'));
    }

    
    // CATEGORY
    public function getCategories(Request $request, string|null $id = null)
    {
        if (isset($id)) {
            return new CategoryResource(Category::with('posts')->findOrFail($id));
        }
        return CategoryResource::collection(Category::all());
    }

    public function storeCategory(StoreCategoryRequest $request) {
        //validáció
        $validated = $request->validated();
        $category = Category::factory()->create($validated);
        return response()->json($category,201);
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:4|max:10',
            'style' => [
                'required',
                Rule::in(Category::$styles),
            ],
        ], [
            'name.required' => 'The name field is mandatory!',
            'required' => 'This field is MANDATORY!'
        ]);
        $category = Category::find($id);
        if(!$category) {
            return response()->json([],404);
        }
        // $category->name = $validated['name'];
        // $category->style = $validated['style'];
        $category->update($validated);
        return response()->json($category,201);    
        //
    }

    public function destroyCategory(Request $request, $id)
    {
        $category = Category::find($id);
        if(!$category) {
            return response()->json([],404);
        }
        if(!$request->user()->tokenCan('blog:admin')) {
            return response()->json([
                'error' => 'Nincs jogosultságod törölni a kategóriát!'
            ], 403);
        }
        $category->delete();
        return response(status: 204);
        //
    }



    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()
            ],400);
        }
        $validated = $validator->validated();
        $user = User::create($validated);
        return response()->json([
            'msg' => 'User successfully created.',
            'id' => $user->id
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()
            ],400);
        }
        $validated = $validator->validated();
        $user = User::where('email',$validated['email'])->first();
        if(!$user) {
            return response()->json([
                'error' => 'There is no user with the given email address.',
            ],400);
        }
        if(Auth::attempt($validated)) {
            $token = $user->createToken($user->email,$user->is_admin ? ['blog:admin']:[]);
            return response()->json([
                'token' => $token->plainTextToken,
            ]);
        } else {
            return response()->json([
                'error' => 'Hibás jelszó',
            ], 401);
        }
    }

    public function user(Request $request) {
        return $request->user();
    }

    public function logout(Request $request) {
        //$user = Auth::user();
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'msg' => 'Successful logout',
        ],204);
    }

}
