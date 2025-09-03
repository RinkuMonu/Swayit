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
        <h3 class="page-title">Coupon List</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Coupon List</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Coupon List</h4>
                    <div class="container-fluid">
                        <div class="support-ticket-body">
                            <div class="row">
                                <div class="col-md-12 mt-3">

                                    <button type="button" class="btn btn-info btn-sm smallButtons mb-3" data-bs-toggle="modal" data-bs-target="#addCoupon">Add Coupon</button>

                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sl. No.</th>
                                                    <th>Coupon</th>
                                                    <th>Discount</th>
                                                    <th>Created On</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach($coupon_list as $list)
                                                <tr>
                                                    <td>{{ $i }}</td>@php $i++; @endphp
                                                    <td>{{ strtoupper($list->coupon); }}</td>
                                                    <td>{{ $list->discount }}%</td>
                                                    <td>{{ date('F d, Y H:i:s', strtotime($list->created_at)) }}</td>
                                                    <td>
                                                        @if($list->status == null)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Expired</span>
                                                        @endif
                                                    </td>
                                                    <td class="d-flex">
                                                        @if($list->status == null)
                                                            <form id="inactive-coupon{{ $list->id }}" action="{{ route('admin.inactive.coupon') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $list->id }}">
                                                                <button type="button" class="btn btn-danger" id="inactive-coupon-button{{ $list->id }}">Inactivate</button>&nbsp;
                                                            </form>

                                                        @else

                                                            <form id="active-payment{{ $list->id }}" action="{{ route('admin.active.coupon') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $list->id }}">
                                                                <button type="button" class="btn btn-success" id="active-payment-button{{ $list->id }}">Activate</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <script>
                                                    document.getElementById('inactive-coupon-button{{ $list->id }}').addEventListener('click', function(event) {
                                                        Swal.fire({
                                                            title: "Are you sure?",
                                                            text: "You won't be able to revert this!",
                                                            icon: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "#3085d6",
                                                            cancelButtonColor: "#d33",
                                                            confirmButtonText: "Yes, Inactivate It!"
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Submit the form
                                                                document.getElementById('inactive-coupon{{ $list->id }}').submit();
                                                            }
                                                        });
                                                    });
                                                </script>

                                                <script>
                                                    document.getElementById('active-payment-button{{ $list->id }}').addEventListener('click', function(event) {
                                                        Swal.fire({
                                                            title: "Are you sure?",
                                                            text: "You won't be able to revert this!",
                                                            icon: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "#3085d6",
                                                            cancelButtonColor: "#d33",
                                                            confirmButtonText: "Yes, Active It!"
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Submit the form
                                                                document.getElementById('active-payment{{ $list->id }}').submit();
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

<!-- Modal Starts -->
<div class="modal fade" id="addCoupon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.add.coupon') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Enter Coupon Name</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-4">
                            <label for="coupon_name" class="form-label taxt-bold">Enter Coupon</label>
                            <input type="text" class="form-control borderPlaceholderInput" id="coupon_name"
                                name="coupon_name" placeholder="Enter Coupon" style="text-transform: uppercase;">
                        </div>
                        <div class="mb-4">
                            <label for="discount" class="form-label taxt-bold">Discount(%)</label>
                            <input type="number" class="form-control borderPlaceholderInput" id="discount"
                                name="discount" placeholder="Ex - 12%">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Add Coupon</button>
                    {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Ends -->
@endsection