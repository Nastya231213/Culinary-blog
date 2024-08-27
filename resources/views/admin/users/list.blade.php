@extends('layouts.admin.admin_main')
@section('title', 'Users')
@section('content')

<div class="main-content" id="mainContent">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i>Go Back</a>

    <div class="container">
        <h4 class="my-4 text-center">User Management Dashboard</h4>
        <div class="mb-3 text-end">
            <a href="{{route('admin.users.create')}}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Add New User
            </a>
        </div>
        @include('message')
        <div class="table-responsive">

            @if($users->isEmpty())
            <div class="alert alert-info text-center">
                No users available.
            </div>
            @else
            <table class="table striped mt-5">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Is Admin</th>
                        <th scope="col">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id}}</th>
                        <td>{{$user->full_name}}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>

                        <td>
                            <a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-primary btn-sm">Edit</a>

                            <form action="{{route('admin.users.delete',$user->id)}}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
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