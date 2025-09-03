@extends('influencer.layout.main')
@section('content')

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
                    <h3>Bid Proposals</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dashboard</li>
                        <li class="breadcrumb-item active">Bid Proposals</li>
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
                                        <th>Bid Name</th>
                                        <th>Business</th>
                                        <th>Proposal Sent</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($bid_proposals as $list)
                                    @php
                                        $user = Auth::user();
                                        $bid_details = \App\Models\Bid::where('id', $list->bid_id)->first();
                                        $business = \App\Models\User::where('id', $bid_details->user_id)->first();
                                        $contract = \App\Models\Contract::where('bid_id', $list->bid_id)->where('person_two', $user->id)->first();
                                    @endphp
                                        <tr>
                                            <td>{{ $i }}.</td>
                                            @php $i++; @endphp
                                            <td>{{ $bid_details->title }}</td>
                                            <td>{{ $business->first_name }} {{ $business->last_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() }}</td>
                                            <td>
                                                @if($list->status == 1)
                                                    <span class="badge badge-success">Accepted</span>
                                                @elseif($list->status == 2)
                                                    <span class="badge badge-danger">Declined</span>
                                                @else
                                                    <span class="badge badge-warning">Waiting for response</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('influencer.bid.details', $bid_details->id) }}" class="btn btn-primary">View</a>
                                                @if($contract)
                                                <a href="{{ route('influencer.make.contract', $contract->id) }}" class="btn btn-info">Sign Contract</a>
                                                @endif
                                            </td>
                                        </tr>
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