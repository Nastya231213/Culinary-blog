@extends('layouts.admin.admin_main')
@section('title', 'Add User')
@section('content')

<div class="main-content" id="mainContent">

<form action="{{ route('admin.posts.update', $post->id) }}" id="add-user-form"  method="POST" class="mx-auto border rounded p-4 content_of_post" enctype="multipart/form-data">
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

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" class="form-control content_of_post" required>{!!$post->content!!}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Edit Post</button>
    </form>
</div>

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