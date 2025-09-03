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
            min-height: 85px;
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
                    <h3>Compare Gigs</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Gigs</li>
                        <li class="breadcrumb-item active">Compare Gigs</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            @foreach ($gigs_list as $list)
                <div class="col-md-4 mb-3">
                    <div class="card compare-influencer">
                        <div class="compare-influencer-header">
                            <h4>{{ $list->title }}</h4>
                        </div>
                        <div class="compare-influencer-body">
                            <div class="pcb-basic">
                                @php
                                    $gig_img = json_decode($list->images);
                                    $firstImage = $gig_img[0];
                                @endphp

                                <div class="product-img">
                                    @if ($firstImage)
                                        <img src="{{ asset('storage/' . $firstImage) }}" class="img-fluid"
                                            alt="...">
                                    @else
                                        <img class="img-fluid"
                                            src="{{ asset('assets/images/ecommerce/01.jpg') }}"
                                            alt="">
                                    @endif
                                </div>
                            </div><hr>
                            <div class="pcb-basic">
                                @php
                                    $ctg = \App\Models\Category::where('id', $list->category)->first();
                                    $industry = \App\Models\Industry::where('id', $list->industry)->first();
                                @endphp
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <p>Budget</p>
                                        <h4>${{ $list->price }}</h4>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <p>Industry</p>
                                        <h4>
                                            @if ($industry)
                                                {{ $industry->name }}
                                            @else
                                                -
                                            @endif
                                        </h4>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <p>Category</p>
                                        <h4>
                                            @if ($ctg)
                                                {{ $ctg->name }}
                                            @else
                                                -
                                            @endif
                                        </h4>
                                    </div>
                                </div>
                            </div><hr>
                            @php
                                $skills = json_decode($list->tags, true);
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
                                    @if($list->facebook)
                                    <a href="{{ $list->facebook }}" target="_blank">
                                        <img src="{{ asset('asset/image/facebookpost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    @endif
                                    @if($list->instagram)
                                    <a href="{{ $list->instagram }}" target="_blank">
                                        <img src="{{ asset('asset/image/Instagrampost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    @endif
                                    @if($list->linkedin)
                                    <a href="{{ $list->linkedin }}" target="_blank">
                                        <img src="{{ asset('asset/image/Linkedin.png') }}" alt="" class="facebookiconsgigspage">
                                    </a>
                                    @endif
                                    @if($list->youtube)
                                    <a href="{{ $list->youtube }}" target="_blank">
                                        <img src="{{ asset('asset/image/youtubepost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    @endif
                                    @if($list->twitter)
                                    <a href="{{ $list->twitter }}" target="_blank">
                                        <img src="{{ asset('asset/image/twitterIcons.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    @endif
                                    @if($list->snapchat)
                                    <a href="{{ $list->snapchat }}" target="_blank">
                                        <img src="{{ asset('asset/image/snapchetpost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    @endif
                                    @if($list->tiktok)
                                    <a href="{{ $list->tiktok }}" target="_blank">
                                        <img src="{{ asset('asset/image/Tiktokpost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    @endif
                                    @if($list->bereal)
                                    <a href="{{ $list->bereal }}" target="_blank">
                                        <img src="{{ asset('asset/image/Bereaalpost.png') }}" alt=""
                                            class="facebookiconsgigspage">
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="about">
                                <strong>About Gig:</strong><br>
                                {!! $list->desc !!}
                            </div>
                            <hr>
                            <div class="compare-influencer-header">
                                <h3 style="font-size: 20px;">Created By</h3>
                                @php
                                    $user_details = \App\Models\User::where('id', $list->user_id)->first();
                                @endphp
                                @if ($user_details->profile_img)
                                    <img src="{{ asset('storage/' . $user_details->profile_img) }}" alt="">
                                @else
                                    <img src="{{ asset('asset/image/dpimage.png') }}" alt="">
                                @endif
                                <div class="name">{{ $user_details->first_name }} {{ $user_details->last_name }}</div>
                                <div class="location">{{ $user_details->city }}, {{ $user_details->country }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection