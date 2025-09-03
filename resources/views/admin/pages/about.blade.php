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
                            <form action="{{ route('admin.update.aboutContent') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Title 1</label>
                                        <input type="text" class="form-control" name="title_one" id="" value="{{ $aboutPage->title_one }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Description 1</label>
                                        <textarea name="description_one" id="" cols="30" rows="10" class="form-control">{!! $aboutPage->desc_one !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        
                                        @if($aboutPage->image_one)
                                        <img src="{{ asset('storage/' . $aboutPage->image_one) }}" alt="" style="width: 150px; height: auto;"><br>
                                        @else
                                        <img src="{{ asset('asset/image/AboutUs1.png') }}" alt="" style="width: 150px; height: auto;"><br>
                                        @endif

                                        <br>
                                        <label for="">Image 1</label>
                                        <input type="file" class="form-control" name="image_one" id="">
                                    </div>

                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Title 2</label>
                                        <input type="text" class="form-control" name="title_two" id="" value="{{ $aboutPage->title_two }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Description 2</label>
                                        <textarea name="description_two" id="" cols="30" rows="10" class="form-control">{!! $aboutPage->desc_two !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        
                                        @if($aboutPage->image_two)
                                        <img src="{{ asset('storage/' . $aboutPage->image_two) }}" alt="" style="width: 150px; height: auto;"><br>
                                        @else
                                        <img src="{{ asset('asset/image/AboutUs1.png') }}" alt="" style="width: 150px; height: auto;"><br>
                                        @endif

                                        <br>
                                        <label for="">Image 2</label>
                                        <input type="file" class="form-control" name="image_two" id="">
                                    </div>

                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Title 3</label>
                                        <input type="text" class="form-control" name="title_three" id="" value="{{ $aboutPage->title_three }}">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Description 3</label>
                                        <textarea name="description_three" id="" cols="30" rows="10" class="form-control">{!! $aboutPage->desc_three !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        
                                        @if($aboutPage->image_three)
                                        <img src="{{ asset('storage/' . $aboutPage->image_three) }}" alt="" style="width: 150px; height: auto;"><br>
                                        @else
                                        <img src="{{ asset('asset/image/AboutUs1.png') }}" alt="" style="width: 150px; height: auto;"><br>
                                        @endif

                                        <br>
                                        <label for="">Image 3</label>
                                        <input type="file" class="form-control" name="image_three" id="">
                                    </div>
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Link</label>
                                        <input type="text" class="form-control" name="link" id="" value="{{ $aboutPage->link }}">
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