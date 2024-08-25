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