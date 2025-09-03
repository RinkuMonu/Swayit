<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\YouTube;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class YouTubeController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google-oauth-credentials.json'));
        $this->client->addScope([
            'https://www.googleapis.com/auth/youtube.readonly',
            'https://www.googleapis.com/auth/yt-analytics.readonly',
        ]);
        $this->client->setRedirectUri(route('youtube.callback'));
        $this->client->setAccessType('offline');
    }

    public function auth()
    {
        $authUrl = $this->client->createAuthUrl();
        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $this->client->fetchAccessTokenWithAuthCode($request->code);
        $accessToken = $this->client->getAccessToken();
        Session::put('youtube_access_token', $accessToken);

        return redirect()->route('business.socialmedia.analytics');
    }

    // public function showAnalytics()
    // {
    //     if (!Session::has('youtube_access_token')) {
    //         return redirect()->route('youtube.auth');
    //     }

    //     $this->client->setAccessToken(Session::get('youtube_access_token'));

    //     $youtube = new YouTube($this->client);
    //     $channelResponse = $youtube->channels->listChannels('snippet,statistics', ['mine' => true]);

    //     return view('youtube.analytics', ['channel' => $channelResponse]);
    // }

    public function showAnalytics(Request $request)
    {
        $this->client->setAccessToken(Session::get('youtube_access_token'));

        $youtube = new YouTube($this->client);

        // Get the channel ID from the request or use a default
        $channelId = $request->get('channel_id', 'UCnhpu5maYgIrJ6KrHjH1spA'); // Replace with default channel ID

        // Fetch channel details
        $channelResponse = $youtube->channels->listChannels('snippet,statistics,contentDetails', [
            'id' => $channelId,
        ]);

        if ($channelResponse->getItems()) {
            $channel = $channelResponse->getItems()[0];
            $uploadsPlaylistId = $channel['contentDetails']['relatedPlaylists']['uploads'];

            // Fetch videos from the uploads playlist
            $playlistItems = $youtube->playlistItems->listPlaylistItems('snippet,contentDetails', [
                'playlistId' => $uploadsPlaylistId,
                'maxResults' => 50, // Fetch up to 50 videos for analysis
            ]);

            $videos = [];
            foreach ($playlistItems->getItems() as $item) {
                $videoId = $item['contentDetails']['videoId'];
                $videoResponse = $youtube->videos->listVideos('snippet,statistics', [
                    'id' => $videoId,
                ]);

                // Check if video details are available
                $videoDetails = $videoResponse->getItems();
                if (!empty($videoDetails)) {
                    $videoDetails = $videoDetails[0]; // Access the first item safely
                    $videos[] = [
                        'videoId' => $videoId,
                        'views' => $videoDetails['statistics']['viewCount'] ?? 0, // Default to 0 if not available
                        'publishedDate' => $videoDetails['snippet']['publishedAt'] ?? null,
                    ];
                }
            }

            // Sort videos by views in descending order
            usort($videos, function ($a, $b) {
                return $b['views'] - $a['views'];
            });

            // Take the top 5 videos
            $topVideos = array_slice($videos, 0, 5);

            return view('business.socialmedia.analytics', [
                'channel' => $channelResponse,
                'topVideos' => $topVideos,
            ]);
        }

        return view('business.socialmedia.analytics', ['channel' => null, 'topVideos' => []]);
    }
}