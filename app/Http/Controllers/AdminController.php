<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    public function createUser(){

        return view('admin.users.create');
    }
}
