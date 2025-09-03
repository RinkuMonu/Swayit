@extends('business.layout.main')
@section('content')

<style>
  .video-call-section img {
    width: 70%;
    margin: 0px auto;
  }
  .video-call-section h4 {
    font-size: 45px;
    margin-bottom: 30px;
    margin-top: 40px;
  }
  .video-call-section p {
    font-size: 22px;
    margin-bottom: 70px;
  }
</style>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Video Call</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Video Call</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>



    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card p-5">
            {{-- <div class="video-call-section"> --}}
                <div class="row">
                    <div class="col-md-6 video-call-section">
                        <img src="{{ asset('asset/image/Business2.png') }}" alt="">
                    </div>
                    <div class="col-md-6 video-call-section">
                        <h4>Audio calls for everyone.</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia placeat perferendis dicta ea
                            corrupti eos, excepturi odit exercitationem.</p>

                        <form action="{{ route('business.generate.audiocall.token') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="font-size: 22px;">Start a audio call</button>
                        </form>
                    </div>
                </div>
            {{-- </div> --}}
        </div>
    </div>
@endsection