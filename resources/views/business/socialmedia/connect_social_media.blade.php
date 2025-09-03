@extends('business.layout.main')
@section('content')

<style>
    .connect-social-card {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: #ffffff;
        width: 100%;
        box-shadow: #53535361 0px 7px 15px 0px;
        margin-bottom: 15px;
        border-radius: 10px;
    }
    .connect-social-card .sub-social-sec {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
    .connect-social-card .sub-social-sec img {
        width: 40px;
        height: 40px;
        margin-right: 15px;
    }
    .connect-social-card .sub-social-sec button {
        margin: 0px 10px;
    }
    .connect-social-card .title {
        color: #565656;
        font-size: 19px;
        font-weight: 400;
    }
    .connect-social-card .social-info-btn {
        border: none;
        background-color: #838383;
        color: #ffffff;
        padding: 4px 8px;
        border-radius: 50%;
    }
</style>
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
@if (session()->has('error'))
<script>
    Swal.fire({
        position: "center",
        icon: "error",
        title: "{{ session('error') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Connect to your Social Accounts</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                </use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Connect Media</li>
                </ol>
            </div>
        </div>
    </div>
</div>



<div class="container-fluid">
    @php
        $currentTime = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
    @endphp
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="connect-social-card">
                <div class="sub-social-sec">
                    <img src="{{ asset('assets/images/socialconnect/facebook.png') }}" alt="">
                    <div class="title">Facebook</div>
                </div>
                <div class="sub-social-sec">
                    {{-- <a href="" class="btn btn-primary">Connect</a>&nbsp;&nbsp; --}}
                    <a href="{{ route('business.upload.facebook') }}" class="btn btn-primary">Upload</a>&nbsp;&nbsp;
                    <button type="button" class="social-info-btn" data-bs-toggle="modal" data-bs-target="#facebookDetails"><i class="fa fa-info-circle"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="connect-social-card">
                <div class="sub-social-sec">
                    <img src="{{ asset('assets/images/socialconnect/instagram.png') }}" alt="">
                    <div class="title">Instagram</div>
                </div>
                <div class="sub-social-sec">
                    {{-- @if($instagram_details)
                        <a href="{{ route('business.getInstagram') }}" class="btn btn-primary" target="_blank">View</a>
                    @else
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#instagramConnect">Connect</button>
                    @endif
                    &nbsp;&nbsp; --}}
                    <a href="{{ route('business.upload.instagram') }}" class="btn btn-primary">Upload</a>&nbsp;&nbsp;
                    {{-- <button type="" class="btn btn-primary">Connect</button> --}}
                    <button type="button" class="social-info-btn" data-bs-toggle="modal" data-bs-target="#instagramDetails"><i class="fa fa-info-circle"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="connect-social-card">
                <div class="sub-social-sec">
                    <img src="{{ asset('assets/images/socialconnect/youtube.png') }}" alt="">
                    <div class="title">Youtube</div>
                </div>
                <div class="sub-social-sec">
                    {{-- @if($googleUser)
                        @if($currentTime > $googleUser->google_token_expires_in)                        
                        <form action="{{ route('business.refresh.youtube.token') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary">Reconnect</button>&nbsp;&nbsp;
                        </form>
                        @else
                            <a href="{{ route('business.youtube.data') }}" class="btn btn-primary" target="_blank">Get Details</a>&nbsp;&nbsp;
                        @endif
                    @else
                        <a href="{{ route('auth.google') }}" class="btn btn-primary">Connect</a>&nbsp;&nbsp;
                    @endif --}}
                    {{-- <a href="{{ route('business.youtube.data') }}" class="btn btn-primary" target="_blank">View</a> --}}
                    <a href="{{ route('business.upload.youtube') }}" class="btn btn-primary">Upload</a>&nbsp;&nbsp;
                    <button type="button" class="social-info-btn" data-bs-toggle="modal" data-bs-target="#youtubeDetails"><i class="fa fa-info-circle"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="connect-social-card">
                <div class="sub-social-sec">
                    <img src="{{ asset('assets/images/socialconnect/twitter.png') }}" alt="">
                    <div class="title">Twitter</div>
                </div>
                <div class="sub-social-sec">
                    {{-- <a href="" class="btn btn-primary">Connect</a>&nbsp;&nbsp; --}}
                    <a href="{{ route('business.upload.twitter') }}" class="btn btn-primary">Upload</a>&nbsp;&nbsp;
                    <button type="button" class="social-info-btn" data-bs-toggle="modal" data-bs-target="#twitterDetails"><i class="fa fa-info-circle"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="connect-social-card">
                <div class="sub-social-sec">
                    <img src="{{ asset('assets/images/socialconnect/Tiktokpost.png') }}" alt="">
                    <div class="title">Tiktok</div>
                </div>
                <div class="sub-social-sec">
                    {{-- <a href="" class="btn btn-primary">Connect</a>&nbsp;&nbsp; --}}
                    <a href="{{ route('business.upload.tiktok') }}" class="btn btn-primary">Upload</a>&nbsp;&nbsp;
                    <button type="button" class="social-info-btn" data-bs-toggle="modal" data-bs-target="#tiktokDetails"><i class="fa fa-info-circle"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="connect-social-card">
                <div class="sub-social-sec">
                    <img src="{{ asset('assets/images/socialconnect/snapchetpost.png') }}" alt="">
                    <div class="title">Snapchat</div>
                </div>
                <div class="sub-social-sec">
                    {{-- <a href="" class="btn btn-primary">Connect</a>&nbsp;&nbsp; --}}
                    <a href="{{ route('business.upload.snapchat') }}" class="btn btn-primary">Upload</a>&nbsp;&nbsp;
                    <button type="button" class="social-info-btn" data-bs-toggle="modal" data-bs-target="#snapchatDetails"><i class="fa fa-info-circle"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="connect-social-card">
                <div class="sub-social-sec">
                    <img src="{{ asset('assets/images/socialconnect/Bereaalpost.png') }}" alt="">
                    <div class="title">Bereal</div>
                </div>
                <div class="sub-social-sec">
                    {{-- <a href="" class="btn btn-primary">Connect</a>&nbsp;&nbsp; --}}
                    <a href="{{ route('business.upload.bereal') }}" class="btn btn-primary">Upload</a>&nbsp;&nbsp;
                    <button type="button" class="social-info-btn" data-bs-toggle="modal" data-bs-target="#berealDetails"><i class="fa fa-info-circle"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="connect-social-card">
                <div class="sub-social-sec">
                    <img src="{{ asset('assets/images/socialconnect/Twitchpost.png') }}" alt="">
                    <div class="title">Twitch</div>
                </div>
                <div class="sub-social-sec">
                    {{-- <a href="" class="btn btn-primary">Connect</a>&nbsp;&nbsp; --}}
                    <a href="{{ route('business.upload.twitch') }}" class="btn btn-primary">Upload</a>&nbsp;&nbsp;
                    <button type="button" class="social-info-btn" data-bs-toggle="modal" data-bs-target="#twitchDetails"><i class="fa fa-info-circle"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="instagramConnect" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Connect to Instagram</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('business.connectInstagram') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body p-3">
                <div class="form-group mb-2">
                    <p>Add Instagram Id.</p>
                    <input type="text" id="username" name="username" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="facebookDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Facebook Connection Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>{!! $socialMedia->facebook !!}</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="instagramDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Instagram Connection Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>{!! $socialMedia->instagram !!}</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="youtubeDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Youtube Connection Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>{!! $socialMedia->youtube !!}</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="twitterDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Twitter Connection Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>{!! $socialMedia->twitter !!}</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="tiktokDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tiktok Connection Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>{!! $socialMedia->tiktok !!}</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="snapchatDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Snapchat Connection Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>{!! $socialMedia->snapchat !!}</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="berealDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Bereal Connection Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>{!! $socialMedia->bereal !!}</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="twitchDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Twitch Connection Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>{!! $socialMedia->twitch !!}</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

@endsection