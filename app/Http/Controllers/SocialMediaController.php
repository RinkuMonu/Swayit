<?php

namespace App\Http\Controllers;

require_once app_path('Helpers/TikTokHelper.php');

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_Video;
use Google_Service_YouTube_VideoSnippet;
use Google_Service_YouTube_VideoStatus;
use Google_Http_MediaFileUpload;
use Illuminate\Support\Facades\Auth;
use App\Models\InstgramConnection;
use Illuminate\Support\Facades\Log;
use Facebook\Facebook;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Http;
use App\Models\FacebookConnection;
use App\Models\TwitterConnection;
use App\Models\SocialMedias;
use App\Models\GoogleUser;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Jobs\PostToFacebookJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\FacebookPost;




class SocialMediaController extends Controller
{

    public function connectSocialMedia()
    {
        $currentUser = Auth::user();
        $googleUser = GoogleUser::where('user_id', $currentUser->id)->first();
        $socialMedia = SocialMedias::orderBy('id', 'desc')->first();
        $instagram_details = InstgramConnection::where('user_id', $currentUser->id)->first();

        return view('influencer.socialmedia.connect_social_media', compact('googleUser', 'currentUser', 'socialMedia', 'instagram_details'));
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'media' => 'required|image',
            'caption' => 'nullable|string',
            'schedule_time' => 'nullable|date',
        ]);

        if ($request->has('schedule') && $request->schedule_time) {
            // Save to DB to queue for later
            ScheduledPost::create([
                'user_id' => auth()->id(),
                'type' => 'photo',
                'media_path' => $request->file('media')->store('instagram_photos'),
                'caption' => $request->caption,
                'scheduled_at' => Carbon::parse($request->schedule_time),
            ]);
        } else {
            // Post immediately via Instagram Graph API
            $this->postToInstagramNow($request->file('media'), $request->caption);
        }

        return back()->with('success', 'Post submitted successfully!');
    }


    public function submitPost(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user->facebook_page_id || !$user->facebook_page_token) {
                return redirect()->back()->with('error', 'Facebook page connection not found. Please reconnect your Facebook Page.');
            }

            // Photo Post
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $caption = $request->input('caption_photo', '');

                $response = Http::attach(
                    'source',
                    file_get_contents($photo->getRealPath()),
                    $photo->getClientOriginalName()
                )->post("https://graph.facebook.com/v17.0/{$user->facebook_page_id}/photos", [
                    'caption' => $caption,
                    'access_token' => $user->facebook_page_token,
                ]);

                $result = $response->json();

                if (isset($result['id'])) {
                    return redirect()->back()->with('success', 'Photo posted successfully to Facebook!');
                }

                \Log::error('Facebook Photo Upload Failed', $result);
                return redirect()->back()->with('error', 'Failed to post photo: ' . ($result['error']['message'] ?? 'Unknown error'));
            }

            // Video Post
            if ($request->hasFile('video')) {
                $video = $request->file('video');
                $caption = $request->input('caption_video', '');

                $response = Http::attach(
                    'source',
                    file_get_contents($video->getRealPath()),
                    $video->getClientOriginalName()
                )->post("https://graph.facebook.com/v17.0/{$user->facebook_page_id}/videos", [
                    'description' => $caption,
                    'access_token' => $user->facebook_page_token,
                ]);

                $result = $response->json();

                if (isset($result['id'])) {
                    return redirect()->back()->with('success', 'Video posted successfully to Facebook!');
                }

                \Log::error('Facebook Video Upload Failed', $result);
                return redirect()->back()->with('error', 'Failed to post video: ' . ($result['error']['message'] ?? 'Unknown error'));
            }

            // Text Post
            if ($request->filled('caption_text')) {
                $caption = $request->input('caption_text');

                $response = Http::post("https://graph.facebook.com/v17.0/{$user->facebook_page_id}/feed", [
                    'message' => $caption,
                    'access_token' => $user->facebook_page_token,
                ]);

                $result = $response->json();

                if (isset($result['id'])) {
                    return redirect()->back()->with('success', 'Text post uploaded successfully to Facebook!');
                }

                \Log::error('Facebook Text Post Failed', $result);
                return redirect()->back()->with('error', 'Failed to post text: ' . ($result['error']['message'] ?? 'Unknown error'));
            }

            return redirect()->back()->with('error', 'No content found to upload. Please attach a photo, video, or enter text.');
        } catch (\Throwable $e) {
            \Log::error('Post upload failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Post upload failed: ' . $e->getMessage());
        }
    }





    public function callback()
    {
        try {
            $fbUser = Socialite::driver('facebook')
                ->redirectUrl(route('auth.instagram')) 
                ->stateless()
                ->user();

            $userAccessToken = $fbUser->token;

            auth()->user()->update([
                'facebook_token' => $userAccessToken,
            ]);

            // Step 1: Get the list of pages
            $response = Http::get("https://graph.facebook.com/v17.0/me/accounts", [
                'fields' => 'id,name,access_token',
                'access_token' => $userAccessToken,
            ]);

            $pages = $response->json()['data'] ?? [];

            if (empty($pages)) {
                return redirect()->route('influencer.connect.social.media')
                    ->with('error', 'No Facebook Pages found.');
            }
            $fixedPageId = '668926339643274'; 
            $selectedPage = collect($pages)->firstWhere('id', $fixedPageId);

            if (!$selectedPage) {
                return redirect()->route('influencer.connect.social.media')
                    ->with('error', 'The required Facebook Page was not found in your account.');
            }

            // Step 3: Get Instagram business account
            $igResponse = Http::get("https://graph.facebook.com/v17.0/{$fixedPageId}", [
                'fields' => 'instagram_business_account',
                'access_token' => $selectedPage['access_token'],
            ]);

            $igData = $igResponse->json();
            $igId = $igData['instagram_business_account']['id'] ?? null;

            if ($igId) {
                auth()->user()->update([
                    'instagram_account_id'  => $igId,
                    'facebook_page_id'      => $fixedPageId,
                    'facebook_page_token'   => $selectedPage['access_token'],
                ]);

                return redirect()->route('influencer.connect.social.media')
                    ->with('success', 'Instagram account connected successfully with your selected Facebook Page.');
            }

            return redirect()->route('influencer.connect.social.media')
                ->with('error', 'This Page does not have a linked Instagram Business Account.');
        } catch (\Throwable $e) {
            \Log::error('Instagram connection failed: ' . $e->getMessage());
            return redirect()->route('influencer.connect.social.media')
                ->with('error', 'Instagram connection failed: ' . $e->getMessage());
        }
    }









    public function redirectToYouTube()
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->addScope('https://www.googleapis.com/auth/youtube.upload');
        $client->addScope('https://www.googleapis.com/auth/youtube.readonly');
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return redirect()->away($client->createAuthUrl());
    }

  public function uploadVideoToInstagram(Request $request)
{
    $request->validate([
        'video' => 'required|file|mimetypes:video/mp4|max:51200', // Max 50MB
        'caption' => 'nullable|string|max:2200',
    ]);

    $user = auth()->user();

    if (!$user->instagram_account_id || !$user->facebook_page_token) {
        return back()->with('error', 'Instagram account or token missing.');
    }

    try {
        // Save video publicly
        $videoFile = $request->file('video');
        $fileName = uniqid('ig_video_') . '.' . $videoFile->getClientOriginalExtension();
        $videoFile->move(public_path('instagram_uploads'), $fileName);
        $videoUrl = url('instagram_uploads/' . $fileName); // Must be public

        // Step 1: Create video container
        $container = Http::post("https://graph.facebook.com/v19.0/{$user->instagram_account_id}/media", [
            'image_url' => $videoUrl,
            'caption' => $request->caption,
            'access_token' => $user->facebook_page_token,
        ])->json();

        if (!isset($container['id'])) {
            File::delete(public_path('instagram_uploads/' . $fileName));
            return back()->with('error', 'Failed to create container: ' . ($container['error']['message'] ?? 'Unknown error'));
        }

        $creationId = $container['id'];

        // Step 2: Wait for processing
        $status = '';
        $tries = 0;
        while ($status !== 'FINISHED' && $tries < 20) {
            sleep(5);
            $statusCheck = Http::get("https://graph.facebook.com/v19.0/{$creationId}", [
                'fields' => 'status_code',
                'access_token' => $user->facebook_page_token
            ])->json();

            $status = $statusCheck['status_code'] ?? null;

            if ($status === 'FAILED') {
                File::delete(public_path('instagram_uploads/' . $fileName));
                return back()->with('error', 'Instagram video processing failed.');
            }

            $tries++;
        }

        if ($status !== 'FINISHED') {
            File::delete(public_path('instagram_uploads/' . $fileName));
            return back()->with('error', 'Instagram video processing timed out.');
        }

        // Step 3: Publish video
        $publish = Http::post("https://graph.facebook.com/v19.0/{$user->instagram_account_id}/media_publish", [
            'creation_id' => $creationId,
            'access_token' => $user->facebook_page_token,
        ])->json();

        File::delete(public_path('instagram_uploads/' . $fileName));

        if (isset($publish['id'])) {
            return back()->with('success', 'Video uploaded to Instagram!');
        }

        return back()->with('error', 'Failed to publish video: ' . ($publish['error']['message'] ?? 'Unknown error'));

    } catch (\Exception $e) {
        return back()->with('error', 'Exception: ' . $e->getMessage());
    }
}

   public function uploadTextToInstagram(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'caption' => 'required|string|max:2200', // Matches Blade: name="caption" for text content
            'text_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192', // Matches Blade: name="text_photo" for optional photo
            'schedule_time' => 'nullable|date_format:Y-m-d H:i:s|after:now', // Matches Blade: name="schedule_time"
            'schedule' => 'nullable|boolean', // Matches Blade: name="schedule"
        ]);

        $user = auth()->user();

        if (!$user->instagram_account_id || !$user->facebook_page_token) {
            return back()->with('error', 'Please connect your Instagram Business Account first to post text.');
        }

        $publicMediaPath = null; // Initialize for cleanup
        $isPlaceholder = false; // Flag to know if we created a placeholder

        try {
            $caption = $request->input('caption'); // Get text content by 'caption' name from Blade
            $destinationPath = public_path('instagram_uploads');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            if ($request->hasFile('text_photo')) { // Check for 'text_photo' file
                // User provided a photo
                $photoFile = $request->file('text_photo'); // Get file by 'text_photo' name
                $fileName = uniqid('ig_text_photo_') . '_' . $photoFile->getClientOriginalName();
                $photoFile->move($destinationPath, $fileName);
                $publicMediaPath = 'instagram_uploads/' . $fileName;
            } else {
                // No photo provided, generate a blank placeholder image
                $fileName = uniqid('ig_placeholder_') . '.png';
                $publicMediaPath = 'instagram_uploads/' . $fileName;
                $fullPath = public_path($publicMediaPath);

                // Create a simple blank white image (e.g., 1080x1080 for Instagram square)
                // Requires Intervention Image: composer require intervention/image
                Image::canvas(1080, 1080, '#FFFFFF')->save($fullPath);
                $isPlaceholder = true; // Mark as placeholder
                Log::info('Instagram Text Upload: Generated placeholder image: ' . $fullPath);
            }

            $publicMediaUrl = asset($publicMediaPath);
            Log::info('Instagram Text Upload: Generated public URL: ' . $publicMediaUrl);


            // 2. Check if the post needs to be scheduled
            if ($request->boolean('schedule') && $request->has('schedule_time')) {
                ScheduledPost::create([
                    'user_id' => $user->id,
                    'type' => 'photo', // Even if placeholder, it's treated as a photo for scheduling
                    'media_path' => $publicMediaPath,
                    'caption' => $caption,
                    'scheduled_at' => Carbon::parse($request->schedule_time),
                    'status' => 'pending',
                ]);

                return back()->with('success', 'Text post scheduled successfully for Instagram! It will be posted with an image at the specified time.');

            } else {
                // 3. If not scheduled, post to Instagram immediately
                $instagramAccountId = $user->instagram_account_id;
                $pageAccessToken = $user->facebook_page_token;

                // Step 1: Create Media Container (always an image for text posts)
                $createMediaResponse = Http::withToken($pageAccessToken)
                    ->post("https://graph.facebook.com/v19.0/{$instagramAccountId}/media", [
                        'image_url' => $publicMediaUrl,
                        'caption' => $caption,
                    ]);

                $createMediaData = $createMediaResponse->json();

                if ($createMediaResponse->failed() || !isset($createMediaData['id'])) {
                    $errorMessage = $createMediaData['error']['message'] ?? 'Unknown error';
                    Log::error('Instagram Create Text Media Container Failed: ' . $errorMessage, [
                        'response' => $createMediaData,
                        'public_url' => $publicMediaUrl,
                        'user_id' => $user->id
                    ]);
                    throw new \Exception('Failed to create Instagram media container for text post: ' . $errorMessage);
                }

                $creationId = $createMediaData['id'];

                sleep(5); // Wait for 5 seconds for processing

                // Step 2: Publish the Media Container
                $publishMediaResponse = Http::withToken($pageAccessToken)
                    ->post("https://graph.facebook.com/v19.0/{$instagramAccountId}/media_publish", [
                        'creation_id' => $creationId,
                    ]);

                $publishMediaData = $publishMediaResponse->json();

                if ($publishMediaResponse->failed() || !isset($publishMediaData['id'])) {
                    $errorMessage = $publishMediaData['error']['message'] ?? 'Unknown error';
                    Log::error('Instagram Publish Text Media Failed: ' . $errorMessage, [
                        'response' => $publishMediaData,
                        'creation_id' => $creationId,
                        'user_id' => $user->id
                    ]);
                    throw new \Exception('Failed to publish Instagram text post: ' . $errorMessage);
                }

                File::delete(public_path($publicMediaPath));

                return back()->with('success', 'Text post uploaded to Instagram successfully!');
            }
        } catch (\Exception $e) {
            Log::error('Instagram Text Upload Error: ' . $e->getMessage(), ['exception' => $e, 'user_id' => $user->id ?? 'unknown']);
            if ($publicMediaPath && File::exists(public_path($publicMediaPath))) {
                File::delete(public_path($publicMediaPath));
            }
            return back()->with('error', 'Failed to upload text post to Instagram: ' . $e->getMessage());
        }
    }

    public function handleYouTubeCallback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));

        $client->addScope([
            Google_Service_YouTube::YOUTUBE_UPLOAD,
            Google_Service_YouTube::YOUTUBE,
        ]);

        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');

        $code = $request->input('code');

        if (!$code) {
            return redirect()->route('influencer.connect.social.media')->with('error', 'Authorization failed.');
        }

        $token = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            return redirect()->route('influencer.connect.social.media')->with('error', 'Failed to get access token: ' . $token['error']);
        }

        DB::table('users')->where('id', auth()->id())->update([
            'youtube_token' => json_encode($token),
        ]);

        return redirect()->route('influencer.connect.social.media')->with('success', 'YouTube connected successfully!');
    }



    public function uploadYoutubeVideo(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:mp4,mov,avi,flv|max:51200',
            'caption' => 'nullable|string|max:255',
        ]);

        try {
            $user = auth()->user();

            if (!$user->youtube_token) {
                return redirect()->route('influencer.connect.social.media')
                    ->with('error', 'YouTube account not connected. Please connect first.');
            }

            // ✅ Read token from DB
            $token = json_decode($user->youtube_token, true);

            $client = new Google_Client();
            $client->setClientId(config('services.google.client_id'));
            $client->setClientSecret(config('services.google.client_secret'));
            $client->setRedirectUri(config('services.google.redirect'));
            $client->setAccessToken($token);

            // ✅ Refresh token if needed
            if ($client->isAccessTokenExpired()) {
                if ($client->getRefreshToken()) {
                    $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    $updatedToken = array_merge($token, $newToken);
                    $user->youtube_token = json_encode($updatedToken);
                    $user->save();
                    $client->setAccessToken($updatedToken);
                } else {
                    return redirect()->route('influencer.connect.social.media')
                        ->with('error', 'YouTube session expired. Please reconnect.');
                }
            }

            // ✅ Ready to upload
            $youtube = new Google_Service_YouTube($client);

            // Snippet
            $snippet = new Google_Service_YouTube_VideoSnippet();
            $snippet->setTitle($request->caption ?: 'Untitled Video');
            $snippet->setDescription($request->caption ?: '');
            $snippet->setCategoryId("22");

            // Status
            $status = new Google_Service_YouTube_VideoStatus();
            $status->privacyStatus = 'public';

            // Video
            $video = new Google_Service_YouTube_Video();
            $video->setSnippet($snippet);
            $video->setStatus($status);

            // Upload
            $client->setDefer(true);
            $insertRequest = $youtube->videos->insert('status,snippet', $video);

            $videoPath = $request->file('media')->getPathname();

            $media = new Google_Http_MediaFileUpload(
                $client,
                $insertRequest,
                'video/*',
                null,
                true,
                1 * 1024 * 1024 // 1MB chunks
            );
            $media->setFileSize(filesize($videoPath));

            $status = false;
            $handle = fopen($videoPath, "rb");
            while (!$status && !feof($handle)) {
                $chunk = fread($handle, 1024 * 1024);
                $status = $media->nextChunk($chunk);
            }
            fclose($handle);
            $client->setDefer(false);

            // Success
            $videoId = $status['id'];
            $videoUrl = 'https://www.youtube.com/watch?v=' . $videoId;

            return redirect()->route('influencer.connect.social.media')
                ->with('success', 'Video uploaded successfully! <a href="' . $videoUrl . '" target="_blank">Watch it on YouTube</a>');
        } catch (\Exception $e) {
            return redirect()->route('influencer.connect.social.media')
                ->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function redirectToTwitter()
    {
        $twitter = new TwitterOAuth(
            config('services.twitter.client_id'),
            config('services.twitter.client_secret')
        );

        $request_token = $twitter->oauth('oauth/request_token', [
            'oauth_callback' => route('auth.twitter.callback'),
        ]);

        session([
            'twitter_oauth_token' => $request_token['oauth_token'],
            'twitter_oauth_token_secret' => $request_token['oauth_token_secret'],
        ]);

        $authUrl = $twitter->url('oauth/authorize', [
            'oauth_token' => $request_token['oauth_token'],
        ]);

        return redirect()->away($authUrl);
    }

    public function handleTwitterCallback(Request $request)
    {

        $requestToken = session('twitter_oauth_token');
        $requestTokenSecret = session('twitter_oauth_token_secret');

        if (!$request->has('oauth_verifier') || !$request->has('oauth_token')) {
            return redirect()->route('influencer.connect.social.media')->with('error', 'Twitter authorization failed.');
        }

        $twitter = new TwitterOAuth(
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
            $requestToken,
            $requestTokenSecret
        );

        $access_token = $twitter->oauth('oauth/access_token', [
            'oauth_verifier' => $request->input('oauth_verifier'),
        ]);

        $user = auth()->user();
        $user->twitter_oauth_token = $access_token['oauth_token'];
        $user->twitter_oauth_token_secret = $access_token['oauth_token_secret'];
        $user->save();

        return redirect()->route('influencer.connect.social.media')->with('success', 'Twitter connected successfully!');
    }
 

    public function redirectToTikTok()
    {
        $clientKey = config('services.tiktok.client_key');
        $redirectUri = config('services.tiktok.redirect_uri');

        $scopes = 'user.info.basic,video.upload,video.publish';

        $state = bin2hex(random_bytes(16));

        $authUrl = "https://www.tiktok.com/v2/auth/authorize/?" .
            "client_key={$clientKey}" .
            "&redirect_uri=" . urlencode($redirectUri) .
            "&scope=" . urlencode($scopes) .
            "&response_type=code" .
            "&state={$state}" .
            "&force_verify=true";

        return redirect()->away($authUrl);
    }
    public function handleTikTokCallback(Request $request)
    {
        $user = Auth::user();

        if ($request->has('error')) {
            return redirect()->route('influencer.connect.social.media')->with('error', 'TikTok connection failed: ' . $request->input('error_description', $request->input('error')));
        }

        $code = $request->input('code');
        $state = $request->input('state');

        $tokenResponse = Http::asForm()->post("https://open.tiktokapis.com/v2/oauth/token/", [
            'client_key' => config('services.tiktok.client_key'),
            'client_secret' => config('services.tiktok.client_secret'),
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => config('services.tiktok.redirect_uri'),
        ]);

        $tokenData = $tokenResponse->json();

        if ($tokenResponse->failed() || !isset($tokenData['access_token'])) {
            return redirect()->route('influencer.connect.social.media')->with('error', 'Failed to get TikTok access token: ' . json_encode($tokenData));
        }

        $accessToken = $tokenData['access_token'];
        $refreshToken = $tokenData['refresh_token'];
        $expiresIn = $tokenData['expires_in'];
        $openId = $tokenData['open_id'];

        $userInfoResponse = Http::withToken($accessToken)
            ->get("https://open.tiktokapis.com/v2/user/info/?fields=avatar_url,display_name"); // Adjust fields based on TikTok docs

        $userInfo = $userInfoResponse->json();
        $userProfileData = null;
        if ($userInfoResponse->successful() && isset($userInfo['data']['user'])) {
            $userProfileData = $userInfo['data']['user'];
        }

        $user->tiktok_open_id = $openId;
        $user->tiktok_access_token = $accessToken;
        $user->tiktok_refresh_token = $refreshToken;
        $user->tiktok_token_expires_at = Carbon::now()->addSeconds($expiresIn);
        $user->tiktok_user_info = $userProfileData;
        $user->save();

        return redirect()->route('influencer.connect.social.media')->with('success', 'TikTok account connected successfully!');
    }

public function uploadPhotoToTikTok(Request $request)
{
    // 1. Validate input (only videos)
    $request->validate([
        'media'   => 'required|file|mimes:mp4,mov,avi|max:51200', // Max 50 MB
        'caption' => 'nullable|string|max:2200',
    ]);

    $user = auth()->user();
    if (!$user) {
        return back()->with('error', 'Authentication required.');
    }

    // 2. Refresh or fetch TikTok token
    try {
        $accessToken = $this->refreshTikTokToken($user);
        if (!$accessToken) {
            return back()->with('error', 'TikTok access token is missing or invalid.');
        }
    } catch (\Exception $e) {
        Log::error('TikTok Token Refresh Failed', ['exception' => $e->getMessage()]);
        return back()->with('error', 'Token refresh failed: ' . $e->getMessage());
    }

    $openId = $user->tiktok_open_id;
    if (empty($openId)) {
        return back()->with('error', 'TikTok Open ID not found. Please re-authenticate with TikTok.');
    }

    // 3. Prepare video data
    $videoFile  = $request->file('media');
    $videoPath  = $videoFile->getRealPath();
    $videoSize  = filesize($videoPath);
    $mimeType   = $videoFile->getMimeType();

    // TikTok requires chunk_size <= 5MB and multiple of 256KB
    $chunkUnit = 256 * 1024; // 256 KB
    $chunkSize = 2 * 1024 * 1024; // 2 MB
    $chunkSize = floor($chunkSize / $chunkUnit) * $chunkUnit;
    $totalChunks = (int) ceil($videoSize / $chunkSize);

    // 4. INIT upload
    $initPayload = [
        'source_info' => [
            'source'            => 'FILE_UPLOAD',
            'video_size'        => $videoSize,
            'chunk_size'        => $chunkSize,
            'total_chunk_count' => $totalChunks,
        ],
    ];

    $initUrl = 'https://open.tiktokapis.com/v2/post/publish/inbox/video/init/';

    try {
        $initResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'  => 'application/json',
        ])->post($initUrl, $initPayload);

        $initData = $initResponse->json();
        Log::info('TikTok INIT Video Response', ['response' => $initData]);

        if (!$initResponse->successful() || empty($initData['data']['upload_url']) || empty($initData['data']['publish_id'])) {
            $error = $initData['error']['message'] ?? $initData['message'] ?? 'Unknown INIT error.';
            return back()->with('error', 'Init failed: ' . $error);
        }

        $uploadUrl = $initData['data']['upload_url'];
        $publishId = $initData['data']['publish_id'];
    } catch (\Exception $e) {
        Log::error('TikTok INIT Exception', ['message' => $e->getMessage()]);
        return back()->with('error', 'TikTok INIT failed: ' . $e->getMessage());
    }

    // 5. Upload chunks
    try {
        $fp = fopen($videoPath, 'rb');
        if (!$fp) {
            return back()->with('error', 'Failed to open video file.');
        }

        $offset = 0;
        $chunkIndex = 0;

        while (!feof($fp)) {
            $chunkData = fread($fp, $chunkSize);
            $chunkLength = strlen($chunkData);
            $start = $offset;
            $end   = $offset + $chunkLength - 1;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uploadUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: {$mimeType}",
                "Content-Length: {$chunkLength}",
                "Content-Range: bytes {$start}-{$end}/{$videoSize}",
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $chunkData);

            $uploadResult = curl_exec($ch);
            $uploadStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError    = curl_error($ch);
            curl_close($ch);

            Log::info('TikTok CHUNK Upload', [
                'chunk'   => $chunkIndex,
                'status'  => $uploadStatus,
                'response'=> $uploadResult,
                'error'   => $curlError,
            ]);

            if ($uploadStatus < 200 || $uploadStatus >= 300) {
                fclose($fp);
                return back()->with('error', "Video upload failed. Status: {$uploadStatus}. Error: {$curlError}");
            }

            $offset += $chunkLength;
            $chunkIndex++;
        }

        fclose($fp);
    } catch (\Exception $e) {
        Log::error('TikTok CHUNK Upload Exception', ['message' => $e->getMessage()]);
        return back()->with('error', 'Video upload failed: ' . $e->getMessage());
    }

    // 6. Complete the publish
    $completePayload = [
        'open_id'    => $openId,
        'publish_id' => $publishId,
        'text'       => $request->input('caption', ''),
    ];

    try {
        $completeResponse = Http::withToken($accessToken)
            ->post('https://open.tiktokapis.com/v2/post/publish/complete/', $completePayload);

        $completeData = $completeResponse->json();
        Log::info('TikTok COMPLETE Response', ['response' => $completeData]);

        if ($completeResponse->successful()) {
            return back()->with('success', 'Video successfully published to TikTok!');
        } else {
            $error = $completeData['error']['message'] ?? $completeData['message'] ?? 'Unknown error from TikTok API.';
            return back()->with('error', 'Publish failed: ' . $error);
        }
    } catch (\Exception $e) {
        Log::error('TikTok COMPLETE Exception', ['message' => $e->getMessage()]);
        return back()->with('error', 'Failed to complete TikTok publish: ' . $e->getMessage());
    }
}




 
   protected function refreshTikTokToken($user)
    {
        // This is a placeholder. You need to implement your actual token refresh logic here.
        // It should check if the token is expired, use the refresh_token to get a new one,
        // update the user's stored access_token and expires_in, and then return the new access_token.
        // If the refresh token is also expired or invalid, it should return null.

        // Example (conceptual):
        // if ($user->tiktok_access_token_expires_at <= now()->addMinutes(5)) { // Token expiring soon
        //     try {
        //         $response = Http::post('https://open.tiktokapis.com/oauth/refresh_token/', [
        //             'client_key' => config('services.tiktok.client_key'),
        //             'client_secret' => config('services.tiktok.client_secret'),
        //             'grant_type' => 'refresh_token',
        //             'refresh_token' => $user->tiktok_refresh_token,
        //         ]);
        //
        //         $data = $response->json();
        //
        //         if ($response->successful() && isset($data['access_token'])) {
        //             $user->tiktok_access_token = $data['access_token'];
        //             $user->tiktok_refresh_token = $data['refresh_token']; // Update refresh token if it changes
        //             $user->tiktok_access_token_expires_at = now()->addSeconds($data['expires_in']);
        //             $user->save();
        //             return $data['access_token'];
        //         } else {
        //             Log::error('TikTok Refresh Token API failed', ['response' => $data, 'user_id' => $user->id]);
        //             return null;
        //         }
        //     } catch (\Exception $e) {
        //         Log::error('Exception during TikTok Refresh Token', ['exception' => $e->getMessage(), 'user_id' => $user->id]);
        //         return null;
        //     }
        // }

        // If token is not expired, just return the current one
        return $user->tiktok_access_token;
    }

    public function InstagramVideoUpload(Request $request)
    {
        $user = Auth::user();

        if (!$user->instagram_account_id || !$user->facebook_page_token) {
            return back()->with('error', 'Instagram not connected.');
        }

        $request->validate([
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:51200', // 50MB
            'caption' => 'nullable|string|max:2200', // Instagram caption limit
        ]);

        try {
            // Save video
            $videoFile = $request->file('video');
            $filename = uniqid() . '.' . $videoFile->getClientOriginalExtension();
            $uploadPath = public_path('instagram_uploads');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $videoFile->move($uploadPath, $filename);

            $videoUrl = url('instagram_uploads/' . $filename); // Must be HTTPS and PUBLIC

            if (parse_url($videoUrl, PHP_URL_SCHEME) !== 'https' && config('app.env') === 'production') {
                return back()->with('error', 'Video URL must be HTTPS for Instagram upload in production.');
            }

            $mediaResponse = Http::post("https://graph.facebook.com/v19.0/{$user->instagram_account_id}/media", [
                'video_url'    => $videoUrl,
                'caption'      => $request->input('caption'),
                'media_type'   => 'REELS',
                'access_token' => $user->facebook_page_token,
            ]);

            $media = $mediaResponse->json();

            if (!isset($media['id'])) {
                return back()->with('error', 'Video container failed: ' . json_encode($media));
            }

            $maxAttempts = 10;
            $attempt = 0;
            $isReady = false;
            $containerId = $media['id'];

            while ($attempt < $maxAttempts && !$isReady) {
                sleep(5);
                $statusResponse = Http::get("https://graph.facebook.com/v19.0/{$containerId}", [
                    'fields'       => 'status_code',
                    'access_token' => $user->facebook_page_token,
                ]);

                $statusData = $statusResponse->json();

                if (isset($statusData['status_code']) && $statusData['status_code'] === 'FINISHED') {
                    $isReady = true;
                } elseif (isset($statusData['status_code']) && $statusData['status_code'] === 'ERROR') {
                    return back()->with('error', 'Video processing failed: ' . json_encode($statusData));
                }
                $attempt++;
            }

            if (!$isReady) {
                return back()->with('error', 'Video processing timed out. Please try again later.');
            }

            $publishResponse = Http::post("https://graph.facebook.com/v19.0/{$user->instagram_account_id}/media_publish", [
                'creation_id'  => $media['id'],
                'access_token' => $user->facebook_page_token,
            ]);

            if ($publishResponse->successful()) {
                @unlink($uploadPath . '/' . $filename);
                return back()->with('success', 'Video uploaded to Instagram!');
            } else {
                return back()->with('error', 'Publishing failed: ' . $publishResponse->body());
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Upload error: ' . $e->getMessage());
        }
    }

    public function handleGoogleCallback()
    {
        try {
            $currentUser = Auth::user();
            $user = Socialite::driver('google')->stateless()->user();

            // Retrieve token details
            $token = $user->token;
            $refreshToken = $user->refreshToken;
            $expiresIn = $user->expiresIn;

            // Save these tokens and user info to the database
            $authUser = GoogleUser::where('user_id', $currentUser->id)->first();
            if ($authUser) {
                $authUser->google_id = $user->id;
                $authUser->google_token = $token;
                $authUser->google_refresh_token = $refreshToken;
                $authUser->google_token_expires_in = now()->addSeconds($expiresIn);
                $authUser->save();
            } else {
                $newAuthUser = new GoogleUser();
                $newAuthUser->user_id = $currentUser->id;
                $newAuthUser->google_id = $user->id;
                $newAuthUser->google_token = $token;
                $newAuthUser->google_refresh_token = $refreshToken;
                $newAuthUser->google_token_expires_in = now()->addSeconds($expiresIn);
                $newAuthUser->save();
            }


            if ($currentUser->role_id == '3' && $currentUser->user_role == 'influencer') {
                return redirect()->route('influencer.connect.social.media')->with('success', 'Connected to Youtube successfully.');
            } else {
                return redirect()->route('influencer.connect.social.media')->with('success', 'Connected to Youtube successfully.');
            }
        } catch (Exception $e) {
            if ($currentUser->role_id == '3' && $currentUser->user_role == 'influencer') {
                return redirect()->route('influencer.connect.social.media')->with('error', 'Failed to connect to Google. Please try again.');
            } else {
                return redirect()->route('business.connect.social.media')->with('error', 'Failed to connect to Google. Please try again.');
            }
        }
    }



    public function uploadImage(Request $request)
    {
        $request->validate([
            'media' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'caption' => 'nullable|string',
            'schedule_time' => 'nullable|date|after_or_equal:now',
        ]);

        try {
            // Store image
            $path = $request->file('media')->store('public/uploads');

            // You can save post details into DB here if needed

            return back()->with('success', 'Image uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Image upload failed: ' . $e->getMessage());
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->scopes([
                'pages_manage_posts',
                'pages_show_list',
                'public_profile',
                'email',
                'instagram_basic',
                'instagram_content_publish',
                'pages_read_engagement',
                'pages_read_user_content'
            ])
            ->with(['auth_type' => 'rerequest'])
            ->redirectUrl('https://new.swayit.com/auth/facebook/callback')
            ->stateless()
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $fbUser = Socialite::driver('facebook')
                ->redirectUrl('https://new.swayit.com/auth/facebook/callback')
                ->stateless()
                ->user();
            $accessToken = $fbUser->token;

            $response = Http::get("https://graph.facebook.com/v17.0/me/accounts", [
                'access_token' => $accessToken,
            ]);

            

            $pages = $response->json()['data'] ?? [];

            if (empty($pages)) {
                return redirect()->route('influencer.connect.social.media')->with('error', 'No Facebook Pages found or missing permissions.');
            }

            $page = $pages[0];
            $pageId = $page['id'] ?? null;
            $pageToken = $page['access_token'] ?? null;

            if (!$pageId || !$pageToken) {
                return redirect()->route('influencer.connect.social.media')->with('error', 'Failed to retrieve Facebook Page ID or access token.');
            }

            DB::table('users')->where('id', auth()->id())->update([
                'facebook_token' => $accessToken,
                'facebook_page_id' => $pageId,
                'facebook_page_token' => $pageToken,
                'updated_at' => now(),
            ]);


            return redirect()->route('influencer.connect.social.media')->with('success', 'Facebook Page connected successfully!');
        } catch (\Exception $e) {
            \Log::error('Facebook callback error: ' . $e->getMessage());
            return redirect()->route('influencer.connect.social.media')->with('error', 'An error occurred during Facebook authentication.');
        }
    }


    public function facebookUpload(Request $request)
    {
        $user = Auth::user();

        if (!$user->facebook_page_id || !$user->facebook_page_token) {
            return back()->with('error', 'Please connect your Facebook Page first.');
        }

        try {
            // Check if scheduling is enabled and valid
            $isScheduled = $request->has('schedule') && $request->filled('scheduled_at');
            $scheduledTimestamp = null;

            if ($isScheduled) {
                // Convert to UTC
                $scheduledTime = Carbon::parse($request->input('scheduled_at'), config('app.timezone'))->timezone('UTC');

                // Facebook requires it to be at least 10 minutes in the future
                if ($scheduledTime->lt(Carbon::now('UTC')->addMinutes(10))) {
                    return back()->with('error', 'Scheduled time must be at least 10 minutes from now.');
                }

                $scheduledTimestamp = $scheduledTime->timestamp;
            }

            // 1️⃣ Text post
            if ($request->filled('caption_text')) {
                $postData = [
                    'message' => $request->caption_text,
                    'access_token' => $user->facebook_page_token,
                ];

                if ($isScheduled) {
                    $postData['scheduled_publish_time'] = $scheduledTimestamp;
                    $postData['published'] = false;
                }

                $response = Http::post("https://graph.facebook.com/{$user->facebook_page_id}/feed", $postData);

                if ($response->successful()) {
                    return back()->with('success', $isScheduled ? 'Text post scheduled on Facebook.' : 'Text post published to Facebook.');
                } else {
                    return back()->with('error', 'Facebook API error (Text): ' . $response->body());
                }
            }

            // 2️⃣ Photo post
            if ($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('temp');
                $imageAbsolutePath = storage_path("app/{$imagePath}");

                $postData = [
                    'caption' => $request->caption_photo ?? '',
                    'access_token' => $user->facebook_page_token,
                ];

                if ($isScheduled) {
                    $postData['scheduled_publish_time'] = $scheduledTimestamp;
                    $postData['published'] = false;
                }

                $uploadResponse = Http::attach(
                    'source',
                    file_get_contents($imageAbsolutePath),
                    $request->file('photo')->getClientOriginalName()
                )->post("https://graph.facebook.com/{$user->facebook_page_id}/photos", $postData);

                Storage::delete($imagePath);

                if ($uploadResponse->successful()) {
                    return back()->with('success', $isScheduled ? 'Photo post scheduled on Facebook.' : 'Photo posted to Facebook.');
                } else {
                    return back()->with('error', 'Facebook API error (Photo): ' . $uploadResponse->body());
                }
            }

            // 3️⃣ Video post
            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('temp');
                $videoAbsolutePath = storage_path("app/{$videoPath}");

                $postData = [
                    'description' => $request->caption_video ?? '',
                    'access_token' => $user->facebook_page_token,
                ];

                if ($isScheduled) {
                    $postData['scheduled_publish_time'] = $scheduledTimestamp;
                    $postData['published'] = false;
                }

                $uploadResponse = Http::attach(
                    'source',
                    file_get_contents($videoAbsolutePath),
                    $request->file('video')->getClientOriginalName()
                )->post("https://graph.facebook.com/{$user->facebook_page_id}/videos", $postData);

                Storage::delete($videoPath);

                if ($uploadResponse->successful()) {
                    return back()->with('success', $isScheduled ? 'Video post scheduled on Facebook.' : 'Video posted to Facebook.');
                } else {
                    return back()->with('error', 'Facebook API error (Video): ' . $uploadResponse->body());
                }
            }

            return back()->with('error', 'No content submitted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to post to Facebook: ' . $e->getMessage());
        }
    }





    public function uploadFacebook(Request $request)
    {
        return view('influencer.socialmedia.upload_facebook');
    }


    public function disconnectFacebook()
    {
        DB::table('users')->where('id', auth()->id())->update([
            'facebook_page_id' => null,
            'facebook_page_token' => null,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Facebook page disconnected successfully.');
    }

    public function disconnectInstagram()
    {
        DB::table('users')->where('id', auth()->id())->update([
            'instagram_account_id' => null,
            'facebook_page_token' => null,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Instagram page disconnected successfully.');
    }



    public function disconnectYoutube(Request $request)
    {
        DB::table('users')->where('id', auth()->id())->update([
            'youtube_token' => null,
            'updated_at' => now(),
        ]);


        return redirect()->back()->with('success', 'YouTube account disconnected successfully.');
    }

    public function disconnectTwitter(Request $request)
    {
        DB::table('users')->where('id', auth()->id())->update([
            'twitter_oauth_token' => null,
            'updated_at' => now(),
        ]);


        return redirect()->back()->with('success', 'Twitter account disconnected successfully.');
    }

    public function disconnectTiktok(Request $request)
    {
        DB::table('users')->where('id', auth()->id())->update([
            'tiktok_access_token' => null,
            'updated_at' => now(),
        ]);


        return redirect()->back()->with('success', 'Tiktok account disconnected successfully.');
    }


    public function redirectToInstagram()
    {
        return Socialite::driver('facebook')
            ->scopes([
                'email',
                'pages_show_list',
                'instagram_basic'
            ])
            ->redirectUrl('https://new.swayit.com/auth/instagram/callback')
            ->stateless()
            ->redirect();
    }

    public function handleInstagramCallback()
    {
        try {
            $fbUser = Socialite::driver('facebook')
                ->redirectUrl('https://new.swayit.com/auth/instagram/callback')
                ->stateless()
                ->user();

            $userAccessToken = $fbUser->token;
    
            auth()->user()->update([
                'facebook_token' => $userAccessToken,
            ]);

            // 3️⃣ Get list of Facebook Pages the user manages
            $response = Http::get("https://graph.facebook.com/v23.0/me/accounts", [
                'fields' => 'id,name,access_token',
                'access_token' => $userAccessToken,
            ]);

            $pages = $response->json()['data'] ?? [];

            if (empty($pages)) {
                return redirect()->route('influencer.connect.social.media')
                    ->with('error', 'No Facebook Pages found.');
            }

            $connectedPage = null;
            $instagramAccountId = null;

            foreach ($pages as $page) {
                $pageId = $page['id'];
                $pageAccessToken = $page['access_token'];

                $igResponse = Http::get("https://graph.facebook.com/v23.0/{$pageId}", [
                    'fields' => 'instagram_business_account',
                    'access_token' => $pageAccessToken,
                ]);

                $igData = $igResponse->json();

                if (isset($igData['instagram_business_account']['id'])) {
                    $connectedPage = $page;
                    $instagramAccountId = $igData['instagram_business_account']['id'];
                    break; // ✅ Stop after finding the first page with an IG account
                }
            }

            if (!$connectedPage || !$instagramAccountId) {
                return redirect()->route('influencer.connect.social.media')
                    ->with('error', 'No Instagram-connected Facebook Page was found.');
            }

            // 5️⃣ Save to DB
            auth()->user()->update([
                'facebook_page_id'      => $connectedPage['id'],
                'facebook_page_token'   => $connectedPage['access_token'],
                'instagram_account_id'  => $instagramAccountId,
            ]);

            return redirect()->route('influencer.connect.social.media')
                ->with('success', 'Instagram account connected successfully!');
        } catch (\Throwable $e) {
            \Log::error('Instagram connection failed: ' . $e->getMessage());
            return redirect()->route('influencer.connect.social.media')
                ->with('error', 'Instagram connection failed: ' . $e->getMessage());
        }
    }
public function uploadPhotoToInstagram(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192', // Max 8MB for Instagram photos
            'caption' => 'nullable|string|max:2200', // Instagram caption limit is 2200 characters
            'schedule_time' => 'nullable|date_format:Y-m-d H:i:s|after:now', // Specific date format and time must be in the future
            'schedule' => 'nullable|boolean', // Indicates if the post should be scheduled
        ]);

        $user = auth()->user();

        // Ensure the user has connected their Instagram account and required tokens are available
        if (!$user->instagram_account_id || !$user->facebook_page_token) {
            return back()->with('error', 'Please connect your Instagram Business Account first to upload photos.');
        }

        $publicPhotoPath = null; // Initialize to null for cleanup in case of error

        try {
            // Store the photo directly into the public directory.
            // This bypasses the need for `php artisan storage:link`.
            $photoFile = $request->file('photo');
            $fileName = uniqid('ig_') . '_' . $photoFile->getClientOriginalName();
            $destinationPath = public_path('instagram_uploads');

            // Create the directory if it doesn't exist
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            // Move the uploaded file to the public directory
            $photoFile->move($destinationPath, $fileName);

            // Construct the relative path for storage and URL generation
            $publicPhotoPath = 'instagram_uploads/' . $fileName;

            // Get the public URL for the stored photo using Laravel's asset helper
            // This URL will be directly accessible by Instagram's servers.
            $publicPhotoUrl = asset($publicPhotoPath);

            // Log the public URL to help with debugging accessibility
            Log::info('Instagram Photo Upload: Generated public URL: ' . $publicPhotoUrl);

            // 2. Check if the post needs to be scheduled
            if ($request->boolean('schedule') && $request->has('schedule_time')) {
                // Create a scheduled post entry in your database
                ScheduledPost::create([
                    'user_id' => $user->id,
                    'type' => 'photo',
                    'media_path' => $publicPhotoPath, // Store the relative path within the public directory
                    'caption' => $request->caption,
                    'scheduled_at' => Carbon::parse($request->schedule_time),
                    'status' => 'pending', // Set initial status for scheduled posts
                ]);

                return back()->with('success', 'Photo scheduled successfully for Instagram! It will be posted at the specified time.');

            } else {
                // 3. If not scheduled, post to Instagram immediately
                $instagramAccountId = $user->instagram_account_id;
                $pageAccessToken = $user->facebook_page_token; // This is the Page Access Token
                $caption = $request->caption;

                // Step 1: Create Media Container on Instagram
                // This tells Instagram about the media you want to publish.
                $createMediaResponse = Http::withToken($pageAccessToken)
                    ->post("https://graph.facebook.com/v19.0/{$instagramAccountId}/media", [
                        'image_url' => $publicPhotoUrl, // URL to the publicly accessible photo
                        'caption' => $caption,
                    ]);

                $createMediaData = $createMediaResponse->json();

                // Check if the media container creation failed
                if ($createMediaResponse->failed() || !isset($createMediaData['id'])) {
                    $errorMessage = $createMediaData['error']['message'] ?? 'Unknown error';
                    Log::error('Instagram Create Media Container Failed: ' . $errorMessage, [
                        'response' => $createMediaData,
                        'public_url' => $publicPhotoUrl
                    ]);
                    throw new \Exception('Failed to create Instagram media container: ' . $errorMessage);
                }

                $creationId = $createMediaData['id']; // This is the ID of the media container

                // Instagram requires a short delay before publishing to allow the container to process.
                // In a production environment, consider using a queue job that polls for status or webhooks.
                sleep(5); // Wait for 5 seconds

                // Step 2: Publish the Media Container to Instagram
                // This makes the media visible on the Instagram profile.
                $publishMediaResponse = Http::withToken($pageAccessToken)
                    ->post("https://graph.facebook.com/v19.0/{$instagramAccountId}/media_publish", [
                        'creation_id' => $creationId, // The ID of the media container to publish
                    ]);

                $publishMediaData = $publishMediaResponse->json();

                // Check if the media publishing failed
                if ($publishMediaResponse->failed() || !isset($publishMediaData['id'])) {
                    $errorMessage = $publishMediaData['error']['message'] ?? 'Unknown error';
                    Log::error('Instagram Publish Media Failed: ' . $errorMessage, [
                        'response' => $publishMediaData,
                        'creation_id' => $creationId
                    ]);
                    throw new \Exception('Failed to publish Instagram media: ' . $errorMessage);
                }

                // Delete the temporary public photo after successful upload
                File::delete(public_path($publicPhotoPath));

                return back()->with('success', 'Photo uploaded to Instagram successfully!');
            }
        } catch (\Exception $e) {
            // Log any exceptions that occur during the process for debugging
            Log::error('Instagram Photo Upload Error: ' . $e->getMessage(), ['exception' => $e]);

            // Attempt to clean up the file even if an error occurred during API calls
            if ($publicPhotoPath && File::exists(public_path($publicPhotoPath))) {
                File::delete(public_path($publicPhotoPath));
            }

            return back()->with('error', 'Failed to upload photo to Instagram: ' . $e->getMessage());
        }
    }




public function socialPost()
{
    $this->fetchAndStoreFacebookPosts(); 

    $posts = FacebookPost::where('user_id', auth()->id())->latest()->get();

    return view('influencer.posts.index', compact('posts'));
}


public function facebookDetails(Request $request)
{
    $post = FacebookPost::where('id', $request->id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    try {
        $response = Http::get("https://graph.facebook.com/v19.0/{$post->facebook_post_id}", [
            'fields' => 'message,picture,likes.summary(true),comments.summary(true)',
            'access_token' => $post->access_token,
        ]);

        $data = $response->json();

        return response()->json([
            'caption' => $data['message'] ?? '',
            'image' => $data['picture'] ?? '',
            'likes' => $data['likes']['summary']['total_count'] ?? 0,
            'comments' => $data['comments']['summary']['total_count'] ?? 0,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'caption' => $post->caption ?? '',
            'image' => '',
            'likes' => 0,
            'comments' => 0,
            'error' => 'Facebook API failed',
        ]);
    }
}


public function fetchAndStoreFacebookPosts()
{
    $user = Auth::user();
    $pageId = $user->facebook_page_id;
    $pageAccessToken = $user->facebook_page_token;

    if (!$pageId || !$pageAccessToken) {
        return redirect()->back()->with('error', 'Facebook Page ID or Access Token missing.');
    }

    try {
        // Fetch posts with required fields
        $response = Http::get("https://graph.facebook.com/v19.0/{$pageId}/posts", [
            'fields' => 'id,message,created_time,full_picture,likes.summary(true),comments.summary(true)',
            'access_token' => $pageAccessToken,
        ]);

        $posts = $response->json()['data'] ?? [];

        foreach ($posts as $postData) {
            $postId = $postData['id'];
            $caption = $postData['message'] ?? '';

            
          $imageUrl = $postData['full_picture'] ?? null;

            // Handle likes & comments count safely
            $likesCount = $postData['likes']['summary']['total_count'] ?? 0;
            $commentsCount = $postData['comments']['summary']['total_count'] ?? 0;

            FacebookPost::updateOrCreate(
                ['facebook_post_id' => $postId, 'user_id' => $user->id],
                [
                    'caption' => $caption,
                    'image_url' => $imageUrl,
                    'likes' => $likesCount,
                    'comments' => $commentsCount,
                ]
            );
        }

        return redirect()->route('influencer.social.post')->with('success', 'Posts synced successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to fetch Facebook posts. Error: ' . $e->getMessage());
    }
}




public function uploadFacebookPost(Request $request)
    {
        return view('influencer.socialmedia.upload_facebook');
    }




    public function uploadInstagram(Request $request)
    {
        return view('influencer.socialmedia.upload_instagram');
    }

    public function uploadYoutube(Request $request)
    {
        return view('influencer.socialmedia.upload_youtube');
    }

    public function uploadTwitter(Request $request)
    {
        return view('influencer.socialmedia.upload_twitter');
    }

    public function uploadTiktok(Request $request)
    {
        return view('influencer.socialmedia.upload_tiktok');
    }

    public function uploadSnapchat(Request $request)
    {
        return view('influencer.socialmedia.upload_snapchat');
    }

    public function uploadBereal(Request $request)
    {
        return view('influencer.socialmedia.upload_bereal');
    }

    public function uploadTwitch(Request $request)
    {
        return view('influencer.socialmedia.upload_twitch');
    }
}
