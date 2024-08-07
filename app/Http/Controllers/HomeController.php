<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $posts=Post::orderBy('created_at','desc')->paginate(3);
        $popularRecipes=Post::orderBy('views','desc')->take(3)->get();
        $popularCategories=Category::withCount('posts')->orderBy('posts_count','desc')->take(3)->get();
    
        return view('home',['posts'=>$posts,'popularRecipes'=>$popularRecipes,'popularCategories'=>$popularCategories]);
    }
    
}
