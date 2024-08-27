@extends('layouts.admin.admin_main')
@section('title', 'Dashboard')
@section('content')
<div class="main-content" id="mainContent">
    <h1 class="mb-4">Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Users <i class="bi bi-people-fill"></i></h5>
                    <p class="card-text">Total users: {{$userCount}}</p>
                    <a href="{{route('admin.users.index')}}" class="btn btn-primary">View All Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Recipes <i class="bi bi-card-list"></i></h5>
                    <p class="card-text">Total recipes: {{$postCount}}</p>
                    <a href="{{route('admin.posts.index')}}" class="btn btn-primary">View All Recipes</a>
                </div>
            </div>
        </div>
     
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Categories <i class="bi bi-tags-fill"></i></h5>
                    <p class="card-text">Total categories:  {{ $categoryCount }}</p>
                    <a href="{{route('admin.categories.index')}}" class="btn btn-primary">View All Categories</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection