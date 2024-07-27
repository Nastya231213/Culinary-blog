<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){

        return view('admin.dashboard');
    }
  
    public function showUsers(){

        $users = User::paginate(5); 
        return view('admin.users.list',compact('users'));

    }
    public function showCategories(){

        $categories = Category::paginate(5); 
        return view('admin.categories.list',compact('categories'));

    }
    public function createUser(){

        return view('admin.users.create');
    }

    public function createCategory(){

        $categories=Category::whereNull('parent_id')->get();
        return view('admin.categories.create',compact('categories'));
    }
    public function editUser(User $user){

        return view('admin.users.edit',compact('user'));
    }
    public function editCategory(Category $category){

        
        return view('admin.categories.edit',compact('category'));
    }
}
