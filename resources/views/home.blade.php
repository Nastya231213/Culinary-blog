@extends('layouts.main_with_sidebar')

@section('title', 'Main')

@section('content')
@foreach($posts as $post)
<div class="container_post">
    <h1>{{ $post->title }}</h1>
    <hr>

    @php
    $formattedDate = \Carbon\Carbon::parse($post->created_at)->format('F d, Y');
    @endphp
    <div class="info">
        {{ $formattedDate }} - {{$post->comments_count}} comments
        <span class="views">
            <i class="bi bi-eye"></i> {{$post->views}}
        </span>
    </div>
    <div class="content_of_post">
        {!! Str::limit($post->content, 500) !!}
    </div>
    <a class="continue-reading-link" href="{{route('posts.show',$post->id)}}">Continue Reading >></a>
</div>

@endforeach
<div class="pagination ">
    <a href="{{ $posts->previousPageUrl() }}" class="{{ $posts->onFirstPage() ? 'disabled' : '' }} pagination-btn "><- Previous Page </a>
            <a href="{{ $posts->nextPageUrl() }}" class="{{ !$posts->hasMorePages() ? 'disabled' : '' }}  pagination-btn ">Next Page -></a>
</div>
@endsection