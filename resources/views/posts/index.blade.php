
@extends('layouts.main_with_sidebar')

@section('title', 'Main')

@section('content')
@if(!$posts->isEmpty())
@foreach($posts as $post)
<h3>Found result:</h3>
<div class="container_post">
    <h1>{{ $post->title }}</h1>
    <hr>

    @php
    $formattedDate = \Carbon\Carbon::parse($post->created_at)->format('F d, Y');
    @endphp
    <div class="info">{{ $formattedDate }} - 0 comments</div>

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
@else
<h3 class="mt-3">Noting has been found </h3>

@endif
@endsection