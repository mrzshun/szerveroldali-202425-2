<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getCategories(Request $request, string $id = null) {
        if(isset($id)) {
            return Category::findOrFail($id);
        }
        return Category::all();
    }
    //
}
