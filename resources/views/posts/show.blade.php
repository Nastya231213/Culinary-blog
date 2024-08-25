@extends('layouts.main_with_sidebar')
@section('title', 'Post')
@section('content')
<div class="container_post">
    <h1>{{ $post->title }}</h1>
    <hr>

    @php
    $formattedDate = \Carbon\Carbon::parse($post->created_at)->format('F d, Y');
    @endphp
    <div class="info">{{ $formattedDate }} - {{$post->comments_count}} comments</div>

    <div class="content_of_post">
        {!! $post->content !!}
    </div>
</div>

<div class="container-comments">
    <div>
        <h3>Post a comment</h3>
    </div>

    <div><span id="comment">{{$post->comments_count}}</span> Comments</div>

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
        <div class="parents" data-comment-id="{{$comment->id}}" id="comment-{{ $comment->id }}">
            <img src="{{ $comment->author->profile_photo ? asset('storage/profile_photos/' . $comment->author->profile_photo) : asset('images/default_profile.jpg') }}" alt="">
            <div>
                <h1>{{ $comment->author->full_name }}</h1>
                <p>{{ $comment->content }}</p>

                <div class="engagements">
                    <i class="{{ $comment->user_like ? 'bi bi-hand-thumbs-up-fill' : 'bi bi-hand-thumbs-up' }} like-button"
                        data-comment-id="{{ $comment->id }}"
                        data-type="like"></i><span class="likes-count">{{$comment->likes_count}}</span>
                    <i class="{{ $comment->user_dislike ? 'bi bi-hand-thumbs-down-fill' : 'bi bi-hand-thumbs-down' }} dislike-button"
                        data-comment-id="{{ $comment->id }}"
                        data-type="dislike"></i>
                    <span class="dislikes-count">{{ $comment->dislikes_count }}</span>
                    <button class="reply-button" data-comment-id="{{ $comment->id }}">Reply</button>


                </div>

                <span class="date">{{ $comment->created_at->format('F d, Y h:i A') }}</span>
                @if($comment->replies->isNotEmpty())
                <div class="replies-toggler" data-comment-id="{{ $comment->id }}"><i class="bi bi-chevron-down"></i> Show replies</div>
                @endif
            </div>
        </div>

        <div class="reply_container" id="reply-form-{{ $comment->id }}">

            <div class="comment-box" style="display:none;margin-top:-50px">
                <img src="{{ auth()->user()->profile_photo ? asset('storage/profile_photos/' . auth()->user()->profile_photo) : asset('images/default_profile.jpg') }}" alt="">
                <div class="comment-input">
                    <input type="text" class="reply-content" placeholder="Enter your reply">
                    <div class="buttons">
                        <button type="submit" class="submit-reply-button" data-comment-id="{{ $comment->id }}" id="publish">Submit Reply</button>
                    </div>
                </div>
            </div>
            <div class="replies" id="replies-{{$comment->id}}" style="display:none">
                @foreach($comment->replies as $reply)
                <div class="parents">
                    <img src="{{ $reply->author->profile_photo ? asset('storage/profile_photos/' . $reply->author->profile_photo) : asset('images/default_profile.jpg') }}" alt="">
                    <div>
                        <h1>
                            {{$reply->author->full_name}}
                        </h1>
                        <p>{{$reply->content}}</p>
                        <div class="engagements">
                            <i class="bi bi-hand-thumbs-up ml-2"></i><span>{{ $reply->likes_count }}</span>
                            <i class="bi bi-hand-thumbs-down"></i><span>{{ $reply->dislikes_count }}</span>
                            <button class="reply-button" data-comment-id="{{ $comment->id }}">Reply</button>

                        </div>
                        <span class="date">{{ $reply->created_at->format('F d, Y h:i A') }}</span>
                    </div>
                </div>
                @endforeach
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
        const togglerButtons = document.querySelectorAll('.replies-toggler');

        commentInput.addEventListener('input', function() {
            publishButton.disabled = commentInput.value.trim() === '';
        });

        togglerButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const replyContainer = document.getElementById(`replies-${commentId}`);
                if (replyContainer.style.display === 'none' || replyContainer.style.display === '') {
                    replyContainer.style.display = 'block';
                    this.innerHTML = '<i class="bi bi-chevron-up"></i> Hide replies';
                } else {
                    replyContainer.style.display = 'none';
                    this.innerHTML = '<i class="bi bi-chevron-down"></i> Show replies';
                }
            });
        });

        function createCommentElement(comment) {
            const newComment = document.createElement('div');
            newComment.classList.add('parents');
            newComment.innerHTML = `
            <img src="${comment.author_profile_photo}" alt="">
            <div>
                <h1>${comment.author_full_name}</h1>
                <p>${comment.content}</p>
                <div class="engagements">
                    <i class="bi bi-hand-thumbs-up ml-2"></i><span>1</span>
                    <i class="bi bi-hand-thumbs-down"></i><span>1</span>
                    <button class="reply-button" data-comment-id="${comment.id}">Reply</button>
                </div>
                <span class="date">${comment.created_at}</span>
            </div>
        `;
            return newComment;
        }

        commentContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('reply-button')) {
                const commentId = event.target.getAttribute('data-comment-id');
                const commentBox = document.getElementById(`reply-form-${commentId}`)?.querySelector('.comment-box');

                if (commentBox.style.display === 'none' || commentBox.style.display === '') {
                    commentBox.style.display = 'flex';
                } else {
                    commentBox.style.display = 'none';
                }
            }

            if (event.target.classList.contains('like-button') || event.target.classList.contains('dislike-button')) {
                const commentId = event.target.closest('.parents').getAttribute('data-comment-id');
                const type = event.target.getAttribute('data-type');
                const url = `{{ route('comments.reaction') }}`;


                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            type: type,
                            comment_id: commentId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const likesCountElement = event.target.closest('.engagements').querySelector('.likes-count');
                            const dislikesCountElement = event.target.closest('.engagements').querySelector('.dislikes-count');

                            likesCountElement.textContent = data.likes_count;
                            dislikesCountElement.textContent = data.dislikes_count;
                            if (type === 'like') {
                                event.target.classList.toggle('bi-hand-thumbs-up-fill', data.user_reacted);
                                event.target.classList.toggle('bi-hand-thumbs-up', !data.user_reacted);
                                const dislikeButton = document.querySelector('.bi-hand-thumbs-down-fill');
                                if (dislikeButton) {
                                    dislikeButton.classList.remove('bi-hand-thumbs-down-fill');
                                    dislikeButton.classList.add('bi-hand-thumbs-down');
                                }


                            } else {
                                event.target.classList.toggle('bi-hand-thumbs-down-fill', data.user_reacted);
                                event.target.classList.toggle('bi-hand-thumbs-down', !data.user_reacted);
                                const likeButton = document.querySelector('.bi-hand-thumbs-up-fill');
                                if (likeButton) {
                                    likeButton.classList.remove('bi-hand-thumbs-up-fill');
                                    likeButton.classList.add('bi-hand-thumbs-up');
                                }
                            }
                        } else {
                            alert('Error processing request.');
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('An error occurred while processing your request.');
                    });
            }

            if (event.target.classList.contains('submit-reply-button')) {
                const commentId = event.target.getAttribute('data-comment-id');
                const replyContent = document.querySelector(`#reply-form-${commentId} .reply-content`).value.trim();
                if (replyContent) {
                    fetch('{{route("comments.reply")}}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                comment: replyContent,
                                parent_id: commentId,
                                post_id: postId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const newComment = createCommentElement(data.comment);
                                const repliesContainer = document.getElementById(`replies-${commentId}`);
                                repliesContainer.appendChild(newComment);
                                document.querySelector(`#reply-form-${commentId} .reply-content`).value = '';
                                document.getElementById(`reply-form-${commentId}`).style.display = 'none';
                            } else {
                                alert('Error submitting reply.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred.');
                        });
                }
            }
        });

        publishButton.addEventListener('click', function() {
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
                            const newComment = createCommentElement(data.comment);
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
        });
    });
</script>

@endsection