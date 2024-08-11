@extends('layouts.main_with_sidebar')
@section('title', 'Post')
@section('content')
<div class="container_post">
    <h1>{{ $post->title }}</h1>
    <hr>

    @php
    $formattedDate = \Carbon\Carbon::parse($post->created_at)->format('F d, Y');
    @endphp
    <div class="info">{{ $formattedDate }} - <span id="comment-count">0</span> comments</div>

    <div class="content_of_post">
        {!! $post->content !!}
    </div>
</div>

<div class="container-comments">
    <div>
        <h1>Post a comment</h1>
    </div>

    <div><span id="comment">0</span> Comments</div>

    <div class="comment-box">
        <img src="{{ auth()->user()->profile_photo ? asset('storage/profile_photos/' . auth()->user()->profile_photo) : asset('images/default_profile.jpg') }}" alt="">
        <div class="comment-input">
            <input type="text" placeholder="Enter comment" class="user-comment">
            <div class="buttons">
                <button type="submit" id="publish">Publish</button>
            </div>
        </div>
    </div>
    <div class="comment" id="comments-list">
        @foreach($comments as $comment)
        <div class="parents" id="comment-{{ $comment->id }}">
            <img src="{{ $comment->author->profile_photo ? asset('storage/profile_photos/' . $comment->author->profile_photo) : asset('images/default_profile.jpg') }}" alt="">
            <div>
                <h1>{{ $comment->author->full_name }}</h1>
                <p>{{ $comment->content }}</p>
                <div class="engagements">
                    <i class="bi bi-hand-thumbs-up ml-2"></i><span>3</span>
                    <i class="bi bi-hand-thumbs-down"></i><span>3</span>
                    <button class="reply-button" data-comment-id="{{ $comment->id }}">Reply</button>
                </div>
                <span class="date">{{ $comment->created_at->format('F d, Y h:i A') }}</span>
            </div>
        </div>
        <div class="comment-box reply" id="reply-form-{{ $comment->id }}" style="display:none">
            <img src="{{ auth()->user()->profile_photo ? asset('storage/profile_photos/' . auth()->user()->profile_photo) : asset('images/default_profile.jpg') }}" alt="">
            <div class="comment-input">
                <input type="text" class="reply-content" placeholder="Enter your reply">
                <div class="buttons">
                    <button type="submit" class="submit-reply-button" data-comment-id="{{ $comment->id }}" id="publish">Submit Reply</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentInput = document.querySelector('.user-comment');
        const publishButton = document.getElementById('publish');
        const urlSegments = window.location.pathname.split('/');
        const postId = urlSegments[urlSegments.indexOf('posts') + 1];
        const commentContainer = document.getElementById('comments-list'); 

        commentInput.addEventListener('input', function() {
            publishButton.disabled = commentInput.value.trim() === '';
        });
        publishButton.addEventListener(
            'click',
            function() {

                const comment = commentInput.value.trim();
                if (comment) {
                    fetch('{{ route("comments.submit") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                comment: comment,
                                post_id: postId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const newComment = document.createElement('div');
                                newComment.classList.add('parents');

                                newComment.innerHTML = `
    <img src="${data.comment.author_profile_photo}" alt="">
    <div>
        <h1>${data.comment.author_full_name}</h1>
        <p>${data.comment.content}</p>
        <div class="engagements">
            <i class="bi bi-hand-thumbs-up ml-2"></i><span>1</span>
            <i class="bi bi-hand-thumbs-down"></i><span>1</span>
            <button class="reply-button" data-comment-id="${data.comment.id}">Reply</button>
        </div>
        <span class="date">${data.comment.created_at}</span>
    </div>
`;
                                commentContainer.appendChild(newComment);

                                commentInput.value = '';
                                publishButton.disabled = true;
                            } else {
                                alert('Error publishing comment.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred.');
                        });
                }
            }
        )
    });
</script>
@endsection