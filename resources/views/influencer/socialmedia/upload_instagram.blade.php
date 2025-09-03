@extends('influencer.layout.main')
@section('content')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6"><h3>New Post</h3></div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('influencer.dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">Post</li>
                    <li class="breadcrumb-item active">Start a Post</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body add-post">
                <div class="row">

                    <!-- Left: Form Section -->
                    <div class="col-sm-8 col-xl-8">
                        <h4>Start or Schedule a Post</h4>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form id="postForm" action="{{ route('upload.instagram.photo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="post_type" id="postType" value="photo">

                            <ul class="nav nav-tabs" id="icon-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="icon-home-tab" data-bs-toggle="tab" href="#icon-home" role="tab" data-post-type="photo">
                                        <i class="icofont icofont-ui-image"></i> Photo
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-icon-tab" data-bs-toggle="tab" href="#profile-icon" role="tab" data-post-type="video">
                                        <i class="icofont icofont-ui-video"></i> Video
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-icon-tab" data-bs-toggle="tab" href="#contact-icon" role="tab" data-post-type="text">
                                        <i class="icofont icofont-ui-file"></i> Text
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3" id="icon-tabContent">
                                <!-- Photo Tab -->
                                <div class="tab-pane fade show active" id="icon-home" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label" data-bs-toggle="tooltip" title="Upload an image to post on your Instagram account.">Upload Image</label>
                                        <input class="form-control" name="photo" id="photoInput" type="file" accept="image/*">
                                    </div>
                                    <div class="mb-3">
                                        <input class="form-control" name="caption" id="captionPhoto" type="text" placeholder="Enter the Caption">
                                    </div>
                                </div>

                                <!-- Video Tab -->
                                <div class="tab-pane fade" id="profile-icon" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label" data-bs-toggle="tooltip" title="Upload a video to post to your Instagram feed.">Upload Video</label>
                                        <input class="form-control" name="video" id="videoInput" type="file" accept="video/*" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control" name="caption" id="captionVideo" rows="3" placeholder="Video Caption" disabled></textarea>
                                    </div>
                                </div>

                                <!-- Text Tab -->
                                <div class="tab-pane fade" id="contact-icon" role="tabpanel">
                                    <div class="mb-3">
                                        <textarea class="form-control" name="caption" id="captionText" rows="5" placeholder="Write your post..." disabled></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" data-bs-toggle="tooltip" title="You can add an optional image with your text post.">Optional Image for Text Post</label>
                                        <input class="form-control" name="text_photo" id="textPhotoInput" type="file" accept="image/*" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule -->
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="scheduleCheck" name="schedule" value="1">
                                <label class="form-check-label" for="scheduleCheck" data-bs-toggle="tooltip" title="Check this if you want to schedule your post for later.">Schedule This Post</label>
                            </div>

                            <div class="mb-3 mt-2" id="scheduleTimeDiv" style="display:none;">
                                <label class="form-label" data-bs-toggle="tooltip" title="Pick a date and time to automatically publish this post.">Select Date & Time</label>
                                <input type="datetime-local" class="form-control" name="schedule_time">
                            </div>
                            

                            <!-- Submit -->
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button class="btn btn-secondary" type="reset">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Preview Section -->
                    <div class="col-sm-4 col-xl-4">
                        <div class="main-content-body tab-pane p-4 border-top-0 active" id="fb">
                            <div class="card mg-b-20 border">
                                <div class="card-header p-4">
                                    <div class="media">
                                        <div class="media-user me-2">
                                            <div class="social-icons">
                                                <img src="{{ asset('assets/images/socialconnect/instagram.png') }}" alt="instagram icon" style="width: 43px;">
                                            </div>
                                            <span>Instagram</span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-0 mg-t-2 ms-2">Mintrona Pechon Pechon</h6>
                                            <span class="text-primary ms-2">just now</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="mg-t-0">There are many variations of passages of Lorem Ipsum...</p>
                                    <div class="media mg-t-15 profile-footer">
                                        <div class="ms-auto">
                                            <div class="dropdown show">
                                                <a class="new" href="#"><i class="fa fa-heart me-3"></i></a>
                                                <a class="new" href="#"><i class="fa fa-comment me-3"></i></a>
                                                <a class="new" href="#"><i class="fa fa-share-square"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div> <!-- end row -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const postForm = document.getElementById('postForm');
    const postTypeInput = document.getElementById('postType');
    const photoInput = document.getElementById('photoInput');
    const videoInput = document.getElementById('videoInput');
    const textPhotoInput = document.getElementById('textPhotoInput');
    const captionPhoto = document.getElementById('captionPhoto');
    const captionVideo = document.getElementById('captionVideo');
    const captionText = document.getElementById('captionText');
    const photoTabLink = document.getElementById('icon-home-tab');

    function updateFormForTab(tabElement) {
        const postType = tabElement.dataset.postType;
        let actionUrl = '';

        photoInput.disabled = true;
        videoInput.disabled = true;
        textPhotoInput.disabled = true;
        captionPhoto.disabled = true;
        captionVideo.disabled = true;
        captionText.disabled = true;

        photoInput.value = '';
        videoInput.value = '';
        textPhotoInput.value = '';
        captionPhoto.value = '';
        captionVideo.value = '';
        captionText.value = '';

        if (postType === 'photo') {
            postTypeInput.value = 'photo';
            actionUrl = '{{ route("upload.instagram.photo") }}';
            photoInput.disabled = false;
            captionPhoto.disabled = false;
            captionPhoto.name = 'caption';
            photoInput.name = 'photo';
        } else if (postType === 'video') {
            postTypeInput.value = 'video';
            actionUrl = '{{ route("upload.instagram.video") }}';
            videoInput.disabled = false;
            captionVideo.disabled = false;
            captionVideo.name = 'caption';
            videoInput.name = 'video';
        } else if (postType === 'text') {
            postTypeInput.value = 'text';
            actionUrl = '{{ route("upload.instagram.text") }}';
            captionText.disabled = false;
            textPhotoInput.disabled = false;
            captionText.name = 'text_content';
            textPhotoInput.name = 'photo';
        }

        postForm.action = actionUrl;
    }

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        updateFormForTab(e.target);
    });

    const scheduleCheck = document.getElementById('scheduleCheck');
    const scheduleTimeDiv = document.getElementById('scheduleTimeDiv');

    scheduleCheck.addEventListener('change', function() {
        scheduleTimeDiv.style.display = this.checked ? 'block' : 'none';
    });

    updateFormForTab(photoTabLink);

    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

@endsection
