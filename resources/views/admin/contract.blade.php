@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Contract</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contract</li>
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
                            <form action="{{ route('admin.update.contract') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mt-3 form-group">
                                        <label for="">Select Template Color</label><br>
                                        <input type="color" name="color" id="" value="{{ $contract->color }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" name="sub_title" id="" value="{{ $contract->sub_title }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="form-control">{!! $contract->description !!}</textarea>
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


<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace('description', {
versionCheck: false
});
</script>
@endsection