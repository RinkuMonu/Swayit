@extends('business.layout.main')
@section('content')
    <style>
        .compare-influencer {
            border-radius: 10px;
            box-shadow: #00000063 0px 7px 15px 0px;
        }

        .compare-influencer .compare-influencer-header {
            text-align: center;
        }

        .compare-influencer .compare-influencer-header h4 {
            padding: 20px;
            font-size: 17px;
            background-color: #048bff;
            color: #ffffff;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .compare-influencer .compare-influencer-header img {
            border: 4px solid #61aaff;
            border-radius: 50%;
            margin-right: 25px;
            width: 100px;
            height: 100px;
            box-shadow: #00000063 0px 7px 15px 0px;
            margin: 20px auto;
        }

        .compare-influencer .compare-influencer-header .name {
            font-size: 18px;
            font-weight: 500;
        }

        .compare-influencer .compare-influencer-header .location {
            font-size: 13px;
            color: #6c6c6c;
        }

        .compare-influencer .compare-influencer-body {
            padding: 20px;
        }

        .compare-influencer .compare-influencer-body .pcb-basic p {
            font-size: 12px;
            color: #898989;
            margin-bottom: 3px;
        }

        .compare-influencer .compare-influencer-body .pcb-basic h4 {
            font-size: 14px;
            color: #434343;
        }

        .compare-influencer .compare-influencer-body .tags {
            display: flex;
        }

        .compare-influencer .compare-influencer-body .tags .sub-tag {
            padding: 5px 20px;
            background-color: #0489fd;
            color: #ffffff;
            margin: 2px;
        }

        .compare-influencer .compare-influencer-body .about {
            font-size: 14px;
            color: #737373;
            text-align: justify;
        }

        .facebookiconsgigspage {
            width: 23px;
            margin: 0px 4px;
        }
    </style>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Compare Influencer</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Influencer</li>
                        <li class="breadcrumb-item active">Compare Influencer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            @foreach ($influencer_list as $list)
                <div class="col-md-4 mb-3">
                    <div class="card compare-influencer">
                        <div class="compare-influencer-header">
                            @php
                                $user_details = \App\Models\User::where('id', $list->id)->first();
                            @endphp
                            @if ($user_details->profile_img)
                                <img src="{{ asset('storage/' . $user_details->profile_img) }}" alt="">
                            @else
                                <img src="{{ asset('asset/image/dpimage.png') }}" alt="">
                            @endif
                            <div class="name">{{ $user_details->first_name }} {{ $user_details->last_name }}</div>
                            <div class="location">{{ $user_details->city }}, {{ $user_details->country }}</div>
                        </div>
                        <hr>
                        <div class="compare-influencer-body">
                            <div class="pcb-basic">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <p>Member Since</p>
                                        <h4>{{ date('F d, Y', strtotime($user_details->created_at)) }}</h4>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <p>Languages</p>
                                        <h4>{{ $user_details->language }}</h4>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <p>Email</p>
                                        <h4>{{ $user_details->email }}</h4>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <p>Projects Completed</p>
                                        <h4>0</h4>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @php
                                $skills = json_decode($user_details->tags, true);
                            @endphp

                            @if ($skills)
                                <div class="tags">
                                    @foreach ($skills as $skill)
                                        <div class="sub-tag">{{ $skill['value'] }}</div>
                                    @endforeach
                                </div>
                            @else
                                <div class="tags" style="padding: 7px;">
                                    No Tags Added...
                                </div>
                            @endif
                            <hr>
                            <div class="social-media">
                                <h4 style="font-size: 16px;">Social Media</h4><br>
                                <div class="product-icon">
                                    <a href="{{ $user_details->facebook }}" target="_blank">
                                        <img src="{{ asset('asset/image/facebookpost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    <a href="{{ $user_details->instagram }}" target="_blank">
                                        <img src="{{ asset('asset/image/Instagrampost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    <a href="{{ $user_details->linkedin }}" target="_blank">
                                        <img src="{{ asset('asset/image/Linkedin.png') }}" alt="" class="facebookiconsgigspage">
                                    </a>
                                    <a href="{{ $user_details->youtube }}" target="_blank">
                                        <img src="{{ asset('asset/image/youtubepost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    <a href="{{ $user_details->twitter }}" target="_blank">
                                        <img src="{{ asset('asset/image/twitterIcons.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    <a href="{{ $user_details->snapchat }}" target="_blank">
                                        <img src="{{ asset('asset/image/snapchetpost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    <a href="{{ $user_details->tiktok }}" target="_blank">
                                        <img src="{{ asset('asset/image/Tiktokpost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    <a href="{{ $user_details->bereal }}" target="_blank">
                                        <img src="{{ asset('asset/image/Bereaalpost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="about">{!! $user_details->about !!}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
