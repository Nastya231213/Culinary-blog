@extends('layouts.main_with_sidebar')
@section('title','Post')
@section('content')
<div class="container_post">
    <h1>{{ $post->title }}</h1>
    <hr>

    @php
    $formattedDate = \Carbon\Carbon::parse($post->created_at)->format('F d, Y');
    @endphp
    <div class="info">{{ $formattedDate }} - 0 comments</div>

    <div class="content_of_post">
        {!!$post->content!!}
    </div>
</div>

<div class="container-comments">
    <div>
        <h1>Post a comment</h1>
    </div>
    <div class="comment">
        <div class="parents">
            <img src="{{asset('images/default_profile.jpg') }}" alt="">
            <div>
                <h1>Commentator</h1>
                <p>adfffffffffffffffffffadfasfd</p>
                <div class="engagements"><i class="bi bi-hand-thumbs-up"></i><span>3</span>
                    <i class="bi bi-hand-thumbs-down"></i><span>3</span> <button class="reply-button">Reply</button>
                </div>
                <span class="date">July 29, 2024</span>
            </div>
        </div>
        <div class="parents">
            <img src="{{asset('images/default_profile.jpg') }}" alt="">
            <div>
                <h1>Commentator</h1>
                <p>adfffffffffffffffffffadfasfd</p>
                <div class="engagements"><i class="bi bi-hand-thumbs-up ml-2"></i><span>3</span>
                    <i class="bi bi-hand-thumbs-down"></i><span>3</span><button class="reply-button">Reply</button>
                </div>
                <span class="date">July 29, 2024</span>
            </div>
        </div>
    </div>
    <div><span id="comment">0</span> Comments</div>
    <div class="comment-box">
        <img src="{{asset('images/default_profile.jpg') }}" alt="">
        <div class="comment-input">

            <input type="text" placeholder="Enter comment" class="user-comment">
            <div class="buttons">
                <button type="submit" disabled id="publish">Publish</button>
            </div>
        </div>
    </div>



</div>

@endsection