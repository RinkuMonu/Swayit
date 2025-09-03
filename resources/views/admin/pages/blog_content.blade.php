@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Blog Page</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pages</li>
                <li class="breadcrumb-item active" aria-current="page">Blog Page</li>
            </ol>
        </nav>
    </div>




    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Blog Content</h4>
                    <div class="container-fluid">
                        <div class="support-ticket-body">
                            <form action="{{ route('admin.update.blogContent') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" name="title" id="" value="{{ $blogContent->title }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Description</label>
                                        <textarea name="description" id="" cols="30" rows="10" class="form-control">{!! $blogContent->description !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        
                                        @if($blogContent->image)
                                        <img src="{{ asset('storage/' . $blogContent->image) }}" alt="" style="width: 150px; height: auto;"><br>
                                        @else
                                        <img src="{{ asset('asset/image/AboutUs1.png') }}" alt="" style="width: 150px; height: auto;"><br>
                                        @endif

                                        <br>
                                        <label for="">Image</label>
                                        <input type="file" class="form-control" name="image" id="" placeholder="Add Video">
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