<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //adatok validálása
        $validated = $request->validate([
            'name' => 'required|min:3|max:12|unique:categories',
            'style' => [
                'required',
                Rule::in(Category::$styles),
            ],
        ],[
            'name.required' => 'THE NAME IS MANDATORY!!!',
            'required' => 'THIS FIELD IS MANDATORY!!!'
        ]);
        
        //objektum létrehozása és mentése
        Category::factory()->create($validated);
        //success msg eltárolása
        Session::flash('category_created');
        Session::flash('name',$validated['name']);
        Session::flash('style',$validated['style']);
        //redirect
        return redirect()->route('categories.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
