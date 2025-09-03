@extends('influencer.layout.main')
@section('content')
<style>
    .card-learn-swayit img {
        width: 100%;
        height: 220px;
    }
    .nav-tabs {
        display: flex;
        justify-content: center !important;
        border-bottom-color: #efefef00 !important;
    }
    .nav-tabs .nav-item button {
        padding: 5px 20px;
        background-color: #2979ff;
        color: #ffffff;
        border-radius: 5px;
        margin: 10px;
    }
    .nav-tabs .nav-item .active {
        padding: 5px 20px;
        background-color: #747474;
        color: #ffffff;
        border-radius: 5px;
        margin: 10px;
    }
    /* Packages */
    .learn-swayit {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 10px;
    }
    .learn-swayit .learn-swayit-img {
        width: 100%;
        height: 200px;
        overflow: hidden;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .learn-swayit .learn-swayit-img img {
        width: 100%;
        height: 100%;
        transition: 0.5s all ease-in-out;
    }
    .learn-swayit:hover .learn-swayit-img img {
        transform: scale(1.2);
    }
    .learn-swayit:hover {
        box-shadow: #00000022 0px 7px 16px 0px;
    }
    .learn-swayit .learn-swayit-box {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    .learn-swayit .learn-swayit-box h3 {
        margin-top: 20px;
        text-align: center;
        color: #636363;
        font-size: 22px;
        font-family: 'PT Serif', serif;
    }
    .learn-swayit .date {
        text-align: center;
        color: #747474;
        margin-top: 15px;
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
    <div class="card container-fluid">
        <div class="p-5">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                {{-- <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                </li> --}}
                @foreach($swayit_category as $index => $cat)
                    <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="tutorial-tab{{ $cat->id }}" data-bs-toggle="tab" data-bs-target="#tutorial{{ $cat->id }}" type="button" role="tab" aria-controls="tutorial-tab{{ $cat->id }}" aria-selected="false">{{ $cat->title }}</button>
                    </li>
                @endforeach
              </ul>
              <div class="tab-content mt-4" id="myTabContent">

                @foreach($swayit_category as $index => $cat)
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tutorial{{ $cat->id }}" role="tabpanel" aria-labelledby="tutorial-tab{{ $cat->id }}">
                        <div class="row">

                            @foreach($swayit_tutorial as $tutorial)
                            <div class="col-6 col-md-3" @if($tutorial->category_id != $cat->id) style="display: none;" @endif>
                                <div class="card learn-swayit">
                                    <a href="{{ route('influencer.tutorialDetails', $tutorial->id) }}">
                                        <div class="learn-swayit-img">
                                        <img src="{{ asset('storage/' . $tutorial->image) }}" alt="">
                                        </div>
                                        <div class="learn-swayit-box">
                                        <div class="date">Last Updated : {{ date('F d, Y', strtotime($tutorial->updated_at)) }}</div>
                                        <h3>{{ $tutorial->title }}</h3>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                    
                        </div>
                    </div>
                    @endforeach
                    {{-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> --}}
              </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection