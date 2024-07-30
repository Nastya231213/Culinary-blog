@extends('layouts.admin.admin_main')

@section('title', 'Posts')

@section('content')
<div class="main-content" id="mainContent">
    <div class="container">
        <h4 class="my-4 text-center">Posts Management Dashboard</h4>
        <div class="mb-3 text-end">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Add New Post
            </a>
        </div>
        @include('message')

        <div class="table-responsive">
            @if($posts->isEmpty())
            <div class="alert alert-info text-center">
                No posts available.
            </div>
            @else
            <table class="table striped mt-5">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <th scope="row">{{ $post->id }}</th>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category->name ?? 'No Category' }}</td>
                        <td>{{ $post->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{route('admin.posts.show',$post->id)}}" class="btn btn-success btn-sm">Show the complete post</a>

                            <a href="{{route('admin.posts.edit',$post->id)}}" class="btn btn-primary btn-sm">Edit</a>

                            <form action="{{route('admin.posts.delete',$post->id)}}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <div class="mt-4 p-4">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection