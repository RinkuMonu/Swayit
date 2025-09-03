@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Home Page</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pages</li>
                <li class="breadcrumb-item active" aria-current="page">Home Page</li>
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
                            <form action="{{ route('admin.update.homecontent') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mt-3 form-group">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" name="home_title" id="" value="{{ $homePage->title }}">
                                    </div>

                                    <div class="col-md-12 mt-3 form-group">
                                        
                                        @if($homePage->video)
                                        <video controls style="width: 150px; height: auto;">
                                            <source src="{{ asset('storage/' . $homePage->video) }}" type="video/mp4" />
                                        </video><br>
                                        @endif

                                        <br>
                                        <label for="">Video</label>
                                        <input type="file" class="form-control" name="home_video" id="" placeholder="Add Video">
                                    </div>

                                    <div class="col-md-12 mt-3 form-group">
                                        
                                        @if($homePage->video_two)
                                        <video autoPlay muted loop style="width: 150px; height: auto;">
                                            <source src="{{ asset('storage/' . $homePage->video_two) }}" type="video/mp4" />
                                        </video><br>
                                        @endif

                                        <br>
                                        <label for="">Video</label>
                                        <input type="file" class="form-control" name="home_video_two" id="" placeholder="Add Video">
                                    </div>

                                    <div class="col-md-12 mt-3 form-group">
                                        
                                        @if($homePage->video_three)
                                        <video autoPlay muted loop style="width: 150px; height: auto;">
                                            <source src="{{ asset('storage/' . $homePage->video_three) }}" type="video/mp4" />
                                        </video><br>
                                        @endif

                                        <br>
                                        <label for="">Video</label>
                                        <input type="file" class="form-control" name="home_video_three" id="" placeholder="Add Video">
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