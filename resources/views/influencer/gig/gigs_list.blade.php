@extends('influencer.layout.main')
@section('content')
@if (session()->has('success'))
    <script>
        Swal.fire({
            position: "center",
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Gigs List</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Gigs List</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">

           <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Gig Title</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($gig_list as $list)
                            @php
                                $gig_img = json_decode($list->images);
                                $firstImage = $gig_img[0] ?? null;
                            @endphp
                            <tr>
                                <td>{{ $i++ }}.</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($firstImage)
                                       <img src="{{ asset($firstImage) }}" alt="Gig Image" width="60" height="60" class="me-2 rounded">
                                        @else
                                            <img src="{{ asset('assets/images/ecommerce/01.jpg') }}" alt="Gig Image" width="60" height="60" class="me-2 rounded">
                                        @endif
                                        <a href="{{ route('influencer.view.gigs', $list->id) }}" class="fw-bold text-primary">
                                            {{ \Illuminate\Support\Str::limit($list->title, 30) }}
                                        </a>
                                    </div>
                                </td>
                                <td>${{ $list->price }}.00</td>
                               <td>
                                <span class="badge status-badge {{ $list->status == 1 ? 'badge-success' : 'badge-danger' }}"
                                    data-id="{{ $list->id }}"
                                    data-status="{{ $list->status }}"
                                    style="cursor: pointer">
                                    {{ $list->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                                </td>

                                <td>{{ \Carbon\Carbon::parse($list->created_at)->format('F d, Y') }}</td>
                                <td class="d-flex gap-2">
    <form action="{{ route('influencer.edit.gigs', $list->id) }}" method="GET">
        <button type="submit" class="btn btn-primary fixed-btn">
            <i class="fa fa-edit"></i>
        </button>
    </form>

    <form id="delete-gig-form{{ $list->id }}" action="{{ route('influencer.delete.gigs') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $list->id }}">
        <button type="button" class="btn btn-danger fixed-btn delete-gig-btn" data-id="{{ $list->id }}">
            <i class="fa fa-trash"></i>
        </button>
    </form>
</td>

                                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $gig_list->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete gig buttons
        document.querySelectorAll('.delete-gig-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const gigId = this.getAttribute('data-id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-gig-form' + gigId).submit();
                    }
                });
            });
        });

        // Toggle status buttons
        document.querySelectorAll('.status-badge').forEach(badge => {
            badge.addEventListener('click', function() {
                const gigId = this.getAttribute('data-id');
                const currentStatus = this.getAttribute('data-status');
                const newStatusText = currentStatus == '1' ? 'deactivate' : 'activate';

                Swal.fire({
                    title: `Are you sure you want to ${newStatusText} this gig?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: `Yes, ${newStatusText} it!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('influencer.gigs.toggle.status') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ id: gigId })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Server error');
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    icon: "success",
                                    title: `Gig ${data.new_status == 1 ? 'activated' : 'deactivated'} successfully`,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => location.reload());
                            } else {
                                Swal.fire("Error", data.message || "Something went wrong!", "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("Error", "Server error occurred!", "error");
                            console.error('Fetch error:', error);
                        });
                    }
                });
            });
        });
    });
</script>
@push('css')
<style>
    .fixed-btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        padding: 0;
        border-radius: 6px;
    }

    .action-buttons form,
    .action-buttons a {
        display: inline-block;
    }

    .gap-2 {
        gap: 8px;
    }
</style>


<script>

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.status-badge').forEach(badge => {
        badge.addEventListener('click', function () {
            const gigId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            const newStatus = currentStatus == '1' ? 0 : 1;
            const newStatusText = newStatus == 1 ? 'activate' : 'deactivate';

            Swal.fire({
                title: `Are you sure you want to ${newStatusText} this gig?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: `Yes, ${newStatusText} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('influencer.gigs.toggle.status') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ id: gigId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    icon: "success",
                                    title: `Gig ${data.new_status == 1 ? 'activated' : 'deactivated'} successfully`,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                // Update the badge instantly without page reload
                                const badge = document.querySelector(`.status-badge[data-id="${gigId}"]`);
                                if (badge) {
                                    badge.setAttribute('data-status', data.new_status);
                                    badge.classList.toggle('badge-success', data.new_status == 1);
                                    badge.classList.toggle('badge-danger', data.new_status == 0);
                                    badge.textContent = data.new_status == 1 ? 'Active' : 'Inactive';
                                }
                            } else {
                                Swal.fire("Error", data.message || "Something went wrong!", "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("Error", "Server error occurred!", "error");
                            console.error('Fetch error:', error);
                        });
                }
            });
        });
    });
});
</script>

@endpush
@endsection
