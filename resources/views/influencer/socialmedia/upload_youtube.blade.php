@extends('influencer.layout.main')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>New YouTube Post</h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
              <svg class="stroke-icon">
                <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
              </svg></a></li>
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
          <div class="col-sm-8 col-xl-8">
            <h4>Start or Schedule a Post</h4>
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

              <div class="tab-content">
                <!-- Video Post Only -->
                <div class="tab-pane fade show active" id="profile-icon" role="tabpanel">
                  <form class="dropzone" method="POST" action="{{ route('influencer.upload.youtube.video') }}" enctype="multipart/form-data">
                    @csrf
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
            <div class="main-content-body tab-pane p-4 border-top-0 active">
              <div class="card mg-b-20 border">
                <div class="card-header p-4">
                  <div class="media">
                    <div class="media-user me-2">
                      <div class="social-icons"><img src="{{ asset('assets/images/dashboard-5/social/4.png') }}" alt="youtube icon" style="width: 43px;"></div><span>YouTube</span>
                    </div>
                    <div class="media-body">
                      <h6 class="mb-0 mg-t-2 ms-2">{{ auth()->user()->name }}</h6><span class="text-primary ms-2">just now</span>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <p class="mg-t-0">Preview your YouTube video post here once uploaded.</p>
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

  // Auto-hide alerts after 5 seconds
  setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
      alert.classList.remove('show');
      alert.classList.add('fade');
    });
  }, 5000);
</script>

@endsection
