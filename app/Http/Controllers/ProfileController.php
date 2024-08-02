<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index(Request $request)
    {

        return view('profile.show');
    }
    public function updatePhoto(Request $request)
    {

        $request->validate(
            [
                'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]
        );
        $user = Auth::user();
        $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');

        if ($user->profile_photo && Storage::exists('profile_photos/', $user->profile_photo)) {
            Storage::delete('public/' . $user->profile_photo);
        }
        $user->profile_photo = basename($photoPath);
        $user->save();
        return redirect()->route('profile.show')->with('successMessage', 'Photo updated successfully.');
    }
    public function updatePassword(Request $request)
    {

        $request->validate(
            [
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]
        );
        $user = Auth::user();
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('errorMessage', 'Current password is incorrect');
            ;
        }
        $user->password = Hash::make($request->input('new_password'));
        $user->save();
        return redirect()->route('profile.show')->with('successMessage', 'Password updated successfully.');
        ;
    }
}
