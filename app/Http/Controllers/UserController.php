<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showLoginForm()
    {

        return view('login');
    }

    public function showRegistrationForm()
    {
        return view('registration');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create(
            [
                'full_name' => request('fullName'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                'is_admin' => false,

            ]
        );
        Auth::login($user);
        $user->sendEmailVerificationNotification();
        
        return redirect()->route('home')->with('success', 'Registration successful!');

    }
}
