<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\FacebookConnection;
use App\Models\GoogleUser;
use App\Models\SocialMedias;
use App\Models\InstgramConnection;
use GuzzleHttp\Client;
use Exception;

class BusinessSocialMediaController extends Controller
{
    protected $userAccessToken;

    public function __construct()
    {
        $this->userAccessToken = env('FACEBOOK_PAGE_ACCESS_TOKEN');
    }

    public function socialPost(Request $request)
    {
        $user = Auth::user();

        $fields = $request->input('fields', ['access_token', 'id', 'name', 'about', 'category', 'category_list']);
        $fieldsString = implode(',', $fields);

        $response = Http::get('https://graph.facebook.com/v20.0/me/accounts', [
            'fields' => $fieldsString,
            'access_token' => $this->userAccessToken,
        ]);

        // dd($this->userAccessToken);

        // if ($response->successful()) {
            $pageData = $response->json();
            return view('business.social_post', compact('pageData'));
        // } else {
        //     return view('business.social_post', compact('pageData'));
        //     // return view('facebook.page-data')->withErrors(['error' => 'Error fetching data from Facebook API']);
        // }
        // return view('business.social_post');
    }

    public function postFacebookPage(Request $request)
    {
        $message = $request->input('input_facebook');
        $pageId = '423972020789995';
        $link = 'https://example.com';
        $pageAccessToken = 'EAA3SMCA1iewBO63CZBaZCCLod9xMLm7FDZAvEzI1vZBnKcJpk954HGLvLcRZCvUWGLXpLQUjJ92WPXR9lH29sY3ehd5PX0NIjqeMOGC4RK5fCJx5ZB9d0AtLiGZBbookSZAVL5lLaObZAPUa2kEPX8BPdytjQfo4PC3Xbqn7KwgZC7U94ZCq5QK0cRtCzpZBBC0YXvZBJYVTTZByJn';

        // $data = [
        //     'message' => $message,
        //     'link' => $link,
        //     "published" => true,
        //     'access_token' => $pageAccessToken,
        // ];

        // $response = Http::post("https://graph.facebook.com/v20.0/{$pageId}/feed", $data);

        // Check if an image is provided

        $image = $request->file('image');
        
        if ($image) {
            $response = Http::attach(
                'source', file_get_contents($image), $image->getClientOriginalName()
            )->post("https://graph.facebook.com/v20.0/{$pageId}/photos", [
                'message' => $message,
                'link' => $link,
                'access_token' => $pageAccessToken,
            ]);
        } else {
            $response = Http::post("https://graph.facebook.com/v20.0/{$pageId}/feed", [
                'message' => $message,
                'link' => $link,
                'published' => true,
                'access_token' => $pageAccessToken,
            ]);
        }

        // if ($response->successful()) {
        //     return response()->json($response->json());
        // } else {
        //     \Log::error('Facebook API Error:', $response->json());
        //     return response()->json(['error' => 'Error posting to Facebook page', 'details' => $response->json()], $response->status());
        // }

        if ($response->successful()) {
            return redirect()->route('business.social.post')->with('success', 'Posted Successfully.');
        } else {
            return redirect()->route('business.social.post')->with('error', 'Can not post, some error occured.');
        }
    }



    public function connectSocialMedia() 
    {
        $currentUser = Auth::user();
        $googleUser = GoogleUser::where('user_id', $currentUser->id)->first();
        $socialMedia = SocialMedias::orderBy('id', 'desc')->first();
        $instagram_details = InstgramConnection::where('user_id', $currentUser->id)->first();

        return view('business.socialmedia.connect_social_media', compact('googleUser', 'currentUser', 'socialMedia', 'instagram_details'));
    }

    // public function getYouTubeChannelInfo()
    // {
    //     $authUser = Auth::user();
    //     $googleUserDetails = GoogleUser::where('user_id', $authUser->id)->first();
    //     $accessToken = $googleUserDetails->google_token;

    //     // If the token is expired, refresh it
    //     if (now()->greaterThan($googleUserDetails->google_token_expires_in)) {
    //         $accessToken = $this->refreshGoogleAccessToken($googleUserDetails->google_refresh_token);
    //     }

    //     // Get YouTube channel information
    //     $client = new Client();
    //     try {
    //         $response = $client->get('https://www.googleapis.com/youtube/v3/channels', [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $accessToken,
    //                 'Accept' => 'application/json',
    //             ],
    //             'query' => [
    //                 'part' => 'snippet,contentDetails,statistics',
    //                 'mine' => 'true', // To get the authenticated user's channel
    //             ],
    //         ]);

    //         $data = json_decode($response->getBody()->getContents(), true); // Decode response data

    //         if (isset($data['items']) && !empty($data['items'])) {
    //             return view('business.socialmedia.youtube')->with('channelData', $data);
    //         } else {
    //             return view('business.socialmedia.youtube')->with('error', 'No channel data found.');
    //         }
    //     } catch (Exception $e) {
    //         return view('business.socialmedia.youtube')->with('error', 'Failed to fetch YouTube channel info.');
    //     }
    // }

