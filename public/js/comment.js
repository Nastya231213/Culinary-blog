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