<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        $data=$this->getPopularRecipesAndCategories();
        $data['posts']=Post::orderBy('created_at','desc')->withCount('comments')->paginate(3);
        
        return view('home',$data);
    }
    public function about(){
        $data=$this->getPopularRecipesAndCategories();
        return view('about',$data);
    }
    public function contact(){
        $data=$this->getPopularRecipesAndCategories();
        return view('contact',$data);
    }
    private function getPopularRecipesAndCategories()
    {
        return [
            'popularRecipes' => Post::orderBy('views', 'desc')->take(3)->get(),
            'popularCategories' => Category::withCount('posts')->orderBy('posts_count', 'desc')->take(3)->get(),
        ];
    }
}