    public function getYouTubeChannelInfo(Request $request)
    {
        if($request->channel_id) {
        $channelId = $request->channel_id;
        } else {
        $channelId = 'UCtz9FLnr_blQ7JOeSnAJKQA';
        }
        $authUser = Auth::user();
        // $googleUserDetails = GoogleUser::where('user_id', $authUser->id)->first();
        $googleUserDetails = GoogleUser::orderBy('id', 'desc')->first();
        $accessToken = $googleUserDetails->google_token;

        // If the token is expired, refresh it
        if (now()->greaterThan($googleUserDetails->google_token_expires_in)) {
            $accessToken = $this->refreshGoogleAccessToken($googleUserDetails->google_refresh_token);
        }

        // Get YouTube channel information by channel ID
        $client = new Client();
        try {
            $response = $client->get('https://www.googleapis.com/youtube/v3/channels', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'part' => 'snippet,contentDetails,statistics',
                    'id' => $channelId, // Specify the channel ID here
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true); // Decode response data

            if (isset($data['items']) && !empty($data['items'])) {
                return view('business.socialmedia.youtube')->with('channelData', $data);
            } else {
                return view('business.socialmedia.youtube')->with('error', 'No channel data found.');
            }
        } catch (Exception $e) {
            return view('business.socialmedia.youtube')->with('error', 'Failed to fetch YouTube channel info.');
        }
    }

    public function refreshGoogleAccessToken()
    {
        $currentUser = Auth::user();
        // $authUser = GoogleUser::where('user_id', $currentUser->id)->first();
        $authUser = GoogleUser::orderBy('id', 'desc')->first();

        if (!$authUser) {
            return false;
        }

        if (now()->greaterThan($authUser->google_token_expires_in)) {
            try {
                $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                    'client_id' => config('services.google.client_id'),
                    'client_secret' => config('services.google.client_secret'),
                    'refresh_token' => $authUser->google_refresh_token,
                    'grant_type' => 'refresh_token',
                ]);

                if ($response->successful()) {
                    // dd('true');
                    $newAccessTokenData = $response->json();

                    $authUser->google_token = $newAccessTokenData['access_token'];
                    $authUser->google_token_expires_in = now()->addSeconds($newAccessTokenData['expires_in']);
                    $authUser->save();

                    // return $authUser->google_token;
                    return redirect()->route('business.connect.social.media')->with('success', 'Reconnected with youtube.');
                } else {
                    // dd('false');
                    return false;
                }
            } catch (Exception $e) {
                return redirect()->route('business.connect.social.media')->with('error', 'Something went wrong.');
            }
        }
    }

    public function connectInstagram(Request $request)
    {
        $currentUser = Auth::user();
        $addAccount = new InstgramConnection();
        $addAccount->user_id = $currentUser->id;
        $addAccount->instagram_id = $request->input('username');
        $addAccount->save();

        // $accessToken = "IGAAgmIsNZCXP9BZAE8wN05ZAMmMwVmUxdlRnMEhHSDRHeFhyM3JnUU5FX1BXaEJWb3dQMGtMNGJMZAElxWU1oVDVnckp3X28xNHpuTXdHaHNfQnBOYlFtNzJ0dzAtTTZAEX0k4a1RmOXU1d2xBbDZAKM01uSnc1WV9QVVRHOXk3M09nWQZDZD";

        // $userId = $request->input('username');
        // $url = "https://graph.instagram.com/$userId?fields=id,username,profile_picture_url,biography,followers_count,follows_count,media_count&access_token=$accessToken";
        // $response = Http::get($url);
        // $userDetails = $response->json();
    
        return redirect()->route('business.getInstagram')->with('success', 'Instagram Id Added Successfully.');
    }

    public function updateInstagram(Request $request)
    {
        $currentUser = Auth::user();
        $updateAccount = InstgramConnection::where('user_id', $currentUser->id)->first();
        $updateAccount->instagram_id = $request->input('instagram_id');
        $updateAccount->save();
    
        return redirect()->route('business.getInstagram')->with('success', 'Instagram Id Updated Successfully.');
    }

    public function getInstagram(Request $request)
    {
        $currentUser = Auth::user();
        $instagram_details = InstgramConnection::where('user_id', $currentUser->id)->first();
    
        return view('business.socialmedia.instagram', compact('instagram_details'));
    }

    public function uploadFacebook(Request $request)
    {
        return view('business.socialmedia.upload_facebook');
    }

    public function uploadInstagram(Request $request)
    {
        return view('business.socialmedia.upload_instagram');
    }

    public function uploadYoutube(Request $request)
    {
        return view('business.socialmedia.upload_youtube');
    }

    public function uploadTwitter(Request $request)
    {
        return view('business.socialmedia.upload_twitter');
    }

    public function uploadTiktok(Request $request)
    {
        return view('business.socialmedia.upload_tiktok');
    }

    public function uploadSnapchat(Request $request)
    {
        return view('business.socialmedia.upload_snapchat');
    }

    public function uploadBereal(Request $request)
    {
        return view('business.socialmedia.upload_bereal');
    }

    public function uploadTwitch(Request $request)
    {
        return view('business.socialmedia.upload_twitch');
    }
}
