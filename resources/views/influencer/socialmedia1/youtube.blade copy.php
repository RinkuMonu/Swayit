<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Channel Info</title>
    <!-- Add any CSS styling here -->
</head>
<body>
    <div class="container">
        <h1>YouTube Channel Information</h1>

        <!-- Display error if any -->
        @if (isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif

        <!-- Display YouTube channel information -->
        @if (isset($channelData) && !isset($error))
            <div class="channel-info">
                <h2>Channel Details</h2>
                <p><strong>Title:</strong> {{ $channelData['items'][0]['snippet']['title'] }}</p>
                <p><strong>Description:</strong> {{ $channelData['items'][0]['snippet']['description'] }}</p>
                <p><strong>Subscribers:</strong> {{ $channelData['items'][0]['statistics']['subscriberCount'] }}</p>
                <p><strong>Views:</strong> {{ $channelData['items'][0]['statistics']['viewCount'] }}</p>
                <p><strong>Videos:</strong> {{ $channelData['items'][0]['statistics']['videoCount'] }}</p>
                <p><strong>Channel ID:</strong> {{ $channelData['items'][0]['id'] }}</p>
            </div>
        @endif
    </div>
</body>
</html>