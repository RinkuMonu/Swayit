@extends('business.layout.main')
@section('content')

<style>
    .tutorial-details {
        padding: 10px;
    }
    .tutorial-details img {
        width: 100%;
    }
    .tutorial-details h4 {
        color: #222222;
        margin-bottom: 20px;
    }
    .tutorial-details .date {
        font-weight: 500;
        color: #535353;
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
        <div class="row">
            <div class="col-md-8 mx-auto card p-5">
                <div class="tutorial-details">
                    <button type="button" class="btn btn-primary" onclick="goBack()">Back</button><br><br>
                    <img src="{{ asset('storage/' . $swayit_tutorial->image) }}" alt="">
                    <br><br>
                    <h4>{{ $swayit_tutorial->title }}</h4>
                    <div class="date">Last Updated : {{ date('F d, Y', strtotime($swayit_tutorial->updated_at)) }}</div>
                    <div class="text">
                        {!! $swayit_tutorial->description !!}
                    </div><br>
                    <h4>Watch Video</h4><br>
                    <video class="d-block w-100" alt="..."  controls>
                       <source  src="{{ asset('storage/' . $swayit_tutorial->video) }}" />
                    </video>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection