<?php

namespace App\Http\Controllers;

use App\Models\Category;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ApiController extends Controller
{
    public function getCategories(Request $request, string|null $id = null)
    {
        if (isset($id)) {
            $category = Category::find($id);
            if(!$category) {
                return response()->json([],404);
            }
        }
        return Category::all();
    }
    //
    public function store(Request $request) {
        //validáció
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
        $category = Category::factory()->create($validated);
        return response()->json($category,201);
    }

    public function update(Request $request, $id)
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
            $token = $user->createToken($user->email);
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
