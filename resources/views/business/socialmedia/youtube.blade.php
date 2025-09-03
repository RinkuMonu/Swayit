@extends('business.layout.main')
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


        .search-form {
            display: flex;
            justify-content: center;
            margin: 30px 0;
            animation: fadeIn 1s ease-out;
        }

        .search-form input[type="text"] {
            width: 350px;
            padding: 12px;
            font-size: 18px;
            border: none;
            border-radius: 30px 0 0 30px;
            outline: none;
            background: #fff;
            color: #333;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .search-form input[type="text"]:focus {
            width: 450px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .search-form button {
            padding: 12px 25px;
            font-size: 18px;
            color: #fff;
            background: #6e7cfa;
            border: none;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            transition: background 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .search-form button:hover {
            background: #3141c1;
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
                    <h3>Search Youtube Channels</h3>
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


    <form class="search-form" method="GET" action="{{ route('business.youtube.data') }}">
        <input type="text" name="channel_id" id="channel_id" placeholder="Enter YouTube Channel ID" required>
        <button type="submit">Search</button>
    </form>

@if(!empty($channelData['items']))
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="connect-social-card">
                    <div class="sub-social-sec">
                        {{-- <img src="{{ asset('assets/images/socialconnect/youtube.png') }}" alt=""> --}}
                        <img src="{{ $channelData['items'][0]['snippet']['thumbnails']['high']['url'] ?? asset('images/default-thumbnail.jpg') }}" alt="Channel Thumbnail" style="border: 2px solid #d3d3d3;border-radius: 50%;">
                        <div class="title">Channel Name</div>
                    </div>
                    <div class="sub-social-sec">
                        <p>{{ $channelData['items'][0]['snippet']['title'] }}</p>
                    </div>

                    <div class="description">
                        <div class="text-center">
                            <strong>Description:</strong>
                        </div>
                        <div class="text">{{ $channelData['items'][0]['snippet']['description'] ?? 'No description available.' }}</div>
                    </div>

                </div>
            </div>
            <div class="col-md-4 mx-auto">
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
            <div class="col-md-4 mx-auto">
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
            <div class="col-md-4 mx-auto">
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


        
        {{-- <div class="video-details">
            <h3>Top Performing Videos</h3>
            @if (!empty($topVideos))
                <div class="videos-container">
                    @foreach ($topVideos as $video)
                        <div class="video-card">
                            <div class="video-thumbnail">
                                <iframe src="https://www.youtube.com/embed/{{ $video['videoId'] }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                            <div class="video-info">
                                <p class="views">{{ formatCount($video['views']) }} views</p>
                                <p class="date">
                                    {{ \Carbon\Carbon::parse($video['publishedDate'])->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No videos available for this channel.</p>
            @endif
        </div> --}}

    </div>
@else
    <div class="card p-5">
        <form action="{{ route('business.refresh.youtube.token') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">Reconnect</button>&nbsp;&nbsp;
        </form>
    </div>
@endif
@endsection