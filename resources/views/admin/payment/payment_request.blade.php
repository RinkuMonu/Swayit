@extends('admin.layout.main')
@section('content')

<style>
    .wallet {
        padding: 20px;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
    }
    .wallet .sub-wallet img {
        width: 90px;
    }
    .wallet .sub-wallet span {
        margin-top: 15px;
        margin-bottom: 7px;
        color: #858585;
    }
    .wallet .sub-wallet h3 {
        color: #3c3c3c;
        font-size: 24px;
    }
    .wallet-view .content p {
        margin-bottom: 10px;
    }
</style>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Payment Request</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment Request</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Payment Request</h4>
                    <div class="container-fluid">
                        <div class="support-ticket-body">
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Date & Time</th>
                                                    <th>Made By</th>
                                                    <th>Payment To</th>
                                                    <th>Amount</th>
                                                    <th>status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($request_list as $list)
                                                @php
                                                    $payer = \App\Models\User::where('id', $list->made_by)->first();
                                                    $receiver = \App\Models\User::where('id', $list->payment_to)->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ date('F d, Y H:i:s', strtotime($list->created_at)) }}</td>
                                                    <td>{{ $payer->first_name }} {{ $payer->last_name }}</td>
                                                    <td>{{ $receiver->first_name }} {{ $receiver->last_name }}</td>
                                                    <td>${{ $list->amount }}</td>
                                                    <td>
                                                        @if($list->status == 1)
                                                            <span class="badge badge-success">Approved</span>
                                                        @elseif($list->status == 2)
                                                            <span class="badge badge-danger">Declined</span>
                                                        @else
                                                            <span class="badge badge-warning">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td class="d-flex">
                                                        @if($list->status == null)
                                                            <form id="approve-payment{{ $list->id }}" action="{{ route('admin.approve.payment') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $list->id }}">
                                                                <button type="button" class="btn btn-success" id="approve-payment-button{{ $list->id }}">Approve</button>&nbsp;
                                                            </form>

                                                            <form id="decline-payment{{ $list->id }}" action="{{ route('admin.decline.payment') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $list->id }}">
                                                                <button type="button" class="btn btn-danger" id="decline-payment-button{{ $list->id }}">Decline</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <script>
                                                    document.getElementById('decline-payment-button{{ $list->id }}').addEventListener('click', function(event) {
                                                        Swal.fire({
                                                            title: "Are you sure?",
                                                            text: "You won't be able to revert this!",
                                                            icon: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "#3085d6",
                                                            cancelButtonColor: "#d33",
                                                            confirmButtonText: "Yes, decline it!"
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Submit the form
                                                                document.getElementById('decline-payment{{ $list->id }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>

                                                <script>
                                                    document.getElementById('approve-payment-button{{ $list->id }}').addEventListener('click', function(event) {
                                                        Swal.fire({
                                                            title: "Are you sure?",
                                                            text: "You won't be able to revert this!",
                                                            icon: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "#3085d6",
                                                            cancelButtonColor: "#d33",
                                                            confirmButtonText: "Yes, approve it!"
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Submit the form
                                                                document.getElementById('approve-payment{{ $list->id }}').submit();
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
@endsection