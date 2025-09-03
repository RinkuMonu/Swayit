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
<style>
    .bank-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #e4e4e4b6;
        border-radius: 15px;
        margin: 10px auto;
    }

    .bank-details .sub-bank {
        margin: 10px 20px;
    }

    .bank-details .sub-bank i {
        background-color: #dfdfdf;
        color: #2979ff;
        padding: 10px;
        border: 2px solid #2979ff;
        border-radius: 50%;
        font-size: 22px;
        /* margin-right: 17px; */
    }

    .bank-details .sub-bank h4 {
        font-size: 16px;
    }

    .bank-details .sub-bank .text {
        font-size: 12px;
        color: #7b7b7b;
    }
</style>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Wallet</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wallet</li>
            </ol>
        </nav>
    </div>




    {{-- <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card wallet">
                <div class="sub-wallet">
                    <img src="{{ asset('assets/images/wallet1.png') }}" alt=""><br>
                    <span>Amount Available</span>
                    <h3>$1200.00</h3>
                </div>
                <div class="sub-wallet">
                    <button class="btn btn-primary">Add Amount</button><br><br>
                    <button class="btn btn-success">Withdraw Amount</button>
                </div>
            </div>
        </div>
    </div><br> --}}

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Transaction List</h4>
                    <div class="container-fluid">
                        <div class="support-ticket-body">
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sl. No.</th>
                                                    <th>Influencer</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Date & Time</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach($request_list as $list)
                                                @php
                                                    $userDetails = \App\Models\User::where('id', $list->user_id)->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>@php $i++; @endphp
                                                    <td>{{ $userDetails->first_name }} {{ $userDetails->last_name }}</td>
                                                    <td>{{ $userDetails->email }}</td>
                                                    <td>{{ $userDetails->phone }}</td>
                                                    <td>{{ date('F d, Y H:i:s', strtotime($list->created_at)) }}</td>
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
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-success dropdown-toggle"
                                                                id="btnGroupVerticalDrop{{ $list->id }}" type="button"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">Action</button>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop{{ $list->id }}" style="">

                                                                <button type="button" class="dropdown-item mb-3" data-bs-toggle="modal" data-bs-target="#paymentDetails{{ $list->id }}">Payment Details</button>

                                                                @if ($list->status == null)
                                                                <form id="approve-withdraw{{ $list->id }}" action="{{ route('admin.approve.withdraw') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $list->id }}">
                                                                    <button type="button" class="dropdown-item" id="approve-withdraw-button{{ $list->id }}">Approve</button>&nbsp;
                                                                </form>

                                                                <form id="decline-withdraw{{ $list->id }}" action="{{ route('admin.decline.withdraw') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $list->id }}">
                                                                    <button type="button" class="dropdown-item" id="decline-withdraw-button{{ $list->id }}">Decline</button>
                                                                </form>

                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>


                                                <div class="modal fade" id="paymentDetails{{ $list->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Payment Details</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body p-4">
                                                                @php
                                                                    $bank_list = \App\Models\BankDetail::orderBy('created_at', 'desc')->where('user_id', $list->user_id)->where('status', null)->get();
                                                                    $paypal_list = \App\Models\Paypal::orderBy('created_at', 'desc')->where('user_id', $list->user_id)->where('status', null)->get();
                                                                    
                                                                @endphp


                                                                <h4>Bank Details</h4>
                                                                <div class="row">
                                                                    @foreach ($bank_list as $blist)
                                                                    <div class="col-md-9 bank-details mb-2">
                                                                        <div class="sub-bank">
                                                                            <i class="fa fa-bank"></i>
                                                                        </div>
                                                                        <div class="sub-bank">
                                                                            <h4>{{ $blist->bank_name }}</h4>
                                                                            <div class="text"><strong>Ac. No.</strong>&nbsp;&nbsp; {{ $blist->account_number }}</div>
                                                                            <div class="text"><strong>Ac. Holder</strong>&nbsp;&nbsp; {{ $blist->account_name }}</div>
                                                                            <div class="text" style="text-transform: uppercase;"><strong>SWIFT.</strong>&nbsp;&nbsp; {{ $blist->swift_code }}</div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>

                                                                <br><br>
                                                                <h4>Paypal Details</h4>
                                                                <div class="row">
                                                                    @foreach ($paypal_list as $plist)
                                                                    <div class="col-md-9 bank-details mb-2">
                                                                        <div class="sub-bank">
                                                                            <i class="fa fa-envelope"></i>
                                                                        </div>
                                                                        <div class="sub-bank">
                                                                            <h4>{{ $plist->email }}</h4>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    document.getElementById('decline-withdraw-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                                document.getElementById('decline-withdraw{{ $list->id }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>

                                                <script>
                                                    document.getElementById('approve-withdraw-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                                document.getElementById('approve-withdraw{{ $list->id }}').submit();
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