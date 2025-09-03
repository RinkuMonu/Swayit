@extends('influencer.layout.main')
@section('content')
<style>
.owl-nav button span {
    position: absolute;
    top: 50px !important;
    color: #797979;
    font-size: 40px !important;
}
.owl-prev span {
    left: -20px;
}
.owl-next span {
    right: -20px;
}
.owl-nav button span:hover {
    color: #11706f;
    transition: 0.5s;
}
.mobile-app-card {
    min-height: 200px;
}
</style>
    <!-- Page Sidebar Ends-->
        <div class="container-fluid">
            <div class="page-title">

                <div class="row">
                    <div class="col-6">
                        <h3>Social</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Social</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>


        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-3 col-ed-4 col-xl-4 box-col-4">
                    <div class="row">
                        <div class="col-xl-12 col-md-6">
                            <div class="card social-profile">
                                <div class="card-body">
                                    <div class="social-img-wrap">
                                        <div class="social-img">
                                            @if ($user->profile_img)
                                                <img src="{{ asset($user->profile_img) }}" class="" alt="...">
                                            @else
                                                <img class="" src="{{ asset('assets/images/dashboard-5/infpro.png') }}" alt="">
                                            @endif
                                            </div>
                                        <div class="edit-icon">
                                            <svg>
                                                <use href="../assets/svg/icon-sprite.svg#profile-check"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="social-details">
                                        <h5 class="mb-1">{{ $user->first_name }} {{ $user->last_name }}</h5><span
                                            class="f-light">{{ $user->email }}</span>
                                        <ul class="social-follow">
                                            <li>
                                                <h5 class="mb-0">{{ $total_gigs }}</h5><span class="f-light">Gigs</span>
                                            </li>
                                            <li>
                                                <h5 class="mb-0">{{ $total_contracts }}</h5><span class="f-light">Contracts</span>
                                            </li>
                                            <li>
                                                <h5 class="mb-0">{{ $total_bid_proposals }}</h5><span class="f-light">Proposals</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-6">
                            <div class="card mobile-app-card">
                                <div class="card-header card-no-border pb-0">
                                    <h5 class="mb-3"> <span class="f-16 f-light">EWALLET BALANCE</span> <br><br>${{ $wallet_balance }}.00</h5>
                                </div>
                                <div class="card-body p-0 text-end"><img class="wavy"
                                        src="https://admin.pixelstrap.com/cuba/assets/images/dashboard-5/wave.png"
                                        alt=""><img src="../assets/images/dashboard-5/ewallet.png"
                                        alt=""></div>
                                        <div></div>
                                        <div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-ed-8 col-xl-8 box-col-8e">
                    <div class="row">
                        <div class="col-md-12">
                        <div class="owl-carousel owl-theme">


 <div class="item">
    <div class="card social-widget widget-hover p-3 h-100">
        <div class="card-body d-flex flex-column justify-content-between">

            <!-- Facebook Header -->
            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="social-icons">
                    <img src="{{ asset('assets/images/socialconnect/facebook.png') }}" alt="Facebook icon" style="width: 40px; height:40px;">
                </div>
                <h5 class="mb-0">Facebook</h5>
            </div>

            <!-- Account Details -->
            @if(!empty($fbUsername))
                <div class="account-details text-center mb-3">
                    <h6 class="fw-semibold mb-2">Page Details</h6>
                    <div class="d-flex flex-column align-items-center">
                        @if(!empty($fbProfileImage))
                            <img src="{{ $fbProfileImage }}" alt="Profile Image" class="mb-2" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        @endif
                        <h6 class="mb-0">{{ $fbUsername }}</h6>
                        <small class="text-muted">Facebook Page Name</small>
                    </div>
                </div>
            @endif

            <!-- Followers and Posts -->
            <div class="d-flex justify-content-around text-center mt-auto pt-2 border-top">
                <div>
                    <h5 class="mb-1">{{ number_format($fbFollowers ?? 0) }}</h5>
                    <span class="f-light">Followers</span>
                </div>
                <div>
                    <h5 class="mb-1">{{ number_format($fbPosts ?? 0) }}</h5>
                    <span class="f-light">Posts</span>
                </div>
            </div>

        </div>
    </div>
</div>
    
 <div class="item">
    <div class="card social-widget widget-hover p-3 h-100">
        <div class="card-body d-flex flex-column justify-content-between">

            <!-- Instagram Header -->
            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="social-icons">
                    <img src="{{ asset('assets/images/socialconnect/instagram.png') }}" alt="Instagram icon" style="width: 40px; height:40px;">
                </div>
                <h5 class="mb-0">Instagram</h5>
            </div>

            <!-- Account Details -->
            @if(!empty($igUsername))
                <div class="account-details text-center mb-3">
                    <h6 class="fw-semibold mb-2">Account Details</h6>
                    <div class="d-flex flex-column align-items-center">
                        @if(!empty($igProfileImage))
                            <img src="{{ $igProfileImage }}" alt="Profile Image" class="mb-2" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        @endif
                        <h6 class="mb-0">{{ '@' . $igUsername }}</h6>
                        <small class="text-muted">Instagram Username</small>
                    </div>
                </div>
            @endif

            <!-- Followers and Posts -->
            <div class="d-flex justify-content-around text-center mt-auto pt-2 border-top">
                <div>
                    <h5 class="mb-1">{{ number_format($igFollowers ?? 0) }}</h5>
                    <span class="f-light">Followers</span>
                </div>
                <div>
                    <h5 class="mb-1">{{ number_format($igPosts ?? 0) }}</h5>
                    <span class="f-light">Posts</span>
                </div>
            </div>

        </div>
    </div>
