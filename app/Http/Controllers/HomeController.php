<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::whereNull('parent_id')->with('subcategories')->get();
        return view('home',compact('categories'));
    }
    
}
