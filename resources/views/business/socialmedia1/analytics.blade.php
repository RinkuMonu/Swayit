<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Analytics</title>
    <!-- YouTube Favicon -->
    <link rel="icon" href="https://www.youtube.com/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            /* background: linear-gradient(135deg, #6e7cfa, #3141c1); */
            background: #aaaaaabf;
            color: #fff;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            /* background: rgba(255, 255, 255, 0.1); */
            background: linear-gradient(135deg, #7d89ed, #0d0d17);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #fff;
            font-size: 3em;
            letter-spacing: 2px;
            margin-bottom: 20px;
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

        .analytics {
            margin-top: 30px;
            animation: fadeIn 1.2s ease-out;
        }

        .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 15px;
        }

        .profile h2 {
            font-size: 1.8em;
            color: #fff;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        /* .analytics img {
            width: 100%;
            max-width: 250px;
            border-radius: 12px;
            margin: 20px auto;
            display: block;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        } */

        .stats {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            margin: 30px 0;
        }

        .stats div {
            text-align: center;
            flex: 1;
            min-width: 180px;
            margin: 15px;
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stats div:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .stats div p {
            font-size: 1.6em;
            color: #fff;
            font-weight: bold;
        }

        .stats div i {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .stats .subscribers {
            background-color: #e431c1;
            color: #fff;
        }

        .stats .views {
            background-color: #ff5722;
            color: #fff;
        }

        .stats .videos {
            background-color: #4caf50;
            color: #fff;
        }

        .stats .avg-views {
            background-color: #08adc6;
            color: #fff;
        }

        .description {
            margin-top: 20px;
            font-size: 1.2em;
            text-align: justify;
            line-height: 1.6;
        }

        .video-details {
            margin-top: 30px;
        }

        .video-details h3 {
            text-align: center;
            font-size: 2em;
            color: #fff;
            margin-bottom: 20px;
        }

        .videos-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .video-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 300px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #333;
        }

        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .video-thumbnail iframe {
            width: 100%;
            height: 200px;
            border: none;
            border-radius: 10px;
            transition: transform 0.2s ease-in-out;
        }

        .video-thumbnail iframe:hover {
            transform: scale(1.05);
        }

        .video-info {
            padding: 15px;
            text-align: center;
        }

        .video-info .views {
            font-size: 1.2em;
            font-weight: bold;
            color: #6e7cfa;
        }

        .video-info .date {
            font-size: 0.9em;
            color: #999;
            margin-top: 5px;
        }

        .no-data {
            text-align: center;
            padding: 50px;
            background-color: rgba(255, 123, 123, 0.2);
            color: #d9534f;
            border-radius: 10px;
            font-size: 1.2em;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .stats {
                flex-direction: column;
                align-items: center;
            }

            .video-card {
                max-width: 100%;
            }

            .search-form input[type="text"] {
                width: 300px;
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>YouTube Channel Analytics</h1>
        <form class="search-form" method="GET" action="{{ route('youtube.analytics') }}">
            <input type="text" name="channel_id" id="channel_id" placeholder="Enter YouTube Channel ID" required>
            <button type="submit">Search</button>
        </form>

        @if ($channel)
            @foreach ($channel->getItems() as $item)
                <div class="analytics">
                    <div class="profile">
                        <img src="{{ $item['snippet']['thumbnails']['high']['url'] ?? asset('images/default-thumbnail.jpg') }}"
                            alt="Channel Thumbnail">
                        <h2>{{ $item['snippet']['title'] ?? 'Channel Name' }}</h2>
                    </div>

                    <div class="stats">
                        <div class="subscribers">
                            <p>{{ formatCount($item['statistics']['subscriberCount'] ?? 0) }}</p>
                            <i class="fas fa-users"></i> <!-- Subscribers Icon -->
                            <p>Subscribers</p>
                        </div>
                        <div class="views">
                            <p>{{ formatCount($item['statistics']['viewCount'] ?? 0) }}</p>
                            <i class="fas fa-eye"></i> <!-- Views Icon -->
                            <p>Total Views</p>
                        </div>
                        <div class="videos">
                            <p>{{ formatCount($item['statistics']['videoCount'] ?? 0) }}</p>
                            <i class="fas fa-video"></i> <!-- Video Icon -->
                            <p>Total Videos</p>
                        </div>
                        <div class="avg-views">
                            <p>
                                {{ $item['statistics']['viewCount'] && $item['statistics']['videoCount'] > 0
                                    ? formatCount($item['statistics']['viewCount'] / $item['statistics']['videoCount'], 2)
                                    : 'N/A' }}
                            </p>
                            <i class="fas fa-chart-line"></i> <!-- Avg Views Icon -->
                            <p>Avg Views/Video</p>
                        </div>
                    </div>


                    <div class="description">
                        <strong>Description:</strong>
                        <p>{{ $item['snippet']['description'] ?? 'No description available.' }}</p>
                    </div>

                    <div class="video-details">
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
                    </div>

                </div>
            @endforeach
        @else
            <div class="no-data">
                <p>No analytics data available. Please enter a valid Channel ID.</p>
            </div>
        @endif
    </div>
</body>

</html>