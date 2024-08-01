<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index(Request $request)
    {

        return view('profile.show');
    }
    public function updatePhoto(Request $request){

        $request->validate(
            [
            'profile_photo'=>'required|image|mimes:jpg,jpeg,png|max:2048',
            ]
        );
         $user=Auth::user();
        $photoPath=$request->file('profile_photo')->store('profile_photos','public');

        if($user->profile_photo && Storage::exists('profile_photos/',$user->profile_photo)){
            Storage::delete('public/'.$user->profile_photo);
        }
        $user->profile_photo=basename($photoPath);
        $user->save();
        return redirect()->route('profile.show')->with('successMessage','Photo updated successfully.');
    }
    
}
