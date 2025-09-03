@extends('influencer.layout.main')
@section('content')
<style>
    .learn-swayit {
        padding: 20px;
        text-align: center;
    }
    .learn-swayit img {
        height: 130px;
        margin-bottom: 20px;
    }
    .learn-swayit h4 {
        font-size: 18px;
        margin-bottom: 20px;
    }
</style>

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Learn SwayIt</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Learn SwayIt</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card p-5">

            <div class="row">
                <div class="col-md-6 learn-swayit">
                    <img src="{{ asset('assets/learn_swayit/video.png') }}" alt="">
                    <h4>Watch Tutorial</h4>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewVideoTutorial">
                        View Tutorial
                    </button>
                </div>

                <div class="col-md-6 learn-swayit">
                    <img src="{{ asset('assets/learn_swayit/document.png') }}" alt="">
                    <h4>Read About SwayIt</h4>
                    <a href="{{ asset('assets/learn_swayit/story.pdf') }}" class="btn btn-info" target="_blank">Read</a>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->





    
    <!-- Modal -->
    <div class="modal fade" id="viewVideoTutorial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Watch Tutorial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe 
                        width="100%" 
                        height="315" 
                        src="https://www.youtube.com/embed/YOUTUBE_VIDEO_ID" 
                        title="YouTube video player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>

@endsection