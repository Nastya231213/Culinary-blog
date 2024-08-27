<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

        $userCount=User::count();
        $postCount=Post::count();
        $categoryCount=Category::count();
        $commentCount=Comment::count();
        return view('admin.dashboard',compact('userCount','postCount','categoryCount'));
    }

    public function showUsers()
    {

        $users = User::paginate(7);
        return view('admin.users.list', compact('users'));
    }
 
    public function showPosts()
    {

        $posts = Post::paginate(7);
        return view('admin.posts.list', compact('posts'));
    }
    public function showCategories()
    {

        $categories = Category::paginate(5);

        return view('admin.categories.list', compact('categories'));
    }
    public function createUser()
    {

        return view('admin.users.create');
    }

    public function createCategory()
    {

        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function createPost()
    {

        $categories = Category::all();
        return view('admin.posts.create', ['categories' => $categories]);
    }
    public function editUser(User $user)
    {

        return view('admin.users.edit', compact('user'));
    }
    public function editCategory(Category $category)
    {


        return view('admin.categories.edit', compact('category'));
    }
    public function editPost(Post $post)
    {
        $categories=Category::all();
        return view('admin.posts.edit', ['post'=>$post,'categories'=>$categories]);
    }

}
