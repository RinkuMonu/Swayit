<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gig;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\TaskList;
use App\Models\Ticket;
use App\Models\TicketChat;
use App\Models\InstagramConnection;
use App\Models\FacebookConnection;
use App\Models\TwitterConnection;
use App\Models\TiktokConnection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Industry;
use App\Models\UserPromotion;
use App\Models\Bid;
use App\Models\BidMessage;
use App\Models\UserMessage;
use App\Models\BidProposal;
use App\Models\GigCheckout;
use App\Models\GigOrder;
use App\Models\GigOrderWork;
use App\Models\Transaction;
use App\Models\EscrowPayment;
use App\Models\Contract;
use App\Models\ContractWorkComment;
use App\Models\Campaign;
use App\Models\CampaignInfluencer;
use App\Models\CampaignComment;
use App\Models\Notification;
use App\Models\PaymentRequest;
use App\Models\WithdrawRequest;
use App\Models\BankDetail;
use App\Models\Paypal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpEmail;
use App\Models\LearnSwayitCategory;
use App\Models\LearnSwayitTutorial;
use App\Models\GoogleUser;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


class InfluencerController extends Controller
{
  

public function dashboard(Request $request)
{
    $user = Auth::user();

    // Earnings & Gigs
    $total_gigs = Gig::where('user_id', $user->id)->count();
    $total_contracts = Contract::where('person_two', $user->id)->count();
    $total_bid_proposals = BidProposal::where('sender_id', $user->id)->count();
    $gig_list = Gig::where('user_id', $user->id)->take(4)->get();

    $pending_amount = PaymentRequest::where('payment_to', $user->id)->whereNull('status')->sum('amount');
    $total_earings = PaymentRequest::where('payment_to', $user->id)->where('status', 1)->sum('amount');
    $total_withdraw = WithdrawRequest::where('user_id', $user->id)->where('status', 1)->sum('amount');
    $wallet_balance = $total_earings - $total_withdraw;

    $current_month_earings = PaymentRequest::where('payment_to', $user->id)
        ->where('status', 1)
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('amount');

    // ✅ Facebook
    $fbFollowers = $fbPosts = 0;
$fbUsername = $fbProfileImage = null;

if ($user->facebook_page_id && $user->facebook_page_token) {
    try {
        $response = Http::get("https://graph.facebook.com/v18.0/{$user->facebook_page_id}", [
            'fields' => 'followers_count,posts.limit(100){id},name,picture{url}',
            'access_token' => $user->facebook_page_token,
        ]);

        $fbData = $response->json();

        $fbFollowers = $fbData['followers_count'] ?? 0;
        $fbPosts = count($fbData['posts']['data'] ?? []);
        $fbUsername = $fbData['name'] ?? null;
        $fbProfileImage = $fbData['picture']['data']['url'] ?? null;

    } catch (\Exception $e) {
        \Log::error("Facebook API error: " . $e->getMessage());
    }
}


    // ✅ Instagram
    $igFollowers = $igPosts = 0;
    $igUsername = $igProfileImage = null;

if ($user->instagram_account_id) {
    try {
        $response = Http::get("https://graph.facebook.com/v23.0/{$user->instagram_account_id}", [
            'fields' => 'username,profile_picture_url,followers_count,media_count',
            'access_token' => $user->facebook_page_token,
        ]);

        $igData = $response->json();

        $igFollowers = $igData['followers_count'] ?? 0;
        $igPosts = $igData['media_count'] ?? 0;
        $igUsername = $igData['username'] ?? null;
        $igProfileImage = $igData['profile_picture_url'] ?? null;

    } catch (\Exception $e) {
        \Log::error("Instagram API error: " . $e->getMessage());
    }
}


    // ✅ Twitter
    $twFollowers = $twPosts = 0;
    $twConnection = TwitterConnection::where('user_id', $user->id)->first();
    if ($twConnection) {
        try {
            $userResponse = Http::withHeaders([
                'Authorization' => "Bearer {$twConnection->access_token}"
            ])->get("https://api.twitter.com/2/users/{$twConnection->platform_user_id}", [
                'user.fields' => 'public_metrics',
            ]);
            $twData = $userResponse->json();
            $twFollowers = $twData['data']['public_metrics']['followers_count'] ?? 0;

            $tweetsResponse = Http::withHeaders([
                'Authorization' => "Bearer {$twConnection->access_token}"
            ])->get("https://api.twitter.com/2/users/{$twConnection->platform_user_id}/tweets", [
                'max_results' => 100,
            ]);
            $twPosts = count($tweetsResponse['data'] ?? []);
        } catch (\Exception $e) {
            \Log::error("Twitter API error: " . $e->getMessage());
        }
    }

    // ✅ TikTok
    $tiktokFollowers = $tiktokPosts = 0;
    $ttConnection = DB::table('tiktok_connections')->where('user_id', $user->id)->first();
    if ($ttConnection) {
        try {
            $response = Http::get("https://yourapi.com/tiktok/{$ttConnection->platform_user_id}");
            $ttData = $response->json();
            $tiktokFollowers = $ttData['followers'] ?? 0;
            $tiktokPosts = $ttData['posts'] ?? 0;
        } catch (\Exception $e) {
            \Log::error("TikTok API error: " . $e->getMessage());
        }
    }

    $youtubeVideos = 0; 
      $subscribers = 0;
      $googleUserDetails = GoogleUser::where('user_id', $user->id)->first();

if ($googleUserDetails) {
    try {
        $accessToken = $googleUserDetails->google_token;

        if (now()->greaterThan($googleUserDetails->google_token_expires_in)) {
            $accessToken = $this->refreshGoogleAccessToken($googleUserDetails->google_refresh_token);
        }

        // ✅ Get channel details to find uploads playlist
        $channelResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json',
        ])->get('https://www.googleapis.com/youtube/v3/channels', [
            'part' => 'statistics,contentDetails',
            'mine' => 'true',
        ]);

        $channelData = $channelResponse->json();
        $subscribers = $channelData['items'][0]['statistics']['subscriberCount'] ?? 0;

        $uploadsPlaylistId = $channelData['items'][0]['contentDetails']['relatedPlaylists']['uploads'] ?? null;

        if ($uploadsPlaylistId) {
        
            $videoCount = 0;
            $nextPageToken = null;

            do {
                $videosResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ])->get('https://www.googleapis.com/youtube/v3/playlistItems', [
                    'part' => 'id',
                    'playlistId' => $uploadsPlaylistId,
                    'maxResults' => 50,
                    'pageToken' => $nextPageToken
                ]);

                $videosData = $videosResponse->json();
                $videoCount += count($videosData['items']);
                $nextPageToken = $videosData['nextPageToken'] ?? null;

            } while ($nextPageToken);

