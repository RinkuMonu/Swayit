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
                                                    <th>Date & Time</th>
                                                    <th>Payment By</th>
                                                    <th>Payment To</th>
                                                    <th>Details</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($payment_list as $list)
                                                @php
                                                    $paymentBy = \App\Models\User::where('id', $list->payment_by)->first();
                                                    $person = \App\Models\User::where('id', $list->payment_to)->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ date('F d, Y H:i', strtotime($list->created_at)) }}</td>
                                                    <td>{{ $paymentBy->first_name }} {{ $paymentBy->last_name }}</td>
                                                    <td>{{ $person->first_name }} {{ $person->last_name }}</td>
                                                    <td>{{ $list->details }}</td>
                                                    <td>${{ $list->amount }}</td>
                                                    <td>
                                                        @if($list->status == 1)
                                                            <span class="badge badge-success">Approved</span>
                                                        @elseif($list->status == 2)
                                                            <span class="badge badge-danger">Rejected</span>
                                                        @else
                                                            <span class="badge badge-warning">Pending</span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection