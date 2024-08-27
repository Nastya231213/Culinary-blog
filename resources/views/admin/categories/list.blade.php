@extends('layouts.admin.admin_main')
@section('title', 'Categories')
@section('content')

<div class="main-content" id="mainContent">
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i>Go Back</a>

        <h4 class="my-4 text-center">Categories Management Dashboard</h4>
        <div class="mb-3 text-end">
            <a href="{{route('admin.categories.create')}}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Add New Category
            </a>
        </div>
        @include('message')
        <div class="table-responsive">
            @if($categories->isEmpty())
            <div class="alert alert-info text-center">
                No categories available.
            </div>
            @else
            <table class="table striped mt-5">

                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Parent Category</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <th scope="row">{{ $category->id}}</th>
                        <td>{{$category->name}}</td>
                        <td>
                            @if($category->image)
                            <img id="photo_preview" src="{{asset('storage/category_photos/'.$category->image)}}" width="120" alt="Image preview">
                            @else
                            No image
                            @endif
                        </td>
                        <td>
                            @if($category->parent_id)
                            @php
                            $parentCategory = $categories->find($category->parent_id);
                            @endphp
                            {{ $parentCategory ? $parentCategory->name : 'Unknown' }}
                            @else
                            Main Category
                            @endif
                        </td>
                        <td>{{ $category->created_at->format('d M Y') }}</td>

                        <td>
                            <a href="{{route('admin.categories.edit',$category->id)}}" class="btn btn-primary btn-sm">Edit</a>

                            <form action="{{route('admin.categories.delete',$category->id)}}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            @endif
         
        </div>

    </div>
</div>
@endsection