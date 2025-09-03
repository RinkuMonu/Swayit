@extends('business.layout.main')
@section('content')
    <style>
        .bank-list .bank-details {
            display: flex;
            justify-content: left;
            align-items: center;
            background-color: #e4e4e4b6;
            border-radius: 15px;
            width: 450px;
        }

        .bank-list .bank-details .sub-bank {
            margin: 10px 20px;
        }

        .bank-list .bank-details .sub-bank i {
            background-color: #dfdfdf;
            color: #2979ff;
            padding: 10px;
            border: 2px solid #2979ff;
            border-radius: 50%;
            font-size: 22px;
            /* margin-right: 17px; */
        }

        .bank-list .bank-details .sub-bank h4 {
            font-size: 16px;
        }

        .bank-list .bank-details .sub-bank .text {
            font-size: 12px;
            color: #7b7b7b;
        }
        .delete-btn {
            background-color: #ff0000;
            border: 1px solid #ff0000;
            border-radius: 50%;
            color: #ffffff;
            padding: 5px 10px;
            position: absolute;
            top: 28px;
            right: 18px;
        }
        .delete-btn2 {
            background-color: #ff0000;
            border: 1px solid #ff0000;
            border-radius: 50%;
            color: #ffffff;
            padding: 5px 10px;
            position: absolute;
            top: 14px;
            right: 18px;
        }
    </style>

    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: true,
                // timer: 2000
            });
        </script>
    @endif


    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Bank Details</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dashboard</li>
                        <li class="breadcrumb-item active">Bank Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <button type="button" class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#addBank">Add
                            Bank</button>
        
                        <div class="row bank-list">
        
                            @foreach ($bank_list as $list)
                                <div class="bank-details mb-2">
                                    <div class="sub-bank">
                                        <i class="fa fa-bank"></i>
                                    </div>
                                    <div class="sub-bank">
                                        <h4 class="mb-2">{{ $list->bank_name }}</h4>
                                        <div class="text"><strong>Ac. No.</strong>&nbsp;&nbsp; {{ $list->account_number }}</div>
                                        <div class="text"><strong>Ac. Holder</strong>&nbsp;&nbsp; {{ $list->account_name }}</div>
                                        <div class="text" style="text-transform: uppercase;"><strong>SWIFT.</strong>&nbsp;&nbsp; {{ $list->swift_code }}</div>
                                    </div>
                                    <form action="{{ route('business.deleteBank') }}" method="POST" id="delete-bank-form{{ $list->id }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $list->id }}">
                                        <button class="delete-btn" type="button" id="delete-bank-button{{ $list->id }}">
                                            <i class="fa fa-trash-o" style="font-size: 25px;"></i>
                                        </button>
                                    </form>
                                </div>
        
                                
                                <script>
                                    document.getElementById('delete-bank-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                document.getElementById('delete-bank-form{{ $list->id }}').submit();
        
                                            }
                                        });
                                    });
                                </script>
                            @endforeach
        
                        </div>
                    </div>


                    <div class="col-md-6">

                        <button type="button" class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#addPaypal">Add Paypal Account</button>
        
                        <div class="row bank-list">
        
                            @foreach ($paypal_list as $list)
                                <div class="col-md-10 bank-details mb-2">
                                    <div class="sub-bank">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <div class="sub-bank">
                                        <h4>{{ $list->email }}</h4>
                                    </div>
                                    <form action="{{ route('business.deletePaypal') }}" method="POST" id="delete-paypal-form{{ $list->id }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $list->id }}">
                                        <button class="delete-btn2" type="button" id="delete-paypal-button{{ $list->id }}">
                                            <i class="fa fa-trash-o" style="font-size: 25px;"></i>
                                        </button>
                                    </form>
                                </div>
        
                                
                                <script>
                                    document.getElementById('delete-paypal-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                document.getElementById('delete-paypal-form{{ $list->id }}').submit();
        
                                            }
                                        });
                                    });
                                </script>
                            @endforeach
        
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




    <div class="modal fade" id="addPaypal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Paypal Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('business.addPaypal') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="paypal_email">Paypal Email</label>
                            <input type="text" class="form-control" id="paypal_email" name="paypal_email" placeholder="Enter Paypal Account">
                        </div><br>
                        <div class="form-group mb-2">
                            <button type="submit" class="btn btn-primary onclick-button">Add Paypal Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="addBank" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Bank Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('business.addBank') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name"
                                placeholder="Enter Bank name">
                        </div>
                        <div class="form-group mb-2">
                            <label for="account_number">Account Number</label>
                            <input type="number" class="form-control" id="account_number" name="account_number"
                                placeholder="Enter Account Number">
                        </div>
                        <div class="form-group mb-2">
                            <label for="account_name">Account Holder Name</label>
                            <input type="text" class="form-control" id="account_name" name="account_name"
                                placeholder="Enter Account Holder name">
                        </div>
                        <div class="form-group mb-2">
                            <label for="swift_code">SWIFT code</label>
                            <input type="text" class="form-control" id="swift_code" name="swift_code"
                                placeholder="Enter SWIFT code" style="text-transform: uppercase;">
                        </div>
                        <div class="form-group mb-2">
                            <button type="submit" class="btn btn-primary onclick-button">Add Bank</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection