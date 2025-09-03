@extends('influencer.layout.main')
@section('content')
    <style>
        .connect-social-card {
            /* display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center; */
            padding: 20px;
            background-color: #ffffff;
            width: 100%;
            box-shadow: #53535361 0px 7px 15px 0px;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        .connect-social-card .sub-social-sec {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }

        .connect-social-card .sub-social-sec img {
            width: 80px;
            height: 80px;
        }

        .connect-social-card .sub-social-sec button {
            margin: 0px 10px;
        }

        .connect-social-card .title {
            color: #959595;
            font-size: 16px;
            margin-top: 10px;
        }

        .connect-social-card p {
            color: #424242;
            font-size: 23px;
            font-weight: 500;
            margin-top: 20px;
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
                timer: 4000
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
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
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


@if(!empty($channelData['items']))
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 mx-auto">
                <div class="connect-social-card">
                    <div class="sub-social-sec">
                        <img src="{{ asset('assets/images/socialconnect/youtube.png') }}" alt="">
                        <div class="title">Channel Name</div>
                    </div>
                    <div class="sub-social-sec">
                        <p>{{ $channelData['items'][0]['snippet']['title'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mx-auto">
                <div class="connect-social-card">
                    <div class="sub-social-sec">
                        <img src="{{ asset('assets/images/socialconnect/subscribe.png') }}" alt="">
                        <div class="title">Subscribers</div>
                    </div>
                    <div class="sub-social-sec">
                        <p>{{ $channelData['items'][0]['statistics']['subscriberCount'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mx-auto">
                <div class="connect-social-card">
                    <div class="sub-social-sec">
                        <img src="{{ asset('assets/images/socialconnect/views.png') }}" alt="">
                        <div class="title">Views</div>
                    </div>
                    <div class="sub-social-sec">
                        <p>{{ $channelData['items'][0]['statistics']['viewCount'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mx-auto">
                <div class="connect-social-card">
                    <div class="sub-social-sec">
                        <img src="{{ asset('assets/images/socialconnect/video.png') }}" alt="">
                        <div class="title">Videos</div>
                    </div>
                    <div class="sub-social-sec">
                        <p>{{ $channelData['items'][0]['statistics']['videoCount'] }}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="card p-5 mt-4">
            <h3>Upload video on Youtube</h3><br>
            <form action="{{ route('influencer.upload.youtube.video') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="title">Video Title:</label>
                    <input type="text" class="form-control" name="title" id="title" required>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Video Description:</label>
                    <textarea class="form-control" name="description" id="description" required></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="video">Video File:</label>
                    <input type="file" class="form-control" name="video" id="video" accept="video/*" required>
                </div>

                <button type="submit" class="btn btn-primary">Upload Video</button>
            </form>
        </div>

    </div>
@else
    <div class="card p-5">
        <form action="{{ route('influencer.refresh.youtube.token') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">Reconnect</button>&nbsp;&nbsp;
        </form>
    </div>
@endif
@endsection
