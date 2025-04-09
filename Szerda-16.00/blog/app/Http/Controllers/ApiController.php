<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiController extends Controller
{


    public function getCategories(Request $request, string|null $id = null) {
        if($id) {
            return Category::findOrFail($id);
        }
        return Category::all();
    }

    public function store(Request $request) {
        //adatok validálása
        $validated = $request->validate([
            'name' => 'required|min:3|max:12|unique:categories',
            'style' => [
                'required',
                Rule::in(Category::$styles),
            ],
        ]);
        
        //objektum létrehozása és mentése
        $category = Category::factory()->create($validated);
        //redirect
        return response()->json($category,201);
    }

    public function update(Request $request, $id) {
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

    public function destroy(Request $request,$id) {
        $category = Category::findOrFail($id);
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
