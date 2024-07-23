document.addEventListener('DOMContentLoaded', function() {
    var imageInput = document.getElementById('profile_photo');
    var preview = document.getElementById('photo_preview');
    var cropImage = document.getElementById('crop-image');
    var cropper;
    var cropperModal = new bootstrap.Modal(document.getElementById('cropper-modal'));
    var cropButton = document.getElementById('crop-button');

    var fileToCrop;

    imageInput.addEventListener('change', function(event) {
        var files = event.target.files;
        if (files.length === 0) return;
        fileToCrop = files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            cropImage.src = e.target.result;
            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(cropImage, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                ready() {
                    cropperModal.show();
                }
            });

        }
        reader.readAsDataURL(fileToCrop);

    });
    cropButton.addEventListener('click', function() {
        if (!cropper) return;

        var canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400, 
        });

        canvas.toBlob(function(blob) {
            var file = new File([blob], 'profile_photo.jpg', {
                type: 'image/jpeg'
            });
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            imageInput.files = dataTransfer.files;

            preview.src = canvas.toDataURL();
            preview.style.display = 'block';
            cropperModal.hide();
        }, 'image/jpeg');
    });
    document.getElementById('cropper-modal').addEventListener('show.bs.modal', function() {
        if (cropper) {
            var canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });

            canvas.toBlob(function(blob) {
                var url = URL.createObjectURL(blob);
                preview.src = url;
                preview.style.display = 'block';
            });
        }
    });

});