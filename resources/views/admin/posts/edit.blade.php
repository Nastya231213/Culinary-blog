@extends('layouts.admin.admin_main')
@section('title', 'Add User')
@section('content')

<div class="main-content" id="mainContent">

    <form action="{{ route('admin.posts.update', $post->id) }}" id="add-user-form" method="POST" class="mx-auto border rounded p-4 content_of_post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <h1>Edit Post</h1>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ $post->title}}" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category_id" class="form-control" required>
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="row mb-3">
            <label for="profile_photo" class="col-sm-2 col-form-label">Main Photo</label>
            <div class=" col-sm-10">
                <input type="file" class="form-control mt-3" id="photo" name="photo" data-image-type="category" accept="image/*">
                <div class="mt-2">
                    <img id="photo_preview" src="{{asset('storage/post_photos/'.$post->main_photo_url)}}" width="150" alt="Image preview" >
                </div>
            </div>
            <div id="data-container" data-url=""></div>

            @if($errors->has('photo'))
            <div class="alert alert-danger error-message" role="alert">
                {{$errors->first('photo')}}
            </div>
            @endif
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" class="form-control content_of_post" required>{!!$post->content!!}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Edit Post</button>
    </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('upload.image', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    });
</script>
@endsection