@extends('influencer.layout.main')
@section('content')
    <style>
        .profile-card-header {
            display: flex;
            justify-content: left;
            align-items: center;
        }

        .profile-card-header .sub-pch .userimg {
            border: 4px solid #61aaff;
            border-radius: 50%;
            margin-right: 25px;
            width: 100px;
            height: 100px;
            box-shadow: #00000063 0px 7px 15px 0px;
        }

        .profile-card-header .sub-pch .name {
            color: #1c1c1c;
            font-size: 30px;
            font-weight: 500;
            font-family: math;
        }

        .profile-card-header .sub-pch .bio {
            color: #6b6b6b;
            font-size: 14px;
        }

        .profile-card-body {
            margin: 34px 0px;
            border: 1px solid #b6b6b6;
            border-radius: 10px;
            padding: 35px 20px;
        }

        .profile-card-body .pcb-basic p {
            font-size: 14px;
            color: #898989;
            margin-bottom: 4px;
        }

        .profile-card-body .pcb-basic h4 {
            font-size: 16px;
            color: #434343;
        }

        .profile-card-body .about {
            font-size: 15px;
            color: #737373;
            text-align: justify;
        }

        .facebookiconsgigspage {
            width: 23px;
            margin: 0px 4px;
        }
        .user-rating i {
            color: #ffd428;
            margin: 1px;
        }
    </style>

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Profile</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card p-5">
            <div class="profile-card-header">
                <div class="sub-pch">
                    @if($user_details->profile_img)
                        <img src="{{ asset('storage/' . $user_details->profile_img) }}" alt="" class="userimg">
                    @else
                        <img src="{{ asset('asset/image/dpimage.png') }}" alt="" class="userimg">
                    @endif
                </div>
                <div class="sub-pch">
                    @php
                        $blue_tick = \App\Models\PaymentRequest::where('status', 1)->where('payment_to', $user_details->id)->count();
                    @endphp
                    <div class="d-flex">
                        <div class="name">{{ $user_details->first_name }} {{ $user_details->last_name }}</div>&nbsp;&nbsp;&nbsp;
                        @if($blue_tick >= 20)
                            <img src="{{ asset('assets/images/tickmark.png') }}" style="width: 30px; height: 30px;">
                        @endif
                    </div>
                    <div class="bio">{!! $user_details->bio !!}</div>
                    @php
                        $sum_of_rating = \App\Models\Rating::where('rating_for', $user_details->id)->sum(
                            'rating',
                        );
                        $total_rating = \App\Models\Rating::where('rating_for', $user_details->id)->count();
                        $avg_rating = $total_rating > 0 ? round($sum_of_rating / $total_rating) : 0;
                    @endphp
                    <div class="d-flex user-rating">
                        @if ($avg_rating == 0)
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        @elseif($avg_rating == 1)
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        @elseif($avg_rating == 2)
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        @elseif($avg_rating == 3)
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        @elseif($avg_rating == 4)
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        @else
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        @endif
                    </div>({{ $total_rating }} review)</span>
                </div>
            </div>
            <div class="profile-card-body">
                <div class="pcb-basic d-flex">
                    <p class="mx-4">Click the button to start chatting: </p>

                    @php
                        $find_user = \App\Models\UserMessage::where(function ($query) use ($user_details, $authUser) {
                            $query->where('sender_id', $user_details->id)
                                ->where('receiver_id', $authUser->id);
                        })->orWhere(function ($query) use ($user_details, $authUser) {
                            $query->where('sender_id', $authUser->id)
                                ->where('receiver_id', $user_details->id);
                        })->exists();
                    @endphp
                    @if($find_user)
                    <a href="{{ route('influencer.chat.message', $user_details->id) }}" class="btn btn-primary">Start Messaging &nbsp;<i class="fa fa-comments"></i></a>
                    @else
                    <form action="{{ route('influencer.start.chat') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $user_details->id }}">
                        <button type="submit" class="btn btn-primary">Start Messaging &nbsp;<i class="fa fa-comments"></i></button>
                    </form>
                    @endif
                </div><hr>
                <div class="pcb-basic">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <p>From</p>
                            <h4>{{ $user_details->city }}, {{ $user_details->country }}</h4>
                        </div>
                        <div class="col-md-4 mb-4">
                            <p>Member Since</p>
                            <h4>{{ date('F d, Y', strtotime($user_details->created_at)) }}</h4>
                        </div>
                        <div class="col-md-4 mb-4">
                            <p>Languages</p>
                            <h4>{{ $user_details->language }}</h4>
                        </div>
                        <div class="col-md-4 mb-4">
                            <p>Email</p>
                            <h4>{{ $user_details->email }}</h4>
                        </div>
                        <div class="col-md-4 mb-4">
                            <p>Website</p>
                            <h4>{{ $user_details->website }}</h4>
                        </div>
                        <div class="col-md-4 mb-4">
                            <p>Projects Completed</p>
                            <h4>10</h4>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex">
                    @php
                        $tag_array = json_decode($user_details->tags, true);
                    @endphp
                    @if ($tag_array)
                        @foreach ($tag_array as $array)
                            <span class="badge badge-primary">{{ $array['value'] }}</span>
                        @endforeach
                    @endif
                </div>
                <hr><br>
                <div class="about">
                    {!! $user_details->about !!}
                </div>
                <hr><br>
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
            </div>

            

            <h4>Gigs Created</h4>
            <div class="profile-card-body">
                @if (count($gig_list) > 0)
                    @foreach ($gig_list as $list)
                        @php
                            $gig_img = json_decode($list->images);
                            $firstImage = $gig_img[0];
                        @endphp
                        <div class="col-xl-3 col-sm-3 xl-3">
                            <div class="card">
                                <div class="product-box">
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

                                    <div class="product-details">
                                        <a href="{{ route('influencer.view.gigs', $list->id) }}">
                                            <h5>{{ $list->title }}</h5>
                                        </a>

                                        <div class="product-price">${{ $list->price }}.00
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="add-custom-bid">
                        <p>No Gigs Created</p>
                    </div>
                @endif
            </div>



            <h4>Portfolio</h4>
            <div class="profile-card-body">
                <div class="add-custom-bid">
                    <p>No Project Found</p>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
    @endsection