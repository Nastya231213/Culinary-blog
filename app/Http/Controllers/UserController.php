<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticationRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    public function register(AuthenticationRequest $request)
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

        return redirect()->route('home')->with('successMessage', 'Registration successful! A verification email has been sent.');
    }
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );
        $credentails = $request->only('email', 'password');
        if (Auth::attempt($credentails)) {
            if (!auth()->user()->is_admin) {
                return redirect()->to('/');
            } else {
            }
        }
        return redirect()->back()->with('errorMessage', 'Invalid email or password. Please try again.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function storeUser(AuthenticationRequest $request)
    {

        $profile_photo = null;
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $photoPath = $photo->store('profile_photos', 'public');
            $profile_photo = basename($photoPath);
        }
        $user = User::create(
            [
                'full_name' => request('fullName'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                'is_admin' =>  $request->has('is_admin') ? 1 : 0,
                'profile_photo' => $profile_photo
            ]
        );
        return redirect()->back()->with(
            'successMessage',
            'New user added successfully! User' . $request->input('fullName') . ' ('
                . $request->input('email') . ' ) has been created with role ' . ($request->has('is_admin') ? 'Administrator' : 'User') . '.'
        );
    }
}
