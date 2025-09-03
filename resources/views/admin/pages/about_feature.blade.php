@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">About Page</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pages</li>
                <li class="breadcrumb-item active" aria-current="page">About Page</li>
            </ol>
        </nav>
    </div>




    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">About Page Content</h4>
                    <div class="container-fluid">
                        <div class="support-ticket-body">
                            <form action="{{ route('admin.update.aboutFeature') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Search and Filter Profiles</label>
                                        <input type="text" class="form-control" name="feature_one" id="" value="{{ $aboutFeature->feature_one }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Campaign Creation and Management</label>
                                        <input type="text" class="form-control" name="feature_two" id="" value="{{ $aboutFeature->feature_two }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Task Management</label>
                                        <input type="text" class="form-control" name="feature_three" id="" value="{{ $aboutFeature->feature_three }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Messaging System</label>
                                        <input type="text" class="form-control" name="feature_four" id="" value="{{ $aboutFeature->feature_four }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Escrow Payment</label>
                                        <input type="text" class="form-control" name="feature_five" id="" value="{{ $aboutFeature->feature_five }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Feedback System</label>
                                        <input type="text" class="form-control" name="feature_six" id="" value="{{ $aboutFeature->feature_six }}">
                                    </div>
                                </div>

                                
                                <button type="submit" class="btn btn-info mt-3">Update</button>
                            </form>
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