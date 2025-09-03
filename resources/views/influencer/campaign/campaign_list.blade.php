@extends('influencer.layout.main')
@section('content')
<style>
    .user-message {
        background-color: #92ffd0;
        padding: 10px;
        border-radius: 10px;
    }

    .admin-message {
        background-color: #92c5ff;
        padding: 10px;
        border-radius: 10px;
    }

    .user-message span {
        font-size: 11px;
    }

    .admin-message span {
        font-size: 11px;
    }

    .chat-section {
        padding: 20px;
        max-height: 400px;
    }
    .message {
        max-height: 300px !important;
        overflow-y: auto !important;
        padding: 20px !important;
    }
    .message {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
</style>
    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Campaign List</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dashboard</li>
                        <li class="breadcrumb-item active">Campaign List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Campaign Name</th>
                                        <th>Created By</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Approval Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($my_campaign_list as $list)
                                        @php
                                            $campaign = \App\Models\Campaign::where('id', $list->campaign_id)->first();
                                            $campaign_user = \App\Models\User::where('id', $campaign->user_id)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $i }}.</td>
                                            @php $i++; @endphp
                                            <td>{{ $campaign->name }}</td>
                                            <td>{{ $campaign_user->first_name }} {{ $campaign_user->last_name }}</td>
                                            <td>{{ date('F d, Y', strtotime($campaign->start_date)) }}</td>
                                            <td>{{ date('F d, Y', strtotime($campaign->end_date)) }}</td>
                                            <td>
                                                @if ($list->status == 1)
                                                    <span class="badge badge-success">accepted</span>
                                                @elseif($list->status == 2)
                                                    <span class="badge badge-danger">declined</span>
                                                @else
                                                    <span class="badge badge-warning">pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($list->request_status == 1)
                                                    <span class="badge badge-success">accepted</span>
                                                @elseif($list->request_status == 2)
                                                    <span class="badge badge-danger">declined</span>
                                                @else
                                                    <span class="badge badge-warning">wait for response</span>
                                                @endif
                                            </td>
                                            <td class="d-flex">
                                                <div class="m-1">
                                                    <a href="{{ route('influencer.campaign.view', $campaign->id) }}"
                                                        class="btn btn-info"><i class="fa fa-eye"></i></a>
                                                </div>
                                                @if ($list->status == 1)
                                                <div class="m-1">
                                                    <a href="{{ route('influencer.campaign.comment', $list->campaign_id) }}" class="btn btn-primary">Request</a>
                                                </div>
                                                @elseif($list->status == 2)
                                                @else
                                                    <div class="m-1">
                                                        <form id="accept-campaign{{ $list->id }}"
                                                            action="{{ route('influencer.accept.campaign') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" class="form-control" id="id"
                                                                name="id" value="{{ $list->id }}">
                                                            <button type="button" class="btn btn-success"
                                                                id="accept-campaign-button{{ $list->id }}">
                                                                Accept
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="m-1">
                                                        <form id="decline-campaign{{ $list->id }}"
                                                            action="{{ route('influencer.decline.campaign') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" class="form-control" id="id"
                                                                name="id" value="{{ $list->id }}">
                                                            <button type="button" class="btn btn-danger"
                                                                id="decline-campaign-button{{ $list->id }}">
                                                                Decline
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>

                                        <script>
                                            document.getElementById('accept-campaign-button{{ $list->id }}').addEventListener('click', function(event) {
                                                Swal.fire({
                                                    title: "Are you sure?",
                                                    text: "You won't be able to revert this!",
                                                    icon: "warning",
                                                    showCancelButton: true,
                                                    confirmButtonColor: "#3085d6",
                                                    cancelButtonColor: "#d33",
                                                    confirmButtonText: "Yes, accept it!"
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        // Submit the form
                                                        document.getElementById('accept-campaign{{ $list->id }}').submit();

                                                    }
                                                });
                                            });
                                        </script>

                                        <script>
                                            document.getElementById('decline-campaign-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                        // Submit the form
                                                        document.getElementById('decline-campaign{{ $list->id }}').submit();

                                                    }
                                                });
                                            });
                                        </script>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Zero Configuration  Ends-->
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
