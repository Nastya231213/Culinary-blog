document.addEventListener('DOMContentLoaded', function () {
    var imageInput = document.getElementById('photo');
    var preview = document.getElementById('photo_preview');
    var cropImage = document.getElementById('crop-image');
    var cropper;
    var cropperModal = new bootstrap.Modal(document.getElementById('cropper-modal'));
    var cropButton = document.getElementById('crop-button');
    var cancelButton = document.getElementById('cancel_button');
    var container = document.getElementById('data-container');
    var url = container.getAttribute('data-url');
    var imageType = imageInput.getAttribute('data-image-type');


    var fileToCrop;
    var cropWidth;
    var cropHeight;
    defineImageType();

    cancelButton.addEventListener('click', function () {

        imageInput.value = '';
        preview.src = url;
        if (url === '') {
            preview.style.display = 'none';
        }
    });

    imageInput.addEventListener('change', function (event) {
        var files = event.target.files;
        if (files.length === 0) return;
        fileToCrop = files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
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
    cropButton.addEventListener('click', function () {
        if (!cropper) return;



        var canvas = cropper.getCroppedCanvas({
            width: cropWidth,
            height: cropHeight,
        });

        canvas.toBlob(function (blob) {
            var file = new File([blob], 'photo.jpg', {
                type: 'image/jpeg'
            });
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            imageInput.files = dataTransfer.files;

            preview.src = canvas.toDataURL();
            preview.style.display = 'block';
            cropperModal.hide();
        }, 'image/jpeg');
    }); e
    document.getElementById('cropper-modal').addEventListener('show.bs.modal', function () {
        if (cropper) {
            var canvas = cropper.getCroppedCanvas({
                width: cropWidth,
                height: cropHeight,
            });

            canvas.toBlob(function (blob) {
                var url = URL.createObjectURL(blob);
                preview.src = url;
                preview.style.display = 'block';
            });
        }
    });
    function defineImageType() {
        switch (imageType) {
            case 'category':
                cropHeight = 300;
                cropWidth = 400;
                break;
            case 'profile':
                cropHeight = 400;
                cropWidth = 400;
                break;
            case 'post':
                cropHeight = 400;
                cropWidth = 300;

        }
    }
});