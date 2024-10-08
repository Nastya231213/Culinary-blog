@extends('layouts.admin.admin_main')
@section('title', 'Show the post')
@section('content')

<div class="main-content" id="mainContent">
    <a href="{{route('admin.posts.index')}}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> All Posts
    </a>

    <div class="container_post">
        <h1>{{$post->title}}</h1>
        @php
        $formattedDate=\Carbon\Carbon::parse($post->created_at)->format('F d, Y');

        @endphp
        <div class="info">{{$formattedDate}} - {{$post->comments_count}} comments</div>

        <div class="content_of_post">
            {!! $post->content !!}
        </div>
    </div>
</div>

@endsection