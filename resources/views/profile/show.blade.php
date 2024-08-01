@extends('layouts.main')

@section('title', 'Your profile')
@section('content')
<div class="custom-container mx-auto ">
    <h3 class="text-center"> Your profile</h3>
        <form action="{{route('profile.photo.update')}}" method="POST" enctype="multipart/form-data" id="form-profile">
            @csrf
            @method('PUT')
            <div class="d-flex align-items-center mt-4 flex-column">

            <img  id="photo_preview" src="{{ auth()->user()->profile_photo ? asset('storage/profile_photos/' . auth()->user()->profile_photo) : asset('images/default_profile.jpg') }}" alt="Profile Photo" class="profile-photo">
            <input type="file"  class="form-control w-50 float-start mt-2" name="profile_photo" id="photo" accept="image/*" >
            <button type="submit" class="btn btn-success mt-3">Change Photo</button>
            </div>

        </form>
        <div id="data-container" data-url="{{ !empty($user->profile_photo) ? asset('storage/profile_photos/' . $user->profile_photo) : '' }}" ></div>

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
<div class=" modal fade" id="cropper-modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="crop-image" src="" alt="Crop Image" style="max-width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="cancel_button" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop-button">Crop & Upload</button>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/cropper.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

@endsection