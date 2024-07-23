@extends('layouts.admin.admin_main')
@section('title', 'Add User')
@section('content')


<div class="main-content" id="mainContent">
    <!-- Form for creating a new user -->
    <form action="#" id="add-user-form" method="POST" enctype="multipart/form-data" class="mx-auto border rounded p-4">
        @csrf
        <h3 class="my-4 text-center">Add User</h3>

        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-md-12 col-lg-10">
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-sm-2  col-form-label">Email</label>
            <div class=" col-md-12 col-lg-10">
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-md-12 col-lg-10">
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="profile_photo" class="col-sm-2 col-form-label">Profile Photo</label>
            <div class=" col-sm-10">
                <input type="file" class="form-control mt-3" id="profile_photo" name="profile_photo" accept="image/*">
                <div class="mt-2">
                    <img id="photo_preview" src="" width="150" alt="Image preview" style="display:none;">
                </div>
            </div>
        </div>

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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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