@extends('influencer.layout.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4">Your Facebook Posts</h4>

            @if($posts->count())
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm p-3">
                                <h6 class="text-truncate">{{ Str::limit($post->caption, 100) ?? 'No Caption' }}</h6>
                                
                                <button class="btn btn-primary mt-2 view-details" 
                                        data-id="{{ $post->id }}">
                                    View Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No posts found.</p>
            @endif
        </div>
    </div>
</div>

<!-- Post Details Modal -->
<div class="modal fade" id="postDetailModal" tabindex="-1" aria-labelledby="postDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Post Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="postImageWrapper" class="mb-3 text-center">
            <img id="postImage" src="" alt="" class="img-fluid" style="max-height: 300px;" />
        </div>
        <p><strong>Caption:</strong> <span id="postCaption"></span></p>
        <p><strong>Likes:</strong> <span id="postLikes"></span></p>
        <p><strong>Comments:</strong> <span id="postComments"></span></p>
        <div class="text-danger mt-2" id="apiError" style="display: none;"></div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.view-details', function () {
    var postId = $(this).data('id');

    $.ajax({
        url: "{{ route('influencer.facebook.details') }}",
        type: "GET",
        data: { id: postId },
        beforeSend: function () {
            $('#postImage').attr('src', '');
            $('#postCaption').text('');
            $('#postLikes').text('');
            $('#postComments').text('');
            $('#apiError').hide().text('');
        },
        success: function (response) {
            $('#postImage').attr('src', response.image || '{{ asset("images/no-image.png") }}');
            $('#postCaption').text(response.caption || 'No caption');
            $('#postLikes').text(response.likes || 0);
            $('#postComments').text(response.comments || 0);

            if (response.error) {
                $('#apiError').show().text(response.error);
            }

            $('#postDetailModal').modal('show');
        },
        error: function () {
            $('#apiError').show().text('Failed to fetch post details.');
            $('#postDetailModal').modal('show');
        }
    });
});
</script>
@endsection
