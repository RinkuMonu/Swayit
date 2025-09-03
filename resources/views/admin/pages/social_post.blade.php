@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Social Post Description</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Social Post Description</li>
            </ol>
        </nav>
    </div>




    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Home Content</h4>
                    <div class="container-fluid">
                        <div class="support-ticket-body">
                            <form action="{{ route('admin.update.Socialpost') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-md-12 mt-3">
                                        <label for="">Facebook</label>
                                        <textarea name="facebook" class="form-control" id="" cols="30" rows="10">{!! $socialMedia->facebook !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="">Instagram</label>
                                        <textarea name="instagram" class="form-control" id="" cols="30" rows="10">{!! $socialMedia->instagram !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="">Twitter</label>
                                        <textarea name="twitter" class="form-control" id="" cols="30" rows="10">{!! $socialMedia->twitter !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="">Youtube</label>
                                        <textarea name="youtube" class="form-control" id="" cols="30" rows="10">{!! $socialMedia->youtube !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="">Tiktok</label>
                                        <textarea name="tiktok" class="form-control" id="" cols="30" rows="10">{!! $socialMedia->tiktok !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="">Snapchat</label>
                                        <textarea name="snapchat" class="form-control" id="" cols="30" rows="10">{!! $socialMedia->snapchat !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="">Bereal</label>
                                        <textarea name="bereal" class="form-control" id="" cols="30" rows="10">{!! $socialMedia->bereal !!}</textarea>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="">Twitch</label>
                                        <textarea name="twitch" class="form-control" id="" cols="30" rows="10">{!! $socialMedia->twitch !!}</textarea>
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