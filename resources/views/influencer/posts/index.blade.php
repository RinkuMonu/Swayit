@extends('influencer.layout.main')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Your Facebook Posts</h4>
    @if($posts->count())
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($post->image_url)
                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $post->id }}">
                                <img src="{{ $post->image_url }}" class="card-img-top" alt="Facebook image" style="height: 200px; object-fit: cover;">
                            </a>
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No image">
                        @endif

                        <div class="card-body">
                            <p class="card-text">{{ $post->caption ?? 'No description available.' }}</p>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <small><i class="fas fa-thumbs-up"></i> {{ $post->likes ?? 0 }} Likes</small>
                            <small><i class="fas fa-comment"></i> {{ $post->comments ?? 0 }} Comments</small>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="imageModal{{ $post->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $post->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel{{ $post->id }}">Post Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ $post->image_url }}" class="img-fluid" alt="Full Facebook image">
                                <p class="mt-3">{{ $post->caption }}</p>
                                <div class="text-muted">
                                    <i class="fas fa-thumbs-up"></i> {{ $post->likes ?? 0 }} Likes &nbsp; | &nbsp;
                                    <i class="fas fa-comment"></i> {{ $post->comments ?? 0 }} Comments
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">No Facebook posts found.</p>
    @endif
</div>
@endsection
