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

    <div><span id="comment">0</span> Comments</div>

    <div class="comment-box">
        <img src="{{asset('images/default_profile.jpg') }}" alt="">
        <div class="comment-input">

            <input type="text" placeholder="Enter comment" class="user-comment">
            <div class="buttons">
                <button type="submit" id="publish">Publish</button>
            </div>
        </div>
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


</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentInput = document.querySelector('.user-comment');
        const publishButton = document.getElementById('publish');
        const urlSegments = window.location.pathname.split('/');
        const postId = urlSegments[urlSegments.indexOf('posts') + 1];
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
                                alert('Comment published successfully!');
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