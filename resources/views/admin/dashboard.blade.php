@extends('layouts.admin.admin_main')
@section('title', 'Dashboard')

<div class="main-content" id="mainContent">
    <h1 class="mb-4">Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Users <i class="bi bi-people-fill"></i></h5>
                    <p class="card-text">Total users: </p>
                    <a href="#" class="btn btn-primary">View All Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Recipes <i class="bi bi-card-list"></i></h5>
                    <p class="card-text">Total recipes: 250</p>
                    <a href="#" class="btn btn-primary">View All Recipes</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Comments <i class="bi bi-chat-dots-fill"></i></h5>
                    <p class="card-text">Total comments: 500</p>
                    <a href="#" class="btn btn-primary">View All Comments</a>
                </div>
            </div>
        </div>
    </div>
</div>