@extends('influencer.layout.main')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>Post to Tiktok</h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
              <svg class="stroke-icon">
                <use href="#stroke-home"></use>
              </svg></a></li>
          <li class="breadcrumb-item">Post</li>
          <li class="breadcrumb-item active">Tiktok Upload</li>
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
          <div class="col-sm-8 col-xl-8">
            <h4>Post Photo or Video to Tiktok</h4>
            <div class="card-body">

              {{-- ✅ Flash Messages --}}
              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {!! session('success') !!}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              <ul class="nav nav-tabs" id="icon-tab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="image-tab" data-bs-toggle="tab" href="#image" role="tab"> <i class="icofont icofont-ui-image"></i>Photo</a></li>
                <li class="nav-item"><a class="nav-link" id="video-tab" data-bs-toggle="tab" href="#video" role="tab"><i class="icofont icofont-ui-video"></i>Video</a></li>
              </ul>
              <br>

              <div class="tab-content" id="icon-tabContent">

                <!-- Image Post -->
                <div class="tab-pane fade show active" id="image" role="tabpanel">
                  <form method= "POST" action="{{ route('uploadTo.tiktok') }}" enctype="multipart/form-data" class="dropzone">
                    @csrf
                    <input type="hidden" name="type" value="image">
                    <div class="m-0 dz-message needsclick">
                      <i class="icon-cloud-up"></i>
                      <h6 class="mb-0">Drop image here or click to upload.</h6>
                    </div>
                    <div class="mb-3">
                      <input type="file" name="media" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                      <input class="form-control" name="caption" type="text" placeholder="Enter the Caption">
                    </div>
                    <div class="checkbox checkbox-dark m-squar mb-2">
                      <input id="schedule_image" type="checkbox" class="schedule-check">
                      <label for="schedule_image">Schedule This Post</label>
                    </div>
                    <div class="mb-3 schedule-time" style="display:none;">
                      <input class="form-control datetimepicker" name="schedule_time" placeholder="Select date and time">
                    </div>
                    <div class="card-footer text-end">
                      <button class="btn btn-primary" type="submit">Submit</button>
                      <button class="btn btn-secondary" type="reset">Cancel</button>
                    </div>
                  </form>
                </div>

                <!-- Video Post -->
                <div class="tab-pane fade" id="video" role="tabpanel">
                  <form class="dropzone" method="POST" action="{{ route('uploadTo.tiktok') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="video">
                    <div class="mb-3">
                      <input type="file" name="media" class="form-control" accept="video/*" required>
                    </div>
                    <div class="mb-3">
                      <textarea class="form-control" name="caption" rows="3" placeholder="Enter the Caption"></textarea>
                    </div>
                    <div class="checkbox checkbox-dark m-squar mb-2">
                      <input id="schedule_video" type="checkbox" class="schedule-check">
                      <label for="schedule_video">Schedule This Post</label>
                    </div>
                    <div class="mb-3 schedule-time" style="display:none;">
                      <input class="form-control datetimepicker" name="schedule_time" placeholder="Select date and time">
                    </div>
                    <div class="card-footer text-end">
                      <button class="btn btn-primary" type="submit">Submit</button>
                      <button class="btn btn-secondary" type="reset">Cancel</button>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>

          <!-- Preview Card -->
          <div class="col-sm-4 col-xl-4">
            <div class="main-content-body tab-pane p-4 border-top-0 active" id="tiktok">
              <div class="card mg-b-20 border">
                <div class="card-header p-4">
                  <div class="media">
                    <div class="media-user me-2">
                      <div class="social-icons"><img src="{{ asset('assets/images/socialconnect/Tiktokpost.png') }}" alt="tiktok icon" style="width: 43px;"></div><span>Tiktok</span>
                    </div>
                    <div class="media-body">
                      <h6 class="mb-0 mg-t-2 ms-2">{{ Auth::user()->name ?? 'Your Name' }}</h6><span class="text-primary ms-2">just now</span>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <p class="mg-t-0">Your Tiktok post preview will appear here after submission.</p>
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
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  document.querySelectorAll('.schedule-check').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      const timePicker = this.closest('form').querySelector('.schedule-time');
      timePicker.style.display = this.checked ? 'block' : 'none';
    });
  });

  flatpickr(".datetimepicker", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    minDate: "today"
  });

  document.addEventListener("DOMContentLoaded", function () {
    if (window.Dropzone) {
      Dropzone.autoDiscover = false;
      document.querySelectorAll("form.dropzone").forEach(function (form) {
        if (form.dropzone) {
          form.dropzone.destroy();
        }
      });
    }
  });

  // Auto-hide alerts after 5 seconds
  setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
      alert.classList.remove('show');
      alert.classList.add('fade');
    });
  }, 5000);
</script>

@endsection
