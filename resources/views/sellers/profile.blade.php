
@extends('sellers.partials.app')
@section('title', __('messages.seller_profile_title'))
@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .profile-container {
        max-width: 800px;
        margin: 40px auto;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .profile-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 24px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="password"],
    .form-group input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    .form-group input[type="file"] {
        padding: 5px;
    }

    .form-actions {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .form-actions button {
        padding: 8px 16px;
        font-size: 14px;
    }

    .crop-container {
    margin-top: 20px;
    text-align: center;
    width: 300px; 
    height: 300px; 
    overflow: hidden;
    position: relative;
    margin-left: auto;
    margin-right: auto;
    border-radius: 50%; 
    border: 2px solid #ddd;
}

.cropper-img {
    max-width: 100%;
    height: auto;
}


    .cropper-img {
        max-width: 100%;
        height: auto;
    }

    .crop-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .crop-button:hover {
        background-color: #45a049;
    }

    .submit-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
    }

    .submit-btn:hover {
        background-color: #45a049;
    }

    .reset-btn {
        background-color: #f44336;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
    }

    .reset-btn:hover {
        background-color: #e53935;
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <div class="image-container">
            <img src="{{ Storage::url(auth()->guard('seller')->user()->profile_picture) }}" 
            id="profile-image" 
            class="profile-img"   
            alt="{{ __('messages.profile_picture_alt') }}" 
            />
        </div>
        <h2> {{ $sellerName }} :: {{ __('messages.name') }}</h2>
    </div>

    <div class="profile-content">
        <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="image">{{ __('messages.change_profile_picture') }}</label>
                <input type="file" id="image" name="image" onchange="showCropper(event)">
            </div>

            <div class="crop-container" style="display: none;">
                <div>
                    <img id="cropper-image" class="cropper-img">
                </div>
                <button type="button" id="crop-button" class="crop-button">{{ __('messages.crop_and_save') }}</button>
            </div>

            <div class="form-group">
                <label for="name">{{ __('messages.edit_name') }}</label>
                <input type="text" id="name" name="name" value="{{ $sellerName }}"
                class="@error('name') is-invalid @enderror"
                >
            </div>

            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror 
            
            <div class="form-group">
                <label for="password">{{ __('messages.change_password') }}</label>
                <input type="password" id="password" name="password" placeholder="{{ __('messages.new_password_placeholder') }}"
                class="@error('password') is-invalid @enderror"
                >
            </div>

            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror 

            <div class="form-group">
                <label for="password_confirmation">{{ __('messages.confirm_password') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('messages.new_password_placeholder') }}"
                class="@error('password_confirmation') is-invalid @enderror"
                >
            </div>

            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-actions">
                <button type="submit" class="submit-btn">{{ __('messages.save_changes') }}</button>
                <button type="reset" class="reset-btn">{{ __('messages.reset') }}</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;

    function showCropper(event) {
        const cropperImage = document.getElementById('cropper-image');
        const cropContainer = document.querySelector('.crop-container');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                cropperImage.src = e.target.result;
                cropContainer.style.display = 'block';

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(cropperImage, {
                    aspectRatio: 1,
                    viewMode: 2,
                    autoCropArea: 0.8,
                    responsive: true,
                    movable: true,
                    scalable: true,
                    zoomable: true,
                    rotatable: true,
                });
            };
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('crop-button').addEventListener('click', function() {
        const canvas = cropper.getCroppedCanvas({
            width: 100,
            height: 100,
        });

        const croppedImage = canvas.toDataURL('image/png');
        document.getElementById('profile-image').src = croppedImage;

        const cropContainer = document.querySelector('.crop-container');
        cropContainer.style.display = 'none';
    });
</script>
@endsection