</div>






                            <div class="item">
                                <div class="card social-widget widget-hover">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="social-icons">
                                                    <img src="{{ asset('assets/images/socialconnect/twitter.png') }}" alt="twitter icon" style="width: 40px; height:40px">
                                                </div><span>Twitter</span>
                                            </div>
                                        </div>
                                        <div class="social-content">
                                            <div>
                                                <h5 class="mb-1">{{ number_format($twFollowers) }}</h5><span class="f-light">Followers</span>
                                            </div>
                                            {{-- <div class="social-chart">
                                                <div id="radial-twitter"></div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="card social-widget widget-hover">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="social-icons">
                                                    <img src="{{ asset('assets/images/socialconnect/Tiktokpost.png') }}" alt="twitter icon" style="width: 40px; height:40px">
                                                </div><span>Tiktok</span>
                                            </div>
                                        </div>
                                        <div class="social-content">
                                            <div>
                                                <h5 class="mb-1">{{ number_format($tiktokFollowers) }}</h5><span class="f-light">Followers</span>
                                            </div>
                                            {{-- <div class="social-chart">
                                                <div id="radial-facebook"></div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
    <div class="card social-widget widget-hover">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="social-icons">
                        <img src="{{ asset('assets/images/socialconnect/youtube.png') }}" alt="youtube icon" style="width: 40px; height:40px">
                    </div>
                    <span>Youtube</span>
                </div>
            </div>
            <div class="social-content">
                <div>
                    <h5 class="mb-1">{{ number_format($subscribers) }}</h5>
                    <span class="f-light">Subscribers</span>
                </div>
                <div class="mt-2">
                    <h6 class="mb-1">{{ number_format($youtubeVideos) }}</h6>
                    <span class="f-light">Videos</span>
                </div>
            </div>
        </div>
    </div>
</div>


                            <div class="item">
                                <div class="card social-widget widget-hover">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="social-icons">
                                                    <img src="{{ asset('assets/images/socialconnect/snapchetpost.png') }}" alt="twitter icon" style="width: 40px; height:40px">
                                                    </div><span>Snapchat</span>
                                            </div>
                                        </div>
                                        <div class="social-content">
                                            <div>
                                                <h5 class="mb-1">{{ number_format($snapchatFollowers) }}</h5><span class="f-light">Followers</span>
                                            </div>
                                            {{-- <div class="social-chart">
                                                <div id="radial-facebook"></div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <div class="item">
                                <div class="card social-widget widget-hover">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="social-icons">
                                                    <img src="{{ asset('assets/images/socialconnect/Twitchpost.png') }}" alt="twitter icon" style="width: 40px; height:40px">
                                                    </div><span>Twitch</span>
                                            </div>
                                        </div>
                                        <div class="social-content">
                                            <div>
                                                <h5 class="mb-1">{{ number_format($twitchFollowers) }}</h5><span class="f-light">Followers</span>
                                            </div>
                                            {{-- <div class="social-chart">
                                                <div id="radial-facebook"></div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <div class="item">
                                <div class="card social-widget widget-hover">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="social-icons">
                                                    <img src="{{ asset('assets/images/socialconnect/Bereaalpost.png') }}" alt="twitter icon" style="width: 40px; height:40px">
                                                    </div><span>Bereaal</span>
                                            </div>
                                        </div>
                                        <div class="social-content">
                                            <div>
                                                <h5 class="mb-1">{{ number_format($berealFollowers) }}</h5><span class="f-light">Followers</span>
                                            </div>
                                            {{-- <div class="social-chart">
                                                <div id="radial-facebook"></div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <script>
                            $('.owl-carousel').owlCarousel({
                                loop:true,
                                margin:10,
                                nav:true,
                                autoplay:true,
                                autoplayTimeout: 4000,
                                dots: false,
                                responsive:{
                                    0:{
                                        items:1
                                    },
                                    600:{
                                        items:3
                                    },
                                    1000:{
                                        items:3
                                    }
                                }
                            })
                        </script>
                        {{-- <div class="col-md-4 col-sm-6">
                            <div class="card social-widget widget-hover">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="social-icons"><img src="../assets/images/dashboard-5/social/2.png"
                                                    alt="instagram icon"></div><span>Instagram</span>
                                        </div>
                                        <span class="font-success f-12 d-xxl-block d-xl-none">+27.4%</span>
                                    </div>
                                    <div class="social-content">
                                        <div>
                                            <h5 class="mb-1">15,080</h5><span class="f-light">Followers</span>
                                        </div>
                                        <div class="social-chart">
                                            <div id="radial-instagram"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card social-widget widget-hover">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="social-icons"><img src="../assets/images/dashboard-5/social/3.png"
                                                    alt="twitter icon"></div><span>Twitter</span>
                                        </div>
                                        <span class="font-success f-12 d-xxl-block d-xl-none">+14.09%</span>
                                    </div>
                                    <div class="social-content">
                                        <div>
                                            <h5 class="mb-1">12,564</h5><span class="f-light">Followers</span>
                                        </div>
                                        <div class="social-chart">
                                            <div id="radial-twitter"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        </div>
                        <div class="col-xxl-12 col-lg-12 box-col-12">
                            <div class="card">
                                <div class="card-header card-no-border">
                                    <h5>Total Revenue</h5>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row m-0 overall-card">
                                        <div class="col-xl-9 col-md-12 col-sm-7 p-0">
                                            <div class="chart-right">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="card-body p-0">
                                                            <ul class="balance-data">
                                                                <li><span class="circle bg-warning"> </span><span
                                                                        class="f-light ms-1">Earning</span></li>
                                                                <li><span class="circle bg-primary"> </span><span
                                                                        class="f-light ms-1">Expense</span></li>
                                                            </ul>
                                                            <div class="current-sale-container">
                                                                <div id="chart-currently"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-12 col-sm-5 p-0">
                                            <div class="row g-sm-4 g-2">
                                                <div class="col-xl-12 col-md-4">
                                                    <div class="light-card balance-card widget-hover">
                                                        <div class="svg-box">
                                                            <svg class="svg-fill">
                                                                <use
                                                                    href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#income">
                                                                </use>
                                                            </svg>
                                                        </div>
                                                        <div> <span class="f-light">This Month Income</span>
                                                            <h6 class="mt-1 mb-0">${{ $current_month_earings }}.00</h6>
                                                        </div>
                                                        {{-- <div class="ms-auto text-end">
                                                            <div class="dropdown icon-dropdown">
                                                                <button class="btn dropdown-toggle" id="incomedropdown"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    aria-expanded="false"><i
                                                                        class="icon-more-alt"></i></button>
                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                    aria-labelledby="incomedropdown"><a
                                                                        class="dropdown-item" href="#">Today</a><a
                                                                        class="dropdown-item"
                                                                        href="#">Tomorrow</a><a
                                                                        class="dropdown-item" href="#">Yesterday
                                                                    </a></div>
                                                            </div><span class="font-success">+$456</span>
                                                        </div> --}}
                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-md-4">
                                                    <div class="light-card balance-card widget-hover">
                                                        <div class="svg-box">
                                                            <svg class="svg-fill">
                                                                <use
                                                                    href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#doller-return">
                                                                </use>
                                                            </svg>
                                                        </div>
                                                        <div> <span class="f-light">E-wallet Balance</span>
                                                            <h6 class="mt-1 mb-0">${{ $wallet_balance }}.00</h6>
                                                        </div>
                                                        {{-- <div class="ms-auto text-end">
                                                            <div class="dropdown icon-dropdown">
                                                                <button class="btn dropdown-toggle" id="cashbackdropdown"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    aria-expanded="false"><i
                                                                        class="icon-more-alt"></i></button>
                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                    aria-labelledby="cashbackdropdown"><a
                                                                        class="dropdown-item" href="#">Today</a><a
                                                                        class="dropdown-item"
                                                                        href="#">Tomorrow</a><a
                                                                        class="dropdown-item" href="#">Yesterday
                                                                    </a></div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="card">
                    <div class="row py-5 text-center">
                        <div class="col-md-4">
                            <p>Total Amount Earned</p>
                            <h3>${{ $total_earings }}.00</h3>
                        </div>
                        <div class="col-md-4">
                            <p>Pending Amount</p>
                            <h3>${{ $pending_amount }}.00</h3>
                        </div>
                        <div class="col-md-4">
                            <p>Total Withdrawn</p>
                            <h3>${{ $total_withdraw }}.00</h3>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-xl-7">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0">Current Jobs</h5>
                                <div class="card-header-right-icon">
                                    <div class="dropdown icon-dropdown">
                                        <button class="btn dropdown-toggle" id="allcampButton" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                class="icon-more-alt"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="allcampButton"><a
                                                class="dropdown-item" href="#">Today</a><a class="dropdown-item"
                                                href="#">Tomorrow</a><a class="dropdown-item"
                                                href="#">Yesterday</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 campaign-table">
                            <div class="recent-table table-responsive currency-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="f-light">AD Platform</th>
                                            <th class="f-light">Business Name</th>
                                            <th class="f-light">Revenue</th>
                                            <th class="f-light">Deadline</th>
                                            <th class="f-light">Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border-icon facebook">
                                                <div>
                                                    <div class="social-circle"><i class="fa fa-facebook"></i></div>
                                                </div>
                                            </td>
                                            <td>Rave Info</td>

                                            <td>$9,786</td>
                                            <td>Apr 15, 2023</td>
                                            <td>
                                                <button class="btn badge-light-primary">Active</button>
                                            </td>

                                        <tr>
                                            <td class="border-icon instagram">
                                                <div>
                                                    <div class="social-circle"><i class="fa fa-instagram"></i></div>
                                                </div>
                                            </td>
                                            <td>Rave Info</td>

                                            <td>$9,786</td>
                                            <td>Apr 15, 2023</td>
                                            <td>
                                                <button class="btn badge-light-primary">Active</button>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="border-icon pinterest">
                                                <div>
                                                    <div class="social-circle"><i class="fa fa-pinterest"></i></div>
                                                </div>
                                            </td>
                                            <td>Rave Info</td>

                                            <td>$9,786</td>
                                            <td>Apr 15, 2023</td>
                                            <td>
                                                <button class="btn badge-light-primary">Active</button>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="border-icon twitter">
                                                <div>
                                                    <div class="social-circle"><i class="fa fa-twitter"></i></div>
                                                </div>
                                            </td>
                                            <td>Rave Info</td>

                                            <td>$9,786</td>
                                            <td>Apr 15, 2023</td>
                                            <td>
                                                <button class="btn badge-light-primary">Active</button>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="border-icon you-tube">
                                                <div>
                                                    <div class="social-circle"><i class="fa fa-youtube-play"></i></div>
                                                </div>
                                            </td>
                                            <td>Rave Info</td>

                                            <td>$9,786</td>
                                            <td>Apr 15, 2023</td>
                                            <td>
                                                <button class="btn badge-light-primary">Active</button>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0">Followers Growth</h5>
                                <div class="card-header-right-icon">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" id="viewButton" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">Today</button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="viewButton"><a
                                                class="dropdown-item" href="#">Today</a><a class="dropdown-item"
                                                href="#">Tomorrow</a><a class="dropdown-item"
                                                href="#">Yesterday</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="view-container">
                                <div id="growthchart"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-12 col-md-12 appointment-sec box-col-12">
                    <div class="card course-card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0">Popular Gigs</h5>
                            </div>
                        </div>
                        <div class="row p-2">
    @foreach($gig_list as $list)
        @php
            $gig_img = json_decode($list->images, true);
            $firstImage = (!empty($gig_img) && isset($gig_img[0])) ? $gig_img[0] : null;
            $gig_purchases = \App\Models\GigCheckout::where('gig_id', $list->id)->count();
        @endphp

        <div class="col-xl-3 col-sm-6">
            <div class="card social-profile">
                <div class="card-body">
                    <div class="icon-wrap">
                        @if ($firstImage)
                            <img src="{{ asset('storage/' . $firstImage) }}" class="img-fluid" style="height: 170px;" alt="...">
                        @else
                            <img class="img-fluid" src="{{ asset('assets/images/ecommerce/01.jpg') }}" alt="">
                        @endif
                    </div>
                    <div class="social-details">
                        <h5 class="mb-1">
                            <a href="{{ route('influencer.view.gigs', $list->id) }}">{{ $list->title }}</a>
                        </h5><br>
                        <h5 class="mb-0">{{ $gig_purchases }}</h5>
                        <span class="f-light">Purchases</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

                            {{-- <div class="col-xl-3 col-sm-6">
                                <div class="card social-profile">
                                    <div class="card-body">
                                        <div class="icon-wrap"><img src="../assets/images/dashboard-3/course/2.png"
                                                alt="clock vector"></div>
                                        <div class="social-details">
                                            <h5 class="mb-1"><a href="social-app.html">Management</a></h5>
                                            <ul class="social-follow">
                                                <li>
                                                    <h5 class="mb-0">450</h5><span class="f-light">Viewed</span>
                                                </li>
                                                <li>
                                                    <h5 class="mb-0">150</h5><span class="f-light">Clicks</span>
                                                </li>
                                                <li>
                                                    <h5 class="mb-0">5</h5><span class="f-light">New&nbsp;Offers</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card social-profile">
                                    <div class="card-body">
                                        <div class="icon-wrap"><img src="../assets/images/dashboard-3/course/3.png"
                                                alt="clock vector"></div>
                                        <div class="social-details">
                                            <h5 class="mb-1"><a href="social-app.html">Web Devlopment</a></h5>
                                            <ul class="social-follow">
                                                <li>
                                                    <h5 class="mb-0">450</h5><span class="f-light">Viewed</span>
                                                </li>
                                                <li>
                                                    <h5 class="mb-0">150</h5><span class="f-light">Clicks</span>
                                                </li>
                                                <li>
                                                    <h5 class="mb-0">5</h5><span class="f-light">New&nbsp;Offers</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card social-profile">
                                    <div class="card-body">
                                        <div class="icon-wrap"><img src="../assets/images/dashboard-3/course/4.png"
                                                alt="clock vector"></div>
                                        <div class="social-details">
                                            <h5 class="mb-1"><a href="social-app.html">Business Analytics</a></h5>
                                            <ul class="social-follow">
                                                <li>
                                                    <h5 class="mb-0">450</h5><span class="f-light">Viewed</span>
                                                </li>
                                                <li>
                                                    <h5 class="mb-0">150</h5><span class="f-light">Clicks</span>
                                                </li>
                                                <li>
                                                    <h5 class="mb-0">5</h5><span class="f-light">New&nbsp;Offers</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card social-profile">
                                    <div class="card-body">
                                        <div class="icon-wrap"><img src="../assets/images/dashboard-3/course/5.png"
                                                alt="clock vector"></div>
                                        <div class="social-details">
                                            <h5 class="mb-1"><a href="social-app.html">Marketing</a></h5>
                                            <ul class="social-follow">
                                                <li>
                                                    <h5 class="mb-0">450</h5><span class="f-light">Viewed</span>
                                                </li>
                                                <li>
                                                    <h5 class="mb-0">150</h5><span class="f-light">Clicks</span>
                                                </li>
                                                <li>
                                                    <h5 class="mb-0">5</h5><span class="f-light">New&nbsp;Offers</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>

                <div class="container-fluid calendar-basic">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" id="wrap">
                                <div class="col-xxl-3 box-col-12">
                                    <div class="md-sidebar mb-3"><a class="btn btn-primary md-sidebar-toggle"
                                            href="javascript:void(0)">calendar filter</a>
                                        <div class="md-sidebar-aside job-left-aside custom-scrollbar">
                                            <div id="external-events">
                                                <h4> Events</h4>
                                                <div id="external-events-list">
                                                    <div
                                                        class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-warning">
                                                        <div class="fc-event-main"> <i
                                                                class="fa fa-birthday-cake me-2"></i>Birthday Party</div>
                                                    </div>
                                                    <div
                                                        class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event">
                                                        <div class="fc-event-main"> <i class="fa fa-user me-2"></i>Meeting
                                                            With Team.</div>
                                                    </div>
                                                    <div
                                                        class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-info">
                                                        <div class="fc-event-main"> <i class="fa fa-plane me-2"></i>Tour &
                                                            Picnic</div>
                                                    </div>
                                                    <div
                                                        class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-danger">
                                                        <div class="fc-event-main"> <i
                                                                class="fa fa-file-text me-2"></i>Reporting Schedule</div>
                                                    </div>
                                                    <div
                                                        class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-success">
                                                        <div class="fc-event-main"> <i
                                                                class="fa fa-briefcase me-2"></i>Lunch & Break</div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-9 box-col-12">
                                    <div class="calendar-default" id="calendar-container">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- <div class="container-fluid">
                <div class="row">
                    <div class="col-xxl-5 col-ed-5 col-md-5 box-col-5">
                        <div class="card">
                            <div class="card-header card-no-border">
                                <div class="header-top">
                                    <h5>Interested Bids</h5>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="recent-table table-responsive currency-table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="f-light">Bid Name</th>
                                                <th class="f-light">Price</th>

                                                <th class="f-light">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 1</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>


                                                <td>
                                                    <button class="btn badge-light-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 2</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>


                                                <td>
                                                    <button class="btn badge-light-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 3</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>


                                                <td>
                                                    <button class="btn badge-light-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 4</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>


                                                <td>
                                                    <button class="btn badge-light-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 5</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>

                                                <td>
                                                    <button class="btn badge-light-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 5</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>

                                                <td>
                                                    <button class="btn badge-light-primary">View</button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-7 col-ed-7 col-md-7 box-col-7">
                        <div class="card">
                            <div class="card-header card-no-border">
                                <div class="header-top">
                                    <h5>Pending Bids</h5>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="recent-table table-responsive currency-table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="f-light">Bid Name</th>
                                                <th class="f-light">Price</th>
                                                <th class="f-light">Date</th>

                                                <th class="f-light">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 1</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>
                                                <td>
                                                    Feb 12, 2023
                                                </td>

                                                <td>
                                                    <button class="btn badge-light-primary">Accept</button>
                                                    <button class="btn badge-light-danger">Decline</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 2</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>
                                                <td>
                                                    Feb 12, 2023
                                                </td>

                                                <td>
                                                    <button class="btn badge-light-primary">Accept</button>
                                                    <button class="btn badge-light-danger">Decline</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 3</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>
                                                <td>
                                                    Feb 12, 2023
                                                </td>

                                                <td>
                                                    <button class="btn badge-light-primary">Accept</button>
                                                    <button class="btn badge-light-danger">Decline</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 4</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>
                                                <td>
                                                    Feb 12, 2023
                                                </td>

                                                <td>
                                                    <button class="btn badge-light-primary">Accept</button>
                                                    <button class="btn badge-light-danger">Decline</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 5</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>
                                                <td>
                                                    Feb 12, 2023
                                                </td>

                                                <td>
                                                    <button class="btn badge-light-primary">Accept</button>
                                                    <button class="btn badge-light-danger">Decline</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-0 f-w-400">Bid 5</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$13,098.09</td>
                                                <td>
                                                    Feb 12, 2023
                                                </td>

                                                <td>
                                                    <button class="btn badge-light-primary">Accept</button>
                                                    <button class="btn badge-light-danger">Decline</button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- Container-fluid Ends-->
        </div>


    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
    {{-- </section> --}}
@endsection
