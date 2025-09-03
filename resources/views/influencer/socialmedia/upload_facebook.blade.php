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

        <form action="{{ route('uploadTofacebook') }}" method="POST" enctype="multipart/form-data" class="dropzone">
          @csrf
           <input type="hidden" name="post_type" id="postType" value="photo">
          <ul class="nav nav-tabs" id="icon-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="icon-home-tab" data-bs-toggle="tab" href="#icon-home" role="tab"><i class="icofont icofont-ui-image"></i> Photo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-icon-tab" data-bs-toggle="tab" href="#profile-icon" role="tab"><i class="icofont icofont-ui-video"></i> Video</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-icon-tab" data-bs-toggle="tab" href="#contact-icon" role="tab"><i class="icofont icofont-ui-file"></i> Text</a>
            </li>
          </ul>

          <br>
          <div class="tab-content" id="icon-tabContent">
            <!-- Photo Tab -->
            <div class="tab-pane fade show active" id="icon-home" role="tabpanel">
              <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <input class="form-control" name="photo" type="file" accept="image/*">
              </div>
              <div class="mb-3">
                <input class="form-control" name="caption_photo" type="text" placeholder="Enter the Caption">
              </div>
            </div>

            <!-- Video Tab -->
            <div class="tab-pane fade" id="profile-icon" role="tabpanel">
              <div class="mb-3">
                <label class="form-label">Upload Video</label>
                <input class="form-control" name="video" type="file" accept="video/*">
              </div>
              <div class="mb-3">
                <textarea class="form-control" name="caption_video" rows="3" placeholder="Video Caption"></textarea>
              </div>
            </div>

            <!-- Text Tab -->
            <div class="tab-pane fade" id="contact-icon" role="tabpanel">
              <div class="mb-3">
                <textarea class="form-control" name="caption_text" rows="5" placeholder="Write your post..."></textarea>
              </div>
            </div>
          </div>

          <!-- Schedule -->
          <div class="checkbox checkbox-dark mt-3">
            <input id="scheduleCheck" type="checkbox" name="schedule">
            <label for="scheduleCheck">Schedule This Post</label>
          </div>

          <div class="mb-3 mt-2" id="scheduleTimeDiv" style="display:none;">
            <label class="form-label">Select Date & Time</label>
            <input type="datetime-local" class="form-control" name="scheduled_at">
          </div>

          <!-- Submit -->
          <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button class="btn btn-secondary" type="reset">Cancel</button>
          </div>

        </form>
      </div>
       <div class="col-sm-4 col-xl-4">
            <div class="main-content-body tab-pane p-4 border-top-0 active" id="fb">
              <div class="card mg-b-20 border">
                <div class="card-header p-4">
                  <div class="media">
                    <div class="media-user me-2">
                      <div class="social-icons"><img src="{{ asset('assets/images/socialconnect/facebook.png') }}" alt="facebook icon" style="width: 43px;"></div><span>TikTok</span>
                    </div>
                    <div class="media-body">
                      <h6 class="mb-0 mg-t-2 ms-2">Mintrona Pechon Pechon</h6><span class="text-primary ms-2">just now</span>
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
          </div>
  </div>
    </div>
    
</div>

<script>
  $(document).ready(function () {

    // 1️⃣ Handle Tab Switching for Post Type
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
      const activeTab = $(e.target).attr('href');

      if (activeTab === '#icon-home') {
        $('#postType').val('photo');
      } else if (activeTab === '#profile-icon') {
        $('#postType').val('video');
      } else if (activeTab === '#contact-icon') {
        $('#postType').val('text');
      }

      $('input[name="photo"]').prop('disabled', activeTab !== '#icon-home');
      $('input[name="video"]').prop('disabled', activeTab !== '#profile-icon');
      $('textarea[name="caption_video"]').prop('disabled', activeTab !== '#profile-icon');
      $('textarea[name="caption_text"]').prop('disabled', activeTab !== '#contact-icon');
    });

    
    const activeTab = $('a[data-bs-toggle="tab"].active').attr('href');
    if (activeTab === '#icon-home') {
      $('#postType').val('photo');
    } else if (activeTab === '#profile-icon') {
      $('#postType').val('video');
    } else if (activeTab === '#contact-icon') {
      $('#postType').val('text');
    }

  
    $('#scheduleCheck').on('change', function () {
      if ($(this).is(':checked')) {
        $('#scheduleTimeDiv').slideDown();
      } else {
        $('#scheduleTimeDiv').slideUp();
      }
    });

    
    setTimeout(function () {
      $(".alert").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
      });
    }, 5000);

  });
</script>


@endsection
