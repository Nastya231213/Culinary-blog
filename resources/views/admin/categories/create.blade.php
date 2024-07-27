@extends('layouts.admin.admin_main')
@section('title', 'Add User')
@section('content')


<div class="main-content" id="mainContent">
    <a href="{{route('admin.categories.index')}}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> All Categories
    </a>
    <form action="{{route('admin.categories.store')}}" id="add-user-form" method="POST" enctype="multipart/form-data" class="mx-auto border rounded p-4">
        @csrf
        <h3 class="my-4 text-center">Add Category</h3>

        @include('message')

        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-md-12 col-lg-10">
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            @if($errors->has('name'))
            <div class="alert alert-danger error-message" role="alert">
                {{$errors->first('name')}}
            </div>
            @endif
        </div>
        <div class="row mb-3">
            <label for="parent_id" class="col-sm-2 col-form-label">Parent Category</label>
            <div class="col-md-12 col-lg-10">
                <select class="form-control" id="parent_id" name="parent_id">
                    <option value="">Select Parent Category (optional)</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">
                    If you want to create a subcategory, select the parent category from the list. If not, leave it as "Select Parent Category".
                </small>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="profile_photo" class="col-sm-2 col-form-label">Category Photo</label>
            <div class=" col-sm-10">
                <input type="file" class="form-control mt-3" id="photo" name="photo" data-image-type="category" accept="image/*">
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