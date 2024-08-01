@extends('layouts.main')

@section('title', 'Your profile')
@section('content')
<div class="custom-container mx-auto ">
    <h3 class="text-center"> Your profile</h3>
    <div class="d-flex align-items-center mt-4 flex-column">
        <img src="{{auth()->user()->profile_photo? asset('storage/profile_photos/auth()->user()->profile_photo'):asset('images/default_profile.jpg')}}" alt="Profile Photo" class="profile-photo">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="file" name="profile_photo" id="profile_photo" accept="image/*" style="display: none;" onchange="this.form.submit()">
            <button type="button" class="btn btn-success mt-3" onclick="document.getElementById('profile_photo').click()">Change Photo</button>

        </form>
    </div>
    <div class="card mb-4 mt-3">
        <div class="card-body text-left">
            <h5 class="card-title mb-2">Full Name:</h5>
            <p class="card-text mb-2">{{auth()->user()->full_name}}</p>
            <h5 class="card-title mb-2">Email:</h5>
            <p class="card-text mb-2">{{auth()->user()->email}}</p>
        </div>
    </div>
    <div class="card mb-4 mt-3">

        <div class="card-body">
            <h4 class="card-title text-center">
                Change Password
            </h4>
            <form action="#" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success ">Update Password</button>

                </div>

            </form>


        </div>
    </div>


</div>
\@endsection