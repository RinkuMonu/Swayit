@extends('business.layout.main')
@section('content')


    <style>
        .facebookiconsgigspage {
            width: 23px;
            margin: 0px 4px;
        }

        .profile-card-header {
            display: flex;
            justify-content: left;
            align-items: center;
        }

        .profile-card-header .sub-pch img {
            border: 4px solid #61aaff;
            border-radius: 50%;
            margin-right: 25px;
            width: 80px;
            height: 80px;
            /* box-shadow: #00000063 0px 7px 15px 0px; */
        }

        .profile-card-header .sub-pch .name {
            color: #1c1c1c;
            font-size: 22px;
            font-weight: 500;
        }

        .profile-card-header .sub-pch .bio {
            color: #6b6b6b;
            font-size: 13px;
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
                    <h3>Gigs Page</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Gigs</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div>
            <div class="row product-page-main p-0">
                <div class="col-xxl-4 col-md-4 box-col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-slider owl-carousel owl-theme" id="sync1">
                                @php
                                    $gig_img = json_decode($gig_details->images);
                                @endphp
                                @foreach ($gig_img as $img)
                                    <div class="item"><img src="{{ asset($img) }}" alt=""></div>
                                @endforeach
                            </div>
                            <div class="owl-carousel owl-theme" id="sync2">
                                @foreach ($gig_img as $img)
                                    <div class="item"><img src="{{ asset($img) }}" alt=""></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-8 box-col-8 order-xxl-0 order-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-page-details">
                                <h3>{{ $gig_details->title }}</h3>
                            </div>
                            <div class="product-price">${{ $gig_details->price }}.00
                                {{-- <del>$350.00 </del> --}}
                            </div>

                            <hr>

                            <div class="profile-card-header">
                                @php
                                    $userDetails = \App\Models\User::where('id', $gig_details->user_id)->first();
                                @endphp
                                <div class="sub-pch">
                                    <a href="{{ route('business.view.profile', $userDetails->id) }}">
                                        @if ($userDetails->profile_img)
                                            <img src="{{ asset( $userDetails->profile_img) }}" alt="">
                                        @else
                                            <img src="{{ asset('asset/image/dpimage.png') }}" alt="">
                                        @endif
                                    </a>
                                </div>
                                <div class="sub-pch">
                                    <a href="{{ route('business.view.profile', $userDetails->id) }}">
                                        @php
                                            $blue_tick = \App\Models\PaymentRequest::where('status', 1)->where('payment_to', $userDetails->id)->count();
                                        @endphp
                                        <div class="d-flex">
                                            <div class="name">{{ $userDetails->first_name }} {{ $userDetails->last_name }}</div>&nbsp;&nbsp;&nbsp;
                                            @if($blue_tick >= 20)
                                                <img src="{{ asset('assets/images/tickmark.png') }}" style="width: 30px; height: 30px; border: none !important;">
                                            @endif
                                        </div>
                                    </a>
                                    <div class="bio">{!! \Illuminate\Support\Str::limit($userDetails->bio, 100) !!}</div>
                                    @php
                                        $sum_of_rating = \App\Models\Rating::where('rating_for', $userDetails->id)->sum(
                                            'rating',
                                        );
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
                            <hr>

                            <p>{!! $gig_details->desc !!}</p>
                            <hr>
                            <div>
                                @php
                                    $ctg = \App\Models\Category::where('id', $gig_details->category)->first();
                                    $subctg = \App\Models\SubCategory::where('id', $gig_details->sub_category)->first();
                                    $industry = \App\Models\Industry::where('id', $gig_details->industry)->first();
                                @endphp
                                <table class="product-page-width">
                                    <tbody>
                                        <tr>
                                            <td> <b>Industry &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>
                                                @if ($industry)
                                                    {{ $industry->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> <b>Category &nbsp;&nbsp;&nbsp;:</b></td>
                                            <td>
                                                @if ($ctg)
                                                    {{ $ctg->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> <b>Sub-category &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>
                                                @if ($subctg)
                                                    {{ $subctg->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="product-title">Platform :</h6>
                                </div>
                                <div class="col-md-8">
                                    <div class="product-icon">
                                        @if ($gig_details->facebook == 1)
                                            <img src="{{ asset('asset/image/facebookpost.png') }}" alt=""
                                                class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->instagram == 1)
                                            <img src="{{ asset('asset/image/Instagrampost.png') }}" alt=""
                                                class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->linkedin == 1)
                                            <img src="{{ asset('asset/image/Linkedin.png') }}" alt=""
                                                class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->youtube == 1)
                                            <img src="{{ asset('asset/image/youtubepost.png') }}" alt=""
                                                class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->twitter == 1)
                                            <img src="{{ asset('asset/image/twitterIcons.png') }}" alt=""
                                                class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->snapchat == 1)
                                            <img src="{{ asset('asset/image/snapchetpost.png') }}" alt=""
                                                class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->tiktok == 1)
                                            <img src="{{ asset('asset/image/Tiktokpost.png') }}" alt=""
                                                class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->twitch == 1)
                                            <img src="{{ asset('asset/image/Twitchpost.png') }}" alt=""
                                                class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->be_real == 1)
                                            <img src="{{ asset('asset/image/Bereaalpost.png') }}" alt=""
                                                class="facebookiconsgigspage">
                                        @endif
                                        <form class="d-inline-block f-right"></form>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="product-title">Rate Now :</h6>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-flex">
                                        @if ($influencer_rating)
                                            <select id="u-rating-fontawesome" name="rating" autocomplete="off">
                                                <option value="1" @if ($influencer_rating->rating == 1) selected @endif>1
                                                </option>
                                                <option value="2" @if ($influencer_rating->rating == 2) selected @endif>2
                                                </option>
                                                <option value="3" @if ($influencer_rating->rating == 3) selected @endif>3
                                                </option>
                                                <option value="4" @if ($influencer_rating->rating == 4) selected @endif>4
                                                </option>
                                                <option value="5" @if ($influencer_rating->rating == 5) selected @endif>5
                                                </option>
                                            </select>
                                        @else
                                            <select id="u-rating-fontawesome" name="rating" autocomplete="off">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="product-title">Tags :</h6>
                                </div>
                                <div class="col-md-8">
                                    <div style="display: flex;flex-wrap: wrap;">
                                        @php
                                            $tag_array = json_decode($gig_details->tags, true);
                                        @endphp
                                        @if ($tag_array)
                                            @foreach ($tag_array as $array)
                                                <span class="badge badge-primary mb-2">{{ $array['value'] }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div><br>
                            @php
                                $gig_checkout = \App\Models\GigCheckout::where('gig_id', $gig_details->id)
                                    ->where('user_id', $user->id)
                                    ->first();
                            @endphp
                            <div class="m-t-15 btn-showcase d-flex">
                                @php
                                    $find_user = \App\Models\UserMessage::where(function ($query) use ($gig_details, $user) {
                                        $query->where('sender_id', $gig_details->user_id)
                                            ->where('receiver_id', $user->id);
                                    })->orWhere(function ($query) use ($gig_details, $user) {
                                        $query->where('sender_id', $user->id)
                                            ->where('receiver_id', $gig_details->user_id);
                                    })->exists();
                                @endphp
                                @if($find_user)
                                <a href="{{ route('business.chat.message', $gig_details->user_id) }}" class="btn btn-primary">Start Messaging &nbsp;<i class="fa fa-comments"></i></a>
                                @else
                                <form action="{{ route('business.start.chat') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="receiver_id" value="{{ $gig_details->user_id }}">
                                    <button type="submit" class="btn btn-primary">Contact</button>
                                </form>
                                @endif
                                {{-- <a class="btn btn-primary" href="cart.html" title=""> <i class="fa fullcalendar-custom me-1"></i>Contact Me</a> --}}
                                @if ($gig_checkout)
                                    <a class="btn btn-info" href="{{ route('business.gig.invoice', $gig_checkout->id) }}"
                                        title=""> <i class="fa fa-file-text-o"></i>&nbsp; View Invoice</a>
                                @else
                                    <a class="btn btn-success"
                                        href="{{ route('business.gig.checkout', $gig_details->id) }}" title=""> <i
                                            class="fa fa-shopping-cart me-1"></i>Buy Now</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div><br>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/js/ecommerce.js') }}"></script>
    <!-- Plugins JS Ends-->

    <script>
        $(document).ready(function() {
            $('#u-rating-fontawesome').on('change', function() {
                var rating = $(this).val();
                var userId = {{ $userDetails->id }};

                console.log("User ID:", userId);
                console.log("Selected Rating:", rating);

                $.ajax({
                    url: "{{ route('business.review.Influencer') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        rating: rating,
                        user_id: userId
                    },
                    success: function(response) {
                        // alert(response.success);
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Rating submitted successfully",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(xhr) {
                        alert('An error occurred while submitting the rating.');
                    }
                });
            });
        });
    </script>

@endsection