            $youtubeVideos = $videoCount;
        }
    } catch (\Exception $e) {
        
    }
}


    // ✅ Snapchat
    $snapchatFollowers = $snapchatPosts = 0;
    $snapchat = DB::table('snapchat_connections')->where('user_id', $user->id)->first();
    if ($snapchat) {
        $snapchatFollowers = $snapchat->followers ?? 0;
        $snapchatPosts = $snapchat->post_count ?? 0;
    }

    // ✅ BeReal
    $berealFollowers = $berealPosts = 0;
    $bereal = DB::table('bereal_connections')->where('user_id', $user->id)->first();
    if ($bereal) {
        $berealFollowers = $bereal->followers ?? 0;
        $berealPosts = $bereal->post_count ?? 0;
    }

    // ✅ Twitch
    $twitchFollowers = $twitchPosts = 0;
    $twitch = DB::table('twitch_connections')->where('user_id', $user->id)->first();
    if ($twitch) {
        try {
            $accessToken = $twitch->access_token;
            $clientId = config('services.twitch.client_id');
            $twitchUsername = $twitch->platform_username;

            $userResponse = Http::withHeaders([
                'Authorization' => "Bearer $accessToken",
                'Client-Id' => $clientId,
            ])->get("https://api.twitch.tv/helix/users", [
                'login' => $twitchUsername
            ]);
            $userData = $userResponse->json();
            $twitchUserId = $userData['data'][0]['id'] ?? null;

            if ($twitchUserId) {
                $followersResponse = Http::withHeaders([
                    'Authorization' => "Bearer $accessToken",
                    'Client-Id' => $clientId,
                ])->get("https://api.twitch.tv/helix/users/follows", [
                    'to_id' => $twitchUserId
                ]);
                $twitchFollowers = $followersResponse['total'] ?? 0;

                $videosResponse = Http::withHeaders([
                    'Authorization' => "Bearer $accessToken",
                    'Client-Id' => $clientId,
                ])->get("https://api.twitch.tv/helix/videos", [
                    'user_id' => $twitchUserId,
                    'first' => 100
                ]);
                $twitchPosts = count($videosResponse['data'] ?? []);
            }
        } catch (\Exception $e) {
            \Log::error("Twitch API error: " . $e->getMessage());
        }
    }

    return view('influencer.dashboard', compact(
        'user',
        'total_gigs',
        'total_contracts',
        'total_bid_proposals',
        'gig_list',
        'pending_amount',
        'total_earings',
        'current_month_earings',
        'total_withdraw',
        'wallet_balance',
        'fbFollowers', 'fbPosts',
        'igFollowers', 'igPosts',
        'fbUsername','fbProfileImage',
        'igUsername','igProfileImage',
        'twFollowers', 'twPosts',
        'tiktokFollowers', 'tiktokPosts',
        'subscribers',
        'snapchatFollowers', 'snapchatPosts',
        'berealFollowers', 'berealPosts',
        'twitchFollowers', 'twitchPosts',
        'subscribers',
        'youtubeVideos'
    ));
}



    public function refreshGoogleAccessToken($refreshToken)
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Optionally, you can update the token in your database here
            $user = Auth::user();
            $googleUser = GoogleUser::where('user_id', $user->id)->first();
            $googleUser->google_token = $data['access_token'];
            $googleUser->google_token_expires_in = now()->addSeconds($data['expires_in']);
            $googleUser->save();

            return $data['access_token'];
        } else {
            throw new \Exception("Failed to refresh access token");
        }
    }

    public function videoVerification(Request $request) 
    {
        $user = Auth::user();
        return view('influencer.video_verification', compact('user'));
    }

    public function uploadVideo(Request $request) 
    {
        $user = Auth::user();
        // dd($request->file('video'));
        // $request->validate([
        //     'video' => 'required|mimes:webm|max:20000'
        // ]);

        $videoPath = $request->file('video')->store('verify_videos', 'public');

        $userUpdate = User::where('id', $user->id)->first();
        $userUpdate->video = $videoPath;
        $userUpdate->video_verify = 1;
        $userUpdate->save();

        return redirect()->route('influencer.edit.profile')->with('success', 'Video Verified Successfully.');
    }

    public function otpVerification(Request $request) 
    {
        $user = Auth::user();
        return view('influencer.otp_verification', compact('user'));
    }

    public function sendOtp(Request $request)
    {
        $toEmail = "santoshkumarsahoo781@gmail.com";
        $emailOtp = rand(0000, 9999);

        Mail::to($toEmail)->send(new OtpEmail($emailOtp));
    }

    public function gigsList(Request $request) 
    {
        $user = Auth::user();

        $industry = Industry::orderBy('id', 'desc')->where('status', null)->get();
        $query = Gig::where('user_id', $user->id)->select('*');

        if (isset($request->search_title)) {
            $query->where('title', 'like', '%' . $request->search_title . '%');
            $search_title = $request->search_title;
        } else {
            $search_title = "";
        }

        if (isset($request->industry)) {
            // $searchedIndustry = Industry::where('id', $request->industry)->first();
            $query->where('industry', $request->industry);
            $search_industry = $request->industry;
        } else {
            $search_industry = "";
        }

        $checkboxes = [
            'facebook_check' => 'facebook',
            'instagram_check' => 'instagram',
            'youtube_check' => 'youtube',
            'bereal_check' => 'be_real',
            'snapchat_check' => 'snapchat',
            'twitter_check' => 'twitter',
            'twitch_check' => 'twitch',
            'tiktok_check' => 'tiktok',
            'linkedin_check' => 'linkedin',
        ];
        
        $checkedCheckboxes = [];

        foreach ($checkboxes as $checkbox => $column) {
            if ($request->has($checkbox)) {
                $query->where($column, 1);
                $checkedCheckboxes[$checkbox] = true;
            } else {
                $checkedCheckboxes[$checkbox] = false;
            }
        }

        $price_range = $request->price_range;

        if (isset($price_range)) {
            list($min, $max) = explode(';', $price_range);
        
            // dd($min, $max);
            // $query->whereRaw("CAST(price AS DECIMAL(10,2)) BETWEEN :min_value AND :max_value", [
            //     'min_value' => $min,
            //     'max_value' => $max,
            // ]);
            $query->whereBetween("price", [$min, $max]);
        }

        if($request->input('order')) {
            $query->orderBy(DB::raw('CAST(price AS UNSIGNED)'), $request->input('order'))->get();
        } else{
            $query->orderBy(DB::raw('CAST(price AS UNSIGNED)'), 'desc')->get();
        }

        $gig_list = $query->orderBy('id', 'desc')->paginate(20);

        return view('influencer.gig.gigs_list', compact('gig_list', 'search_title', 'checkedCheckboxes', 'industry', 'search_industry'));
    }

    public function addGigs(Request $request) 
    {
        $ctg_list = Category::orderBy('id', 'desc')->where('status', 1)->get();
        $subctg_list = SubCategory::orderBy('id', 'desc')->where('status', 1)->get();
        return view('influencer.gig.add_gigs', compact('ctg_list', 'subctg_list'));
    }

     public function storeGigs(Request $request) 
{
    $user = Auth::user();
    $imagePaths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('gig_images'), $filename);
            $imagePaths[] = 'gig_images/' . $filename;
        }
    }

    $stored_img = !empty($imagePaths) ? json_encode($imagePaths) : null;
    // Handle industry
    if ($request->industry == "another") {
        $newIndustry = new Industry();
        $newIndustry->name = $request->otherIndustry;
        $newIndustry->status = 1;
        $newIndustry->save();
        $industry = $newIndustry->id;
    } else {
        $industry = $request->industry;
    }

    // Store gig
    $newGig = new Gig();
    $newGig->user_id = $user->id;
    $newGig->title = $request->gigs_title;
    $newGig->tags = $request->gig_tags;
    $newGig->industry = $industry;
    $newGig->category = $request->category;
    $newGig->sub_category = $request->sub_category;
    $newGig->price = $request->gigs_price;
    $newGig->delivery_time = $request->delivery_time;
    $newGig->images = $stored_img;
    $newGig->facebook = $request->facebook ?? 0;
    $newGig->instagram = $request->instagram ?? 0;
    $newGig->twitter = $request->twitter ?? 0;
    $newGig->snapchat = $request->snapchat ?? 0;
    $newGig->linkedin = $request->linkedin ?? 0;
    $newGig->youtube = $request->youtube ?? 0;
    $newGig->tiktok = $request->tiktok ?? 0;
    $newGig->be_real = $request->be_real ?? 0;
    $newGig->twitch = $request->twitch ?? 0;
    $newGig->desc = $request->gig_desc;
    $newGig->save();

    return redirect()->route('influencer.gigs.list')->with('success', 'Gigs Added Successfully.');
}

    public function viewGigs($id)
    {
        $user = Auth::user();
        $user_details = User::where('id', $user->id)->first();
        $gig_details = Gig::where('id', $id)->first();
        $gig_list = Gig::orderBy('id', 'desc')->where('category', $gig_details->category)->get();
        return view('influencer.gig.gigs_details', compact('gig_details', 'gig_list', 'user_details'));
    }



    public function editGigs($id)
    {
        $gig_details = Gig::where('id', $id)->first();
        $ctg_list = Category::orderBy('id', 'desc')->where('status', 1)->get();
        $subctg_list = SubCategory::orderBy('id', 'desc')->where('status', 1)->get();
        return view('influencer.gig.edit_gigs', compact('gig_details', 'ctg_list', 'subctg_list'));
    }

  public function updateGigs(Request $request)
{
    $user = Auth::user();
    $newGig = Gig::findOrFail($request->id);

    // ✅ Handle images
    $existingImages = json_decode($newGig->images ?? '[]', true);
    if (!is_array($existingImages)) {
        $existingImages = [];
    }

    $newImagePaths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('gig_images', 'public');
            $newImagePaths[] = $path;
        }
    }

    $allImages = array_merge($existingImages, $newImagePaths);
    $stored_img = json_encode($allImages);

    // ✅ Handle dynamic industry
    if ($request->industry === "another") {
        $newIndustry = Industry::create([
            'name' => $request->otherIndustry,
            'status' => 1
        ]);
        $industry = $newIndustry->id;
    } else {
        $industry = $request->industry;
    }

    // ✅ Update gig fields
    $newGig->user_id = $user->id;
    $newGig->title = $request->gigs_title;
    $newGig->tags = $request->gig_tags;
    $newGig->industry = $industry;
    $newGig->category = $request->category;
    $newGig->sub_category = $request->sub_category;
    $newGig->price = $request->gigs_price;
    $newGig->delivery_time = $request->delivery_time;
    $newGig->images = $stored_img;
    $newGig->facebook = $request->facebook ?? 0;
    $newGig->instagram = $request->instagram ?? 0;
    $newGig->twitter = $request->twitter ?? 0;
    $newGig->snapchat = $request->snapchat ?? 0;
    $newGig->linkedin = $request->linkedin ?? 0;
    $newGig->youtube = $request->youtube ?? 0;
    $newGig->tiktok = $request->tiktok ?? 0;
    $newGig->desc = $request->gig_desc;
    $newGig->save();

    return redirect()->route('influencer.view.gigs', $request->id)
                     ->with('success', 'Gigs updated Successfully.');
}


    public function deleteGigImage(Request $request)
    {
        $gig = Gig::find($request->gig_id);
    
        if (!$gig) {
            return response()->json(['message' => 'Gig not found'], 404);
        }
    
        $images = json_decode($gig->images);
    
        if (($key = array_search($request->image, $images)) !== false) {
            unset($images[$key]);
            $gig->images = json_encode(array_values($images));
            $gig->save();
    
            Storage::disk('public')->delete($request->image);
    
            return response()->json(['message' => 'Image deleted successfully']);
        }
    
        return response()->json(['message' => 'Image not found'], 404);
    }

    public function deleteGigs(Request $request)
    {
        $user = Auth::user();
        $gig = Gig::find($request->id);
        
        if (!$gig) {
            return redirect()->route('influencer.gigs.list')->with('error', 'Gig not found.');
        }

        $images = json_decode($gig->images, true);
        if ($images) {
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $gig->delete();

        return redirect()->route('influencer.gigs.list')->with('success', 'Gig deleted successfully.');
    }
public function toggleStatus(Request $request)
{
    $gig = Gig::find($request->id);
    if (!$gig) {
        return response()->json(['status' => 'error', 'message' => 'Gig not found.']);
    }

    $gig->status = $gig->status == 1 ? 0 : 1;
    $gig->save();

    return response()->json([
        'status' => 'success',
        'new_status' => $gig->status
    ]);
}



    public function todoList(Request $request) 
    {
        $user = Auth::user();
    
        $task_list = TaskList::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(8);
        return view('influencer.task_list', compact('task_list', 'user'));
    }

    public function addTask(Request $request) 
    {
        $user = Auth::user();
        $newTask = new TaskList();
        $newTask->user_id = $user->id;
        $newTask->title = $request->title;
        $newTask->status = 0;
        $newTask->save();
        return redirect()->route('influencer.todo.list')->with('success', 'Task Added Successfully.');
    }

    public function updateTask(Request $request) 
    {
        $updateTask = TaskList::where('id', $request->id)->first();
        if ($updateTask) {
            $updateTask->status = $request->status;
            $updateTask->save();
            return redirect()->route('influencer.todo.list')->with('success', 'Task Updated Successfully.');
        }
        return redirect()->route('influencer.todo.list')->with('error', 'Task not found.');
    }

    public function deleteTask(Request $request)
    {
        $task = TaskList::find($request->id);
        if (!$task) {
            return redirect()->route('influencer.todo.list')->with('error', 'Task not found.');
        }
        $task->delete();
        return redirect()->route('influencer.todo.list')->with('success', 'Task deleted successfully.');
    }

public function autocomplete(Request $request)
{
    return Bid::where('title', 'like', '%' . $request->search . '%')->limit(10)->get(['title']);
}


    public function ticketList()
    {
        $user = Auth::user();

        $ticket_list = Ticket::where('user_id', $user->id)->orderBy('id', 'desc')->where('status', 1)->get();
        $solved_ticket_list = Ticket::where('user_id', $user->id)->orderBy('id', 'desc')->where('status', null)->get();
        return view('influencer.ticket.ticket_list', compact('ticket_list', 'user', 'solved_ticket_list'));
    }

    public function createTicket()
    {
        $user = Auth::user();
        return view('influencer.ticket.add_ticket', compact('user'));
    }

    public function addTicket(Request $request)
    {
        $user = Auth::user();

        $timestamp = Carbon::now()->format('dmyYHis');
        $ticket_id = "TD" . $timestamp;

        $newTicket = new Ticket();
        $newTicket->user_id = $user->id;
        $newTicket->ticket_id = $ticket_id;
        $newTicket->ticket_type = $request->ticket_type;
        $newTicket->title = $request->title;
        $newTicket->desc = $request->description;
        $newTicket->status = 1;
        $newTicket->save();

        return redirect()->route('influencer.ticket.list')->with('success', 'Ticket created successfully.');
    }

    public function updateTicket(Request $request) 
    {
        $updateTicket = Ticket::where('id', $request->id)->first();
        $updateTicket->ticket_type = $request->ticket_type;
        $updateTicket->title = $request->title;
        $updateTicket->desc = $request->description;
        $updateTicket->save();

        return redirect()->route('influencer.ticket.list')->with('success', 'Ticket Updated Successfully.');
    }

    public function deleteTicket(Request $request)
    {
        // dd('hhh');
        $user = Auth::user();
        $ticket = Ticket::find($request->id);
        
        if (!$ticket) {
            return redirect()->route('influencer.ticket.list')->with('error', 'Ticket not found.');
        }

        $ticket->delete();

        return redirect()->route('influencer.ticket.list')->with('success', 'Ticket deleted successfully.');
    }

    public function replyTicket($ticket_id)
    {
        $user = Auth::user();
        $ticket = Ticket::where('ticket_id', $ticket_id)->first();
        if (!$ticket) {
            return redirect()->route('influencer.reply.ticket')->with('error', 'Ticket not found.');
        }

        $chat_list = TicketChat::where('ticket_id', $ticket->id)->orderBy('created_at', 'asc')->get();
        return view('influencer.ticket.ticket_view', compact('ticket', 'chat_list', 'user'));
    }

    public function sendTicketMessage(Request $request)
    {
        $user = Auth::user();

        $ticketChat = new TicketChat();
        $ticketChat->user_id = $user->id;
        $ticketChat->ticket_id = $request->ticket_id;
        $ticketChat->message = $request->message;
        $ticketChat->status = 1; // status 1 is user message and 0 is admin message
        $ticketChat->save();

        return redirect()->route('influencer.reply.ticket', $request->user_ticket_id)->with('success', 'Message sent successfully.');
    }

    public function closeTicket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        if ($ticket) {
            $ticket->status = 0;
            $ticket->save();
            return redirect()->route('influencer.ticket.list')->with('success', 'Ticket closed successfully.');
        }
        return redirect()->route('influencer.ticket.list')->with('error', 'Ticket not found.');
    }

    public function profile()
    {
        $user = Auth::user();
        $user_details = User::where('id', $user->id)->first();

        return view('influencer.profile', compact('user_details'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $user_details = User::where('id', $user->id)->first();


        return view('influencer.edit_profile', compact('user_details'));
    }


public function updateProfile(Request $request)
{

    $user = Auth::user();
    $updateProfile = User::findOrFail($user->id);
    


    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');

        // Delete old image if exists
        if ($updateProfile->profile_img && file_exists(public_path($updateProfile->profile_img))) {
            unlink(public_path($updateProfile->profile_img));
        }

        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $destination = public_path('profile_images');
        $file->move($destination, $filename);

        $updateProfile->profile_img = 'profile_images/' . $filename;
    }

    // ✅ Handle dynamic industry creation
    if ($request->industry === "another" && $request->filled('otherIndustry')) {
        $newIndustry = Industry::create([
            'name' => $request->otherIndustry,
            'status' => 1,
        ]);
        $industryId = $newIndustry->id;
    } else {
        $industryId = $request->industry;
    }
   $updateProfile->fill([
    'bio'       => $request->filled('bio') ? $request->input('bio') : null,
    'about'     => $request->filled('about') ? $request->input('about') : null,
    'website'   => $request->filled('website') ? $request->input('website') : null,
    'company'   => $request->filled('company') ? $request->input('company') : null,
    'tags'      => $request->filled('tags') ? $request->input('tags') : null,
    'language'  => $request->filled('language') ? $request->input('language') : null,
    'address'   => $request->filled('address') ? $request->input('address') : null,
    'city'      => $request->filled('city') ? $request->input('city') : null,
    'state'     => $request->filled('state') ? $request->input('state') : null,
    'zip'       => $request->filled('zip') ? $request->input('zip') : null,
    'country'   => $request->filled('country') ? $request->input('country') : null,
    'first_name'=> $request->input('first_name'),
    'last_name' => $request->input('last_name'),
    'username'  => $request->input('username'),
    'email'     => $request->input('email'),
    'industry'  => $industryId,
    'facebook'  => $request->input('facebook'),
    'instagram' => $request->input('instagram'),
    'twitter'   => $request->input('twitter'),
    'linkedin'  => $request->input('linkedin'),
    'snapchat'  => $request->input('snapchat'),
    'tiktok'    => $request->input('tiktok'),
]);



    $updateProfile->save();

    Auth::setUser($updateProfile);

    return redirect()->route('influencer.edit.profile')->with('success', 'Profile updated successfully.');
}


  

    public function addPromotion(Request $request)
    {
        $user = Auth::user();

        $addPromotion = new UserPromotion();
        $addPromotion->user_id = $user->id;
        $addPromotion->title = $request->title;
        $addPromotion->desc = $request->description;
        $addPromotion->save();

        return redirect()->route('influencer.edit.profile')->with('success', 'User Promotion added successfully.');
    }

    public function updatePromotion(Request $request)
    {
        $user = Auth::user();

        $updatePromotion = UserPromotion::where('id', $request->id)->first();
        $updatePromotion->title = $request->title;
        $updatePromotion->desc = $request->description;
        $updatePromotion->save();

        return redirect()->route('influencer.edit.profile')->with('success', 'User Promotion updated successfully.');
    }

    public function deletePromotion(Request $request)
    {
        $user = Auth::user();

        $promotion = UserPromotion::find($request->id);
        $promotion->delete();

        return redirect()->route('influencer.edit.profile')->with('success', 'Promotion deleted successfully.');
    }
   

public function bidList(Request $request)
{
    $industry = Industry::orderBy('id', 'desc')->whereNull('status')->get();

    $query = Bid::whereNull('status');

    $search_bid = $request->search_bid ?? '';
    $search_location = $request->search_location ?? '';
    $search_industry = $request->industry ?? '';


    if (!empty($search_bid)) {
        $query->where('title', 'like', '%' . $search_bid . '%');
    }

    if (!empty($search_location)) {
        $query->where('location', 'like', '%' . $search_location . '%');
    }

    if (!empty($search_industry)) {
        $query->where('industry', $search_industry);
    }

       $priceRange = explode(',', $request->price_range ?? '');
$minPrice = $priceRange[0] ?? null;
$maxPrice = $priceRange[1] ?? null;

if ($minPrice !== null && $maxPrice !== null) {
    $query->whereBetween('price', [(float)$minPrice, (float)$maxPrice]);
}


   $checkboxes = [
    'facebook_chk' => 'facebook',
    'instagram_chk' => 'instagram',
    'youtube_chk' => 'youtube',
    'bereal_chk' => 'be_real',
    'snapchat_chk' => 'snapchat',
    'twitter_chk' => 'twitter',
    'twitch_chk' => 'twitch',
    'tiktok_chk' => 'tiktok',
    'linkedin_chk' => 'linkedin',
];

$checkedCheckboxes = [];
$socialMediaConditions = [];

foreach ($checkboxes as $checkbox => $column) {
    if ($request->has($checkbox)) {
        $socialMediaConditions[] = $column;
        $checkedCheckboxes[$checkbox] = true;
    } else {
        $checkedCheckboxes[$checkbox] = false;
    }
}

// Add OR conditions if at least one social media checkbox is checked
if (!empty($socialMediaConditions)) {
    $query->where(function ($q) use ($socialMediaConditions) {
        foreach ($socialMediaConditions as $column) {
            $q->orWhere($column, 1);
        }
    });
}


    $bidList = $query->orderByDesc('id')->paginate(20)->appends($request->except('page'));

    return view('influencer.bid.bidding_list', compact(
        'bidList',
        'search_bid',
        'search_location',
        'search_industry',
        'industry',
        'checkedCheckboxes',
    ));
}




public function searchBidsAutocomplete(Request $request)
{
    $keyword = $request->query('keyword', '');
    $selectedSocialMedia = $request->query('social_media', []); // expecting array like ['facebook', 'instagram']

    $query = Bid::whereNull('status');

    if (!empty($keyword) && strlen($keyword) >= 2) {
        $query->where('title', 'like', '%' . $keyword . '%');
    }

    if (!empty($selectedSocialMedia)) {
        $query->where(function ($q) use ($selectedSocialMedia) {
            foreach ($selectedSocialMedia as $platform) {
                $q->orWhereJsonContains('social_media', $platform);
                // Assuming 'social_media' is stored as a JSON array in DB like: ["facebook", "instagram"]
            }
        });
    }

    $bids = $query->orderBy('title', 'asc')->limit(10)->get(['id', 'title']);

    return response()->json($bids);
}





    public function matchingBids(Request $request)
    {
        $user = Auth::user();
        // $userTags = $user->tags;

        // if ($userTags) {
        //     $userTagValues = collect(json_decode($userTags))->pluck('value');
        
        //     $matchingGigs = DB::table('gigs')
        //         ->where(function ($query) use ($userTagValues) {
        //             foreach ($userTagValues as $tagValue) {
        //                 $query->orWhereJsonContains('tags', ['value' => $tagValue]);
        //             }
        //         })
        //         ->get();
        // } else {
        //     $matchingGigs = collect();
        // }

        $industry = Industry::orderBy('id', 'desc')->where('status', null)->get();

        $query = Bid::select('*')->where('status', null)->where('industry', $user->industry);

        if (isset($request->search_bid)) {
            $query->where('title', 'like', '%' . $request->search_bid . '%');
            $search_bid = $request->search_bid;
        } else {
            $search_bid = "";
        }

        if (isset($request->search_location)) {
            $query->where('location', 'like', '%' . $request->search_location . '%');
            $search_location = $request->search_location;
        } else {
            $search_location = "";
        }

        if (isset($request->industry)) {
            // $searchedIndustry = Industry::where('id', $request->industry)->first();
            $query->where('industry', $request->industry);
            $search_industry = $request->industry;
        } else {
            $search_industry = "";
        }

        $checkboxes = [
            'facebook_chk' => 'facebook',
            'instagram_chk' => 'instagram',
            'youtube_chk' => 'youtube',
            'bereal_chk' => 'be_real',
            'snapchat_chk' => 'snapchat',
            'twitter_chk' => 'twitter',
            'twitch_chk' => 'twitch',
            'tiktok_chk' => 'tiktok',
            'linkedin_chk' => 'linkedin',
        ];
        
        $checkedCheckboxes = [];

        foreach ($checkboxes as $checkbox => $column) {
            if ($request->has($checkbox)) {
                $query->where($column, 1);
                $checkedCheckboxes[$checkbox] = true;
            } else {
                $checkedCheckboxes[$checkbox] = false;
            }
        }

        $bidList = $query->orderBy('id', 'desc')->paginate(20)->appends($request->except('page'));

        return view('influencer.bid.matching_bids', compact('bidList', 'search_bid', 'search_location', 'checkedCheckboxes', 'industry', 'search_industry'));
    }

    public function bidDetails($id)
    {
        $authUser = Auth::user();
        $bidDetails = Bid::where('id', $id)->first();

        return view('influencer.bid.bid_details', compact('bidDetails', 'authUser'));
    }

    public function sendBidProposal(Request $request)
    {
        $user = Auth::user();
        
        $bidProposal = new BidProposal();
        $bidProposal->sender_id = $user->id;
        $bidProposal->receiver_id = $request->receiver_id;
        $bidProposal->bid_id = $request->bid_id;
        $bidProposal->message = $request->description;
        $bidProposal->amount = $request->budget;
        $bidProposal->save();

        // $sendMessage = new UserMessage();
        // $sendMessage->sender_id = $user->id;
        // $sendMessage->receiver_id = $request->receiver_id;
        // $sendMessage->message = $request->description;
        // $sendMessage->save();
        
        $notification = new Notification();
        $notification->user_id = $request->receiver_id;
        $notification->title = 'New proposal for bid';
        $notification->link = 'bid-proposals';
        $notification->save();

        return redirect()->route('influencer.bid.details', $request->bid_id)->with('success', 'Proposal sent successfully.');
    }

    // public function sendBidMessage(Request $request)
    // {
    //     $user = Auth::user();

    //     $send_message = new BidMessage();
    //     $send_message->sender_id = $user->id;
    //     $send_message->receiver_id = $request->receiver_id;
    //     $send_message->proposal_id = $request->proposal_id;
    //     $send_message->message = $request->message;
    //     $send_message->save();

    //     return redirect()->route('influencer.bid.chat', $request->proposal_id);
    // }
    
    public function bidProposals(Request $request)
    {
        $user = Auth::user();
        $bid_proposals = BidProposal::where('sender_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('influencer.bid.bid_proposals', compact('user', 'bid_proposals'));
    }

    public function gigsOrder(Request $request)
    {
        $user = Auth::user();
        $gigs_order = GigOrder::where('influencer_id', $user->id)->get();

        return view('influencer.gig.gigs_order', compact('gigs_order', 'user'));
    }

    public function submitGigOrder(Request $request)
    {
        $user = Auth::user();

        if($request->file('attachment')) {
            $attachmentPath = $request->file('attachment')->store('gig_order_attachment', 'public');
        } else {
            $attachmentPath = null;
        }

        $postStatus = new GigOrderWork();
        $postStatus->gig_order_id = $request->order_id;
        $postStatus->sender_id = $user->id;
        $postStatus->receiver_id = $request->receiver_id;
        $postStatus->message = $request->message;
        $postStatus->attachment = $attachmentPath;
        $postStatus->save();
        
        $gigs_order = GigOrder::where('id', $request->order_id)->first();
        $gigs_order->approval_status = null;
        $gigs_order->save();

        $notification = new Notification();
        $notification->user_id = $request->receiver_id;
        $notification->title = $user->first_name. ' ' .$user->last_name. ' completed the order.';
        $notification->link = 'gigs-orders';
        $notification->save();

        return redirect()->back()->with('success', 'Request for approval sent.');
    }

    public function gigsOrderStatus($order_id)
    {
        $user = Auth::user();
        $gigs_order = GigOrder::where('id', $order_id)->first();
        $work_status = GigOrderWork::where('gig_order_id', $gigs_order->id)->orderBy('id', 'asc')->get();

        return view('influencer.gig.gig_order_status', compact('work_status', 'user', 'gigs_order'));
    }

    public function startChat(Request $request) 
    {
        $current_user = Auth::user();

        $startMessage = new UserMessage();
        $startMessage->sender_id = $current_user->id;
        $startMessage->receiver_id = $request->receiver_id;
        $startMessage->message = null;
        $startMessage->save();
        
        return redirect()->route('influencer.chat.message', $request->receiver_id);
    }

    public function chat()
    {
        $current_user = Auth::user();
        $userChat = null;

        $find_message = \App\Models\UserMessage::where('sender_id', $current_user->id)->orWhere('receiver_id', $current_user->id)->orderBy('created_at', 'desc')->get();

        $get_user_ids = $find_message->pluck('sender_id')->merge($find_message->pluck('receiver_id'))->unique()->toArray();

        $user_ids = $find_message->map(function ($message) use ($current_user) {
            return $message->sender_id == $current_user->id ? $message->receiver_id : $message->sender_id;
        })->unique()->toArray();

        // $user_list = User::whereNot('role_id', 2)->whereNot('user_role', 'admin')->whereNot('id', $current_user->id)->get();
        return view('influencer.chat.chat', compact('current_user', 'user_ids', 'userChat'));
    }

    public function chatMessage($user_id)
    {
        $current_user = Auth::user();
        $userChat = User::findOrFail($user_id);

        // $user_list = User::whereNot('role_id', 2)->whereNot('user_role', 'admin')->whereNot('id', $current_user->id)->get();
        $find_message = \App\Models\UserMessage::where('sender_id', $current_user->id)->orWhere('receiver_id', $current_user->id)->orderBy('created_at', 'desc')->get();

        $get_user_ids = $find_message->pluck('sender_id')->merge($find_message->pluck('receiver_id'))->unique()->toArray();

        $user_ids = $find_message->map(function ($message) use ($current_user) {
            return $message->sender_id == $current_user->id ? $message->receiver_id : $message->sender_id;
        })->unique()->toArray();
        

        if (request()->ajax()) {
            return response()->json([
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'status' => 'Out is my favorite.'
            ]);
        }

        return view('influencer.chat.chat', compact('current_user', 'userChat', 'user_ids'));
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        if($request->file('chat_attachment')) {
            $attachmentPath = $request->file('chat_attachment')->store('chat_attachment', 'public');
        } else {
            $attachmentPath = null;
        }

        // Create a new message
        $send_message = new UserMessage();
        $send_message->sender_id = $user->id;
        $send_message->receiver_id = $request->receiver_id;
        $send_message->message = $request->message;
        $send_message->attachment = $attachmentPath;
        $send_message->save();
    
        // Format the time for the response
        $formattedTime = $send_message->created_at->format('g:i a');
    
        return response()->json([
            'message' => $send_message->message,
            'attachment' => $send_message->attachment,
            'formatted_time' => $formattedTime,
        ]);
    }

    public function getMessages($user_id)
    {
        $user_messages = \App\Models\UserMessage::where('sender_id', $user_id)
            ->orWhere('receiver_id', $user_id)
            ->orderBy('created_at', 'asc')
            ->get();
            
        $current_user = Auth::user();
        $user = \App\Models\User::where('id', $user_id)->first();

        // $html = view('business.chat.message', compact('user_messages'))->render();
        return view('influencer.chat.message', compact('user_messages', 'user', 'current_user'))->render();
    }

    public function contractList(Request $request)
    {
        $user = Auth::user();
        $contract_list = Contract::where('person_two', $user->id)->whereNot('status', null)->orderBy('created_at', 'desc')->get();

        return view('influencer.contract.contract_list', compact('contract_list'));
    }

    public function makeContract(Request $request, $contract_id)
    {
        $user = Auth::user();
        $contract = Contract::where('id', $contract_id)->first();
        $business = User::where('id', $contract->person_one)->first();
        $influencer = User::where('id', $contract->person_two)->first();

        return view('influencer.contract.make_contract', compact('contract', 'business', 'influencer'));
    }

    public function uploadSignature(Request $request)
    {
        $user = Auth::user();

        if($request->contract_id) {
            $contract = Contract::where('id', $request->contract_id)->first();
            
            if($request->signature_pad_image) {
                $base64String = $request->signature_pad_image;
                $imageData = substr($base64String, strpos($base64String, ',') + 1);
                $image = base64_decode($imageData);
                $fileName = 'contract_signature_' . uniqid() . '.png';
                $contractSignPath = 'contract_sign/' . $fileName;

                Storage::disk('public')->put($contractSignPath, $image);

                $contract->person_two_signature = $contractSignPath;
                $contract->status = 2;
                $contract->save();

                return redirect()->route('influencer.make.contract', $request->contract_id)->with('success', 'Signature updated successfully.');
            } elseif($request->hasFile('signature_image')) {
                $contractSign = $request->file('signature_image')->store('contract_sign', 'public');
                $contract->person_two_signature = $contractSign;
                $contract->status = 2;
                $contract->save();

                return redirect()->route('influencer.make.contract', $request->contract_id)->with('success', 'Signature updated successfully.');
            } else {
                return redirect()->route('influencer.make.contract', $request->contract_id)->with('error', 'Please upload signature.');
            }
        }
    }

    public function updateContract(Request $request)
    {
        $user = Auth::user();
        $ipAddress = $request->ip();

        $contract = Contract::where('id', $request->contract_id)->first();

        $contract->shipping_address = $request->shipping_address;
        $contract->person_two_agree = $request->contract_accept_checkbox;
        $contract->influencer_ip_address = $ipAddress;
        $contract->save();

        return redirect()->route('influencer.contract.list')->with('success', 'Contract updated successfully.');
    }

    public function storeContrant(Request $request)
    {
        $user = Auth::user();

        // dd($request->all());
        $contract = Contract::where('id', $request->contract_id)->first();

        if ($request->hasFile('signature_image')) {
            $contractSign = $request->file('signature_image')->store('contract_sign', 'public');
            $contract->person_two_signature = $contractSign;
        }
        
        if($contract->status = 1) {
            $contract->status = 2;
        } else {
            $contract->status = 1;
        }
        $contract->shipping_address = $request->shipping_address;
        $contract->tracking_id = $request->tracking_id;
        $contract->person_two_agree = $request->contract_accept_checkbox;
        $contract->save();

        $notification = new Notification();
        $notification->user_id = $contract->person_one;
        $notification->title = $user->first_name. ' ' .$user->last_name. ' accepted your contract.';
        $notification->link = 'make-contract/'.$contract->id;
        $notification->save();

        return redirect()->route('influencer.contract.list')->with('success', 'Contract submitted successfully.');
    }

    public function viewNotification(Request $request)
    {
        $user = Auth::user();
        $notification_list = Notification::where('user_id', $user->id)->get();

        return view('influencer.notification', compact('notification_list'));
    }

    public function readNotification(Request $request)
    {
        $user = Auth::user();

        $readNotfications = Notification::where('user_id', $user->id)->get();
        foreach($readNotfications as $notf) {
            $notf->status = 1;
            $notf->save();
        }

        return redirect()->route('influencer.notification')->with('success', 'All notifications mark as read.');
    }

    public function downloadContrant(Request $request, $contract_id)
    {
        $user = Auth::user();
        $contract = Contract::where('id', $contract_id)->first();
        $personOne = User::where('id', $contract->person_one)->first();
        $personTwo = User::where('id', $contract->person_two)->first();

        return view('influencer.contract.download_contract', compact('contract', 'personOne', 'personTwo'));
    }

    public function contractWorkstatus(Request $request, $contract_id)
    {
        $user = Auth::user();
        $contractDetails = Contract::where('id', $contract_id)->first();

        $contractComments = ContractWorkComment::where('contract_id', $contract_id)->get();
        $bidProposals = BidProposal::where('bid_id', $contractDetails->bid_id)->where('sender_id', $contractDetails->person_two)->first();
        $work_status_count = ContractWorkComment::where('contract_id', $contract_id)->count();

        return view('influencer.contract.contract_work_status', compact('contractComments', 'user', 'contractDetails', 'bidProposals', 'work_status_count'));
    }

    public function contractComment(Request $request)
    {
        $user = Auth::user();

        if($request->file('attachment')) {
            $attachmentPath = $request->file('attachment')->store('contract_attachment', 'public');
        } else {
            $attachmentPath = null;
        }

        $addComment = new ContractWorkComment();
        $addComment->contract_id = $request->contract_id;
        $addComment->bid_id = $request->bid_id;
        $addComment->sender_id = $user->id;
        $addComment->receiver_id = $request->receiver_id;
        $addComment->message = $request->message;
        $addComment->attachment = $attachmentPath;
        $addComment->save();

        $bidProposal = BidProposal::where('bid_id', $request->bid_id)->where('sender_id', $user->id)->first();
        $bidProposal->work_status = null;
        $bidProposal->save();

        return redirect()->route('influencer.contract.workstatus', $request->contract_id)->with('success', 'Request send successfully.');
    }


    public function campaignList(Request $request)
    {
        $user = Auth::user();
        $my_campaign_list = CampaignInfluencer::where('influencer_id', $user->id)->get();

        return view('influencer.campaign.campaign_list', compact('my_campaign_list', 'user'));
    }

    public function campaignView($campaign_id)
    {
        $user = Auth::user();
        $campaignDetails = Campaign::where('id', $campaign_id)->first();

        return view('influencer.campaign.campaign_details', compact('campaignDetails', 'user'));
    }

    public function acceptCampaign(Request $request)
    {
        $user = Auth::user();

        $updateStatus = CampaignInfluencer::where('id', $request->id)->first();
        $updateStatus->status = 1;
        $updateStatus->save();
        
        $updateCampaignStatus = Campaign::where('id', $updateStatus->campaign_id)->first();
        if($updateCampaignStatus->camp_status == 3 || $updateCampaignStatus->camp_status == 2) {
            $updateCampaignStatus->camp_status = 3;
            $updateCampaignStatus->save();
        }

        return redirect()->route('influencer.campaign.list')->with('success', 'Accepted.');
    }

    public function declineCampaign(Request $request)
    {
        $user = Auth::user();

        $updateStatus = CampaignInfluencer::where('id', $request->id)->first();
        $updateStatus->status = 2;
        $updateStatus->save();

        return redirect()->route('influencer.campaign.list')->with('success', 'Declined.');
    }

    public function postComment(Request $request)
    {
        $user = Auth::user();

        if($request->file('attachment')) {
            $attachmentPath = $request->file('attachment')->store('campaign_comments_attachment', 'public');
        } else {
            $attachmentPath = null;
        }

        $postComment = new CampaignComment();
        $postComment->campaign_id = $request->campaign_id;
        $postComment->sender_id = $user->id;
        $postComment->receiver_id = $request->receiver_id;
        $postComment->comment = $request->comment;
        $postComment->attachment = $attachmentPath;
        $postComment->save();

        $updateCampaignStatus = Campaign::where('id', $request->campaign_id)->first();
        if($updateCampaignStatus->camp_status == 4 || $updateCampaignStatus->camp_status == 3 || $updateCampaignStatus->camp_status == 2) {
            $updateCampaignStatus->camp_status = 4;
            $updateCampaignStatus->save();
        }

        $updateStatus = CampaignInfluencer::where('campaign_id', $request->campaign_id)->where('influencer_id', $user->id)->first();
        $updateStatus->request_status = null;
        $updateStatus->save();

        $sendNotification = new Notification();
        $sendNotification->user_id = $request->receiver_id;
        $sendNotification->title = $user->first_name. ' ' .$user->last_name. " send request for approval.";
        $sendNotification->link = 'campaign-workstatus/'.$request->campaign_id.'/'.$user->id;
        $sendNotification->save();

        return redirect()->route('influencer.campaign.comment', $request->campaign_id)->with('success', 'Request for approval sent.');
    }

    public function analyticsCampaign(Request $request)
    {
        return view('influencer.campaign.campaign_analytics');
    }

    public function campaignComment($campaign_id)
    {
        $user = Auth::user();
        $campaignComments = CampaignComment::where('campaign_id', $campaign_id)->orderBy('id', 'asc')->get();
        $campaign = Campaign::where('id', $campaign_id)->first();

        return view('influencer.campaign.campaign_work_status', compact('campaignComments', 'user', 'campaign'));
    }

    public function calender(Request $request)
    {
        $user = Auth::user();

        $campaign_ids = CampaignInfluencer::where('influencer_id', $user->id)->pluck('campaign_id');
        $campaign_list = Campaign::whereIn('id', $campaign_ids)->get();
        return view('influencer.calender', compact('campaign_list'));
    }

  

private function detectPlatform($url)
{
    if (str_contains($url, 'instagram.com')) return 'Instagram';
    if (str_contains($url, 'tiktok.com')) return 'TikTok';
    if (str_contains($url, 'youtube.com')) return 'YouTube';
    return 'Unknown';
}

// For loading the page
public function searchInfluencers(Request $request)
{
    return view('influencer.search_influencers');
}



public function fetchInfluencers(Request $request)
{
    try {
        $q = $request->query('q');

        if (!$q || strlen($q) < 3) {
            return response()->json(['results' => []]);
        }

        $apiKey = config('services.serpapi.key');

      $searchQuery = '"' . $q . '" (site:instagram.com OR site:tiktok.com OR site:youtube.com)';

$response = Http::get('https://serpapi.com/search.json', [
    'engine' => 'google',
    'q' => $searchQuery,
    'location' => 'United States',
    'api_key' => $apiKey,
    't' => now()->timestamp 
]);


        if (!$response->ok()) {
            return response()->json([
                'error' => 'Failed to fetch data from SerpAPI',
                'details' => $response->body()  
            ], 500);
        }

        $json = $response->json();
        $organicResults = $json['organic_results'] ?? [];

        $results = [];

        foreach ($organicResults as $item) {
            $link = $item['link'] ?? null;
            $title = $item['title'] ?? 'Unknown';

            if (!$link || (!str_contains($link, 'instagram.com') && !str_contains($link, 'tiktok.com') && !str_contains($link, 'youtube.com'))) {
                continue;
            }

            $platform = str_contains($link, 'instagram.com') ? 'Instagram' :
                        (str_contains($link, 'tiktok.com') ? 'TikTok' :
                        (str_contains($link, 'youtube.com') ? 'YouTube' : 'Unknown'));

            $results[] = [
                'name' => $title,
                'profile_image' => 'https://via.placeholder.com/150',
                'bio' => $item['snippet'] ?? 'No bio',
                'platform' => $platform,
                'profile_url' => $link,
            ];
        }

        return response()->json(['results' => $results]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Exception occurred',
            'message' => $e->getMessage()
        ], 500);
    }
}


public function notifyInfluencers(Request $request)
{
    $influencers = $request->input('influencers');

    foreach ($influencers as $influencer) {
     

        \Log::info('Notify influencer:', [
            'name' => $influencer['name'],
            'platform' => $influencer['platform'],
            'profile' => $influencer['profile_url']
        ]);

    }

    return response()->json(['message' => 'Influencers notified successfully!']);
}





   public function findInfluencers(Request $request)
{
    $user = Auth::user();
    $query = User::where('user_role', 'influencer')
        ->where('role_id', '3')
        ->where('id', '!=', $user->id);

    $search_name = $request->search_name ?? '';
    $search_skill = $request->search_skill ?? '';

    
    if (!empty($search_name)) {
        $query->where(function ($q) use ($search_name) {
            $q->where('first_name', 'like', '%' . $search_name . '%')
              ->orWhere('last_name', 'like', '%' . $search_name . '%');
        });
    }

    
    if (!empty($search_skill)) {
        $query->where(function ($q) use ($search_skill) {
            $q->where('bio', 'like', '%' . $search_skill . '%')
              ->orWhere('about', 'like', '%' . $search_skill . '%')
              ->orWhere('tags', 'like', '%' . $search_skill . '%');
        });
    }
    $influencer_list = $query->orderBy('id', 'desc')->paginate(20)->appends($request->except('page'));
    return view('influencer.find_influencers', compact('influencer_list', 'search_name', 'search_skill', 'user'));
}


    public function profileView($user_id)
    {
        $authUser = Auth::user();
        $user_details = User::where('id', $user_id)->first();

        $gig_list = Gig::where('user_id', $user_id)->get();

        return view('influencer.profile', compact('user_details', 'authUser', 'gig_list'));
    }

    public function wallet(Request $request)
    {
        $user = Auth::user();
        $transaction_list = Transaction::orderBy('id', 'desc')->where('influencer_id', $user->id)->get();
        $withdraw_list = WithdrawRequest::orderBy('id', 'desc')->where('user_id', $user->id)->get();

        $pending_amount = PaymentRequest::where('payment_to', $user->id)->where('status', null)->sum('amount');
        $total_earings = PaymentRequest::where('payment_to', $user->id)->where('status', 1)->sum('amount');
        $total_withdraw = WithdrawRequest::where('user_id', $user->id)->where('status', 1)->sum('amount');
        $wallet_balance = $total_earings - $total_withdraw;

        return view('influencer.payment.wallet', compact('transaction_list', 'wallet_balance', 'pending_amount', 'total_earings', 'total_withdraw', 'withdraw_list'));
    }

    public function withdrawRequest(Request $request)
    {
        $user = Auth::user();
        $addWithdrawRequest = new WithdrawRequest();
        $addWithdrawRequest->user_id = $user->id;
        $addWithdrawRequest->amount = $request->amount;
        $addWithdrawRequest->save();

        return redirect()->route('influencer.wallet')->with('success', 'Withdrawl request sent.');
    }

    public function transactionList(Request $request)
    {
        $user = Auth::user();
        $transaction_list = Transaction::orderBy('id', 'desc')->where('influencer_id', $user->id)->get();

        return view('influencer.payment.transaction', compact('transaction_list'));
    }

    public function downloadReceipt($transaction_id)
    {
        $user = Auth::user();
        $transaction = Transaction::where('id', $transaction_id)->first();

        return view('influencer.payment.download_receipt', compact('transaction'));
    }

    public function learnSwayit(Request $request)
    {
        $swayit_tutorial = LearnSwayitTutorial::orderBy('created_at', 'desc')->get();
        $swayit_category = LearnSwayitCategory::orderBy('created_at', 'desc')->get();

        return view('influencer.learn_swayit.learn_swayit', compact('swayit_category', 'swayit_tutorial'));
    }

    public function tutorialDetails($tutorial_id)
    {
        $swayit_tutorial = LearnSwayitTutorial::where('id', $tutorial_id)->first();
        return view('influencer.learn_swayit.tutorial_details', compact('swayit_tutorial'));
    }

    public function bankList()
    {
        $user = Auth::user();

        $bank_list = BankDetail::orderBy('created_at', 'desc')->where('user_id', $user->id)->where('status', null)->get();
        $paypal_list = Paypal::orderBy('created_at', 'desc')->where('user_id', $user->id)->where('status', null)->get();
        return view('influencer.bank.bank', compact('bank_list', 'paypal_list'));
    }

    public function addBank(Request $request)
    {
        $user = Auth::user();

        $addProduct = new BankDetail();
        $addProduct->user_id = $user->id;
        $addProduct->bank_name = $request->bank_name;
        $addProduct->account_number = $request->account_number;
        $addProduct->account_name = $request->account_name;
        $addProduct->swift_code = $request->swift_code;
        $addProduct->save();

        return redirect()->back()->with('success', 'Bank Added Successfully.');
    }

    public function deleteBank(Request $request)
    {
        $user = Auth::user();
        $bank = BankDetail::find($request->id);
        $bank->status = 1;
        $bank->save();

        return redirect()->back()->with('success', 'Bank Deleted Successfully.');
    }

    public function addPaypal(Request $request)
    {
        $user = Auth::user();

        $addProduct = new Paypal();
        $addProduct->user_id = $user->id;
        $addProduct->email = $request->paypal_email;
        $addProduct->save();

        return redirect()->back()->with('success', 'Paypal Account Added Successfully.');
    }

    public function deletePaypal(Request $request)
    {
        $user = Auth::user();
        $bank = Paypal::find($request->id);
        $bank->status = 1;
        $bank->save();

        return redirect()->back()->with('success', 'Paypal Account Deleted Successfully.');
    }
}
