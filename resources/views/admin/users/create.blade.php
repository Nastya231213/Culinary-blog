@extends('layouts.admin.admin_main')
@section('title', 'Add User')
@section('content')


<div class="main-content" id="mainContent">

    <a href="{{route('admin.users.index')}}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> All Users
    </a>
    <form action="{{route('admin.users.store')}}" id="add-user-form" method="POST" enctype="multipart/form-data" class="mx-auto border rounded p-4">
        @csrf
        <h3 class="my-4 text-center">Add User</h3>

        @include('message')

        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-md-12 col-lg-10">
                <input type="text" class="form-control" id="name" name="fullName" required>
            </div>
            @if($errors->has('fullName'))
            <div class="alert alert-danger error-message" role="alert">
                {{$errors->first('fullName')}}
            </div>
            @endif
        </div>

        <div class="row mb-3">
            <label for="email" class="col-sm-2  col-form-label">Email</label>
            <div class=" col-md-12 col-lg-10">
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            @if($errors->has('email'))
            <div class="alert alert-danger error-message" role="alert">
                {{$errors->first('email')}}
            </div>
            @endif
        </div>

        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-md-12 col-lg-10">
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            @if($errors->has('password'))
            <div class="alert alert-danger error-message" role="alert">
                {{$errors->first('password')}}
            </div>
            @endif
        </div>
        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">Confirm password</label>
            <div class="col-md-12 col-lg-10">
                <input type="password" class="form-control" id="password" name="password_confirmation" required>
            </div>

        </div>


        <div class="row mb-3">

            <label for="is_admin" class="col-sm-2 col-form-label">Admin</label>
            <div class="col-md-12 col-lg-10">
                <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin">
                <label class="form-check-label fs-6 fs-md-5" for="is_admin">Check if the user should be an admin</label>
            </div>
            @if($errors->has('admin'))
            <div class="alert alert-danger error-message" role="alert">
                {{$errors->first('admin')}}
            </div>
            @endif
        </div>
        <div class="row mb-3">
            <label for="profile_photo" class="col-sm-2 col-form-label">Profile Photo</label>
            <div class=" col-sm-10">
                <input type="file" class="form-control mt-3" id="photo" name="photo" data-image-type="profile" accept="image/*">
                <div class="mt-2">
                    <img id="photo_preview" src="" width="150" alt="Image preview" style="display:none;">
                </div>
            </div>
            @if($errors->has('profile_photo'))
            <div class="alert alert-danger error-message" role="alert">
                {{$errors->first('profile_photo')}}
            </div>
            @endif
        </div>
        <div id="data-container" data-url=""></div>

        <div class="row mb-3">
            <div class="mx-auto col-sm-6">
                <button type="submit" class="btn btn-primary w-100">Add User</button>
            </div>
        </div>
    </form>
</div>

<!-- Modal for cropping -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

@endsection