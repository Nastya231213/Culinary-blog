<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticationRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
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
    public function deleteUser(User $user)
    {

        $user->delete();
        return redirect()->route('admin.users')->with('successMessage', 'User deleted successfully!');
    }
    public function updateUser(Request $request, User $user)
    {
        $validatedData = $request->validate(

            [
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'current_password' => 'sometimes|required_with:new_password|current_password',
                'new_password' => 'sometimes|nullable|min:8|confirmed',
                'profile_photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048'

            ]
        );
        $user->full_name = $validatedData['full_name'];
        $user->email = $validatedData['email'];
        if ($request->filled('new_password')) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($validatedData['new_password']);
            } else {
                return redirect()->back()->withMessage(['errorMessage' => 'Wrong password']);
            }
        }
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $photoPath = $photo->store('profile_photos', 'public');
            $user->profile_photo = basename($photoPath);
        }
        
        $user->save();
        return redirect()->route('admin.users')
        ->with('successMessage', "User '{$user->name}' (ID: {$user->id}) has been updated successfully.");
    }
}
