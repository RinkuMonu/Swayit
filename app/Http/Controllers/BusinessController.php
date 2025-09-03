<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gig;
use App\Models\Bid;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Ticket;
use App\Models\TicketChat;
use App\Models\Notification;
use App\Models\TaskList;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\BidMessage;
use App\Models\UserMessage;
use App\Models\BidProposal;
use App\Models\GigCheckout;
use App\Models\Coupon;
use App\Models\GigOrder;
use App\Models\GigOrderWork;
use App\Models\GigCart;
use App\Models\PaymentRequest;
use App\Models\Transaction;
use App\Models\EscrowPayment;
use App\Models\Industry;
use App\Models\Contract;
use App\Models\ContractWorkComment;
use App\Models\Campaign;
use App\Models\CampaignInfluencer;
use App\Models\CampaignComment;
use App\Models\Rating;
use App\Models\FavoriteInfluencer;
use App\Models\Product;
use App\Models\BankDetail;
use App\Models\Paypal;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpEmail;
use Illuminate\Support\Facades\Storage;
use App\Models\LearnSwayitCategory;
use App\Models\LearnSwayitTutorial;
use Stripe\Stripe;
use Stripe\Charge;

class BusinessController extends Controller
{
    public function dashboard(Request $request) 
    {
        $user = Auth::user();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $contracts = Contract::where('person_one', $user->id)->pluck('person_two');

        $totalhiredInfluencers = User::where('user_role', 'influencer')->where('role_id', '3')->whereIn('id', $contracts)->count();

        $contractsfCurrentMonth = Contract::where('person_one', $user->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->pluck('person_two');
            
        $hiredInfluencersofCurrentMonth = User::where('user_role', 'influencer')->where('role_id', '3')->whereIn('id', $contractsfCurrentMonth)->count();

        $totalCampaign = Campaign::where('user_id', $user->id)->count();
        $ongoingCampaign = Campaign::where('user_id', $user->id)->where('status', null)->count();

        $totalBid = Bid::where('user_id', $user->id)->where('status', null)->count();
        $currentMonthBid = Bid::where('user_id', $user->id)
            ->where('status', null)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $openBids = Bid::where('user_id', $user->id)->where('status', null)->orderBy('id', 'desc')->get()->take(2);

        $topInfluencers = User::where('user_role', 'influencer')->where('role_id', '3')->get();
        return view('business.dashboard', compact('user', 'totalhiredInfluencers', 'hiredInfluencersofCurrentMonth', 'totalCampaign', 'ongoingCampaign', 'totalBid', 'currentMonthBid', 'openBids', 'topInfluencers'));
    }

public function ajaxGigDetails(Request $request)
{
    if (!$request->ajax()) {
        return response()->json(['error' => 'Invalid request'], 400);
    }

    $gig = Gig::find($request->id);

    if (!$gig) {
        return response()->json(['error' => 'Gig not found'], 404);
    }

    return view('business.gig.partials.details_modal', compact('gig'));
}


    public function videoVerification(Request $request) 
    {
        $user = Auth::user();
        return view('business.video_verification', compact('user'));
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

        return redirect()->route('business.edit.profile')->with('success', 'Video Verified Successfully.');
    }

    public function otpVerification(Request $request) 
    {
        $user = Auth::user();
        return view('business.otp_verification', compact('user'));
    }

    public function sendOtp(Request $request)
    {
        $toEmail = "santoshkumarsahoo781@gmail.com";
        $emailOtp = rand(0000, 9999);

        Mail::to($toEmail)->send(new OtpEmail($emailOtp));
    }

    public function gigsList(Request $request)
{
    $industry = Industry::orderBy('id', 'desc')->where('status', null)->get();
    $query = Gig::query();

    $search_title = $request->search_title ?? "";
    if ($search_title) {
        $query->where('title', 'like', '%' . $search_title . '%');
    }

    $search_industry = $request->industry ?? "";
    if ($search_industry) {
        $query->where('industry', $search_industry);
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
    $platformColumns = [];

    foreach ($checkboxes as $checkbox => $column) {
        if ($request->has($checkbox)) {
            $platformColumns[] = $column;
            $checkedCheckboxes[$checkbox] = true;
        } else {
            $checkedCheckboxes[$checkbox] = false;
        }
    }

    if (!empty($platformColumns)) {
        $query->where(function ($q) use ($platformColumns) {
            foreach ($platformColumns as $col) {
                $q->orWhere($col, 1);
            }
        });
    }

    if ($request->price_range) {
        list($min, $max) = explode(';', $request->price_range);
        $query->whereBetween('price', [(float)$min, (float)$max]);
    }

    $order = $request->input('order');
    if ($order) {
        $query->orderBy(DB::raw('CAST(price AS UNSIGNED)'), $order);
    } else {
        $query->orderBy(DB::raw('CAST(price AS UNSIGNED)'), 'desc');
    }

    $gig_list = $query->paginate(20);

    // ✅ Define the missing $channels array
    $channels = [
        'facebook',
        'instagram',
        'youtube',
        'be_real',
        'snapchat',
        'twitter',
        'twitch',
        'tiktok',
        'linkedin',
    ];

    return view('business.gig.gigs_list', compact(
        'gig_list',
        'search_title',
        'checkedCheckboxes',
        'industry',
        'search_industry',
        'channels'
    ));
}



    public function searchInfluencers(Request $request)
{
    return view('business.search_influencers');
}

public function fetchInfluencers(Request $request)
{
    try {
        $q = $request->query('q');

        if (!$q || strlen($q) < 3) {
            return response()->json(['results' => []]);
        }

        $apiKey = config('services.serpapi.key');

        // Construct search query for influencers on IG/TikTok/YT
        $searchQuery = '"' . $q . '" (site:instagram.com OR site:tiktok.com OR site:youtube.com)';

        $response = Http::get('https://serpapi.com/search.json', [
            'engine' => 'google',
            'q' => $searchQuery,
            'location' => 'United States',
            'api_key' => $apiKey,
            't' => now()->timestamp // prevent caching
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

            // Determine platform
            $platform = str_contains($link, 'instagram.com') ? 'Instagram' :
                        (str_contains($link, 'tiktok.com') ? 'TikTok' :
                        (str_contains($link, 'youtube.com') ? 'YouTube' : 'Unknown'));

            // Use platform-specific favicon as a better indicator
           $profileImage = match ($platform) {
    'Instagram' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/1200px-Instagram_logo_2016.svg.png',
    'TikTok' => 'https://upload.wikimedia.org/wikipedia/commons/0/0a/TikTok_logo.svg',
    'YouTube' => 'https://upload.wikimedia.org/wikipedia/commons/b/b8/YouTube_Logo_2017.svg',
    default => 'https://via.placeholder.com/150'
};

            $results[] = [
                'name' => $title,
                'profile_image' => $profileImage,
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


public function gigsDetails($id) 
{
    $user = Auth::user();

    $gig_details = Gig::find($id);
    
    if (!$gig_details) {
        return redirect()->back()->with('error', 'Gig not found!');
    }

    $gig_list = Gig::where('category', $gig_details->category)
                    ->where('id', '!=', $id)
                    ->orderBy('id', 'desc')
                    ->get();

    $influencer_rating = Rating::where('user_id', $user->id)
                                ->where('rating_for', $gig_details->user_id)
                                ->first();

    $total_rating = Rating::where('rating_for', $gig_details->user_id)->count();

    return view('business.gig.gig_details', compact(
        'gig_details', 
        'gig_list', 
        'user', 
        'influencer_rating', 
        'total_rating'
    ));
}



    public function todoList(Request $request) 
    {
        $user = Auth::user();
    
        $task_list = TaskList::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(20);
        return view('business.task_list', compact('task_list', 'user'));
    }

    public function addTask(Request $request) 
    {
        $user = Auth::user();
        $newTask = new TaskList();
        $newTask->user_id = $user->id;
        $newTask->title = $request->title;
        $newTask->status = 0;
        $newTask->save();
        return redirect()->route('business.todo.list')->with('success', 'Task Added Successfully.');
    }

    public function updateTask(Request $request) 
    {
        $updateTask = TaskList::where('id', $request->id)->first();
        if ($updateTask) {
            $updateTask->status = $request->status;
            $updateTask->save();
            return redirect()->route('business.todo.list')->with('success', 'Task Updated Successfully.');
        }
        return redirect()->route('business.todo.list')->with('error', 'Task not found.');
    }

    public function deleteTask(Request $request)
    {
        $task = TaskList::find($request->id);
        if (!$task) {
            return redirect()->route('business.todo.list')->with('error', 'Task not found.');
        }
        $task->delete();
        return redirect()->route('business.todo.list')->with('success', 'Task deleted successfully.');
    }

    public function reviewInfluencer(Request $request)
    {
        $user = Auth::user();

        $existingRating = Rating::where('user_id', $user->id)->where('rating_for', $request->user_id)->first();
    
        if ($existingRating) {
            $existingRating->rating = $request->rating;
            $existingRating->save();
            return response()->json(['success' => 'Rating updated successfully!']);
        } else {
            $newRating = new Rating();
            $newRating->user_id = $user->id;
            $newRating->rating_for = $request->user_id;
            $newRating->rating = $request->rating;
            $newRating->save();
            return response()->json(['success' => 'Rating submitted successfully!']);
        }
    }

    public function ticketList()
    {
        $user = Auth::user();

        $ticket_list = Ticket::where('user_id', $user->id)->orderBy('id', 'desc')->where('status', 1)->get();
        $solved_ticket_list = Ticket::where('user_id', $user->id)->orderBy('id', 'desc')->where('status', null)->get();
        return view('business.ticket.ticket_list', compact('ticket_list', 'user', 'solved_ticket_list'));
    }

    public function createTicket()
    {
        $user = Auth::user();
        return view('business.ticket.add_ticket', compact('user'));
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

        return redirect()->route('business.ticket.list')->with('success', 'Ticket created successfully.');
    }

    public function updateTicket(Request $request) 
    {
        $updateTicket = Ticket::where('id', $request->id)->first();
        $updateTicket->ticket_type = $request->ticket_type;
        $updateTicket->title = $request->title;
        $updateTicket->desc = $request->description;
        $updateTicket->save();

        return redirect()->route('business.ticket.list')->with('success', 'Ticket Updated Successfully.');
    }

    public function deleteTicket(Request $request)
    {
        // dd('hhh');
        $user = Auth::user();
        $ticket = Ticket::find($request->id);
        
        if (!$ticket) {
            return redirect()->route('business.ticket.list')->with('error', 'Ticket not found.');
        }

        $ticket->delete();

        return redirect()->route('business.ticket.list')->with('success', 'Ticket deleted successfully.');
    }

    public function closeTicket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        if ($ticket) {
            $ticket->status = 0;
            $ticket->save();
            return redirect()->route('business.ticket.list')->with('success', 'Ticket closed successfully.');
        }
        return redirect()->route('business.ticket.list')->with('error', 'Ticket not found.');
    }

    public function replyTicket($ticket_id)
    {
        $user = Auth::user();
        $ticket = Ticket::where('ticket_id', $ticket_id)->first();
        if (!$ticket) {
            return redirect()->route('business.reply.ticket')->with('error', 'Ticket not found.');
        }

        $chat_list = TicketChat::where('ticket_id', $ticket->id)->orderBy('created_at', 'asc')->get();
        return view('business.ticket.ticket_view', compact('ticket', 'chat_list', 'user'));
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

        return redirect()->route('business.reply.ticket', $request->user_ticket_id)->with('success', 'Message sent successfully.');
    }

    public function profileView($user_id)
    {
        $authUser = Auth::user();
        $user_details = User::where('id', $user_id)->first();

        $gig_list = Gig::where('user_id', $user_id)->get();

        return view('business.profile', compact('user_details', 'authUser', 'gig_list'));
    }

    public function editProfile(Request $request)
    {
        $user = Auth::user();
        $user_details = User::where('id', $user->id)->first();

        return view('business.edit_profile', compact('user_details'));
    }

   public function updateProfile(Request $request)
{
    $user = Auth::user();
    $updateProfile = User::findOrFail($user->id);

    // Validate first
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string|max:20',
        // validate other fields as needed
    ]);

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

    if ($request->industry === "another") {
        $newIndustry = Industry::create([
            'name' => $request->otherIndustry,
            'status' => 1,
        ]);
        $updateProfile->industry = $newIndustry->id;
    } else {
        $updateProfile->industry = $request->industry;
    }
    $updateProfile->fill($request->only([
        'bio', 'website', 'company', 'username', 'first_name', 'last_name', 'tags',
        'facebook', 'instagram', 'twitter', 'linkedin', 'snapchat', 'tiktok',
        'address', 'city', 'state', 'zip', 'country', 'language', 'about'
    ]));

    $updateProfile->save();

    return redirect()->route('business.edit.profile')->with('success', 'Profile Data Updated successfully.');
}


    public function addBid(Request $request)
    {
        $user = Auth::user();
        $industry = Industry::orderBy('id', 'desc')->where('status', null)->get();

        return view('business.bid.add_bid', compact('industry'));
    }

    public function storeBid(Request $request) 
    {
        $user = Auth::user();

        if($request->file('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachment', 'public');
        } else {
            $attachmentPath = null;
        }

        $addBid = new Bid();
        $addBid->user_id = $user->id;
        $addBid->title = $request->bid_title;
        $addBid->tags = $request->tags;
        $addBid->price = $request->bid_price;
        $addBid->time = $request->delivery_time;
        $addBid->attachment = $attachmentPath;
        $addBid->whole_country = $request->whole_country;
        $addBid->location = $request->location;
        $addBid->industry = $request->industry;
        $addBid->facebook = $request->facebook;
        $addBid->instagram = $request->instagram;
        $addBid->twitter = $request->twitter;
        $addBid->snapchat = $request->snapchat;
        $addBid->linkedin = $request->linkedin;
        $addBid->youtube = $request->youtube;
        $addBid->tiktok = $request->tiktok;
        $addBid->be_real = $request->be_real;
        $addBid->twitch = $request->twitch;
        $addBid->desc = $request->bid_overview;
        $addBid->save();

        $influencer_list = User::where('industry', $user->industry)->whereNot('id', $user->id)->get();

        if($influencer_list) {
            foreach($influencer_list as $influencer) {
                $ntfc_link = 'bid-details/' .$addBid->id;
                $notification = new Notification();
                $notification->user_id = $influencer->id;
                $notification->title = 'New bid posted by ' .$user->first_name. ' ' .$user->last_name;
                $notification->link = $ntfc_link;
                $notification->save();
            }
        }

        return redirect()->route('business.bid.list')->with('success', 'Custom Bid Added Successfully.');
    }

    public function bidList(Request $request)
    {
        $user = Auth::user();
        $industry = Industry::orderBy('id', 'desc')->where('status', null)->get();
        // $bidList = Bid::where('user_id', $user->id)->paginate(10);

        $query = Bid::where('user_id', $user->id)->select('*');

        if (isset($request->search_bid)) {
            $query->where('title', 'like', '%' . $request->search_bid . '%');
            $search_bid = $request->search_bid;
        } else {
            $search_bid = "";
        }

        if (isset($request->industry)) {
            // $searchedIndustry = Industry::where('id', $request->industry)->first();
            $query->where('industry', $request->industry);
            $search_industry = $request->industry;
        } else {
            $search_industry = "";
        }

        if (isset($request->search_location)) {
            $query->where('location', 'like', '%' . $request->search_location . '%');
            $search_location = $request->search_location;
        } else {
            $search_location = "";
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

        $price_range = $request->price_range;

        if (isset($price_range)) {
            list($min, $max) = explode(';', $price_range);
        
            $query->whereBetween("price", [$min, $max]);
        }

        // $bidList = $query->orderBy('id', 'desc')->paginate(20)->appends($request->except('page'));
        $bidList = (clone $query)->where('status', null)->orderBy('id', 'desc')->get();
        $closeBidList = (clone $query)->where('status', 1)->orderBy('id', 'desc')->get();        

        return view('business.bid.bid_list', compact('bidList', 'closeBidList', 'search_bid', 'search_location', 'checkedCheckboxes', 'industry', 'search_industry'));
    }

    public function bidDetails($id)
    {
        $user = Auth::user();
        $bidDetails = Bid::where('id', $id)->first();
        $bid_proposals = BidProposal::where('bid_id', $id)->where('receiver_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('business.bid.bid_details', compact('bidDetails', 'bid_proposals'));
    }

    public function bidProposals(Request $request)
    {
        $user = Auth::user();
        $bid_proposals = BidProposal::where('receiver_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('business.bid.bid_proposals', compact('bid_proposals'));
    }

    public function editBid($id)
    {
        $user = Auth::user();
        $bidDetails = Bid::where('id', $id)->first();
        $industry = Industry::orderBy('id', 'desc')->where('status', null)->get();

        return view('business.bid.edit_bid', compact('bidDetails', 'industry'));
    }

    public function updateBid(Request $request) 
    {
        $user = Auth::user();

        $updateBid = Bid::where('id', $request->bid_id)->first();
        $updateBid->user_id = $user->id;
        $updateBid->title = $request->bid_title;
        $updateBid->tags = $request->tags;
        $updateBid->price = $request->bid_price;
        $updateBid->time = $request->delivery_time;
        $updateBid->whole_country = $request->whole_country;
        $updateBid->location = $request->location;
        $updateBid->industry = $request->industry;
        $updateBid->facebook = $request->facebook;
        $updateBid->instagram = $request->instagram;
        $updateBid->twitter = $request->twitter;
        $updateBid->snapchat = $request->snapchat;
        $updateBid->linkedin = $request->linkedin;
        $updateBid->youtube = $request->youtube;
        $updateBid->tiktok = $request->tiktok;
        $updateBid->be_real = $request->be_real;
        $updateBid->twitch = $request->twitch;
        $updateBid->desc = $request->bid_overview;
        $updateBid->save();

        return redirect()->route('business.bid.details', $request->bid_id)->with('success', 'Custom Bid Updated Successfully.');
    }

    public function closeBid(Request $request) 
    {
        $user = Auth::user();

        $updateBid = Bid::where('id', $request->bid_id)->first();
        $updateBid->status = 1;
        $updateBid->save();

        return redirect()->route('business.bid.list')->with('success', 'Custom Bid Closed Successfully.');
    }

    public function openBid(Request $request) 
    {
        $user = Auth::user();

        $updateBid = Bid::where('id', $request->bid_id)->first();
        $updateBid->status = null;
        $updateBid->save();

        return redirect()->back()->with('success', 'Custom Bid Opened Successfully.');
    }

    public function deleteBid(Request $request)
    {
        $user = Auth::user();
        $bid = Bid::find($request->id);

        $bid->delete();

        return redirect()->route('business.bid.list')->with('success', 'Custom Bid deleted successfully.');
    }

    public function acceptBid(Request $request)
    {
        Stripe::setApiKey('***REMOVED***');

        try {
            // Create a charge
            $charge = Charge::create([
                'amount' => $request->amount * 100, // Amount in cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Test payment',
            ]);


            $user = Auth::user();
            $bid_proposal = BidProposal::where('id', $request->id)->first();
            $bid_proposal->status = 1;
            $bid_proposal->save();
    
            $bid = Bid::where('id', $bid_proposal->bid_id)->first();
            
            $timestamp = Carbon::now()->format('dmyHis');
            $transactionId = 'SWBI'.$user->id.''.$timestamp;
    
            $add_transaction = new Transaction();
            $add_transaction->business_id = $user->id;
            $add_transaction->influencer_id = $bid_proposal->sender_id;
            $add_transaction->type = "Bid";
            $add_transaction->details = "Bid accepted, Title - " .$bid->title;
            $add_transaction->transaction_id = $transactionId;
            $add_transaction->amount = $request->amount;
            $add_transaction->save();    

            $paymentRequest = new PaymentRequest();
            $paymentRequest->made_by = $user->id;
            $paymentRequest->payment_to = $bid_proposal->sender_id;
            $paymentRequest->amount = $request->amount;
            $paymentRequest->bid_proposal_id = $request->id;
            $paymentRequest->save();

            $notification = new Notification();
            $notification->user_id = $bid_proposal->sender_id;
            $notification->title = $user->first_name. ' ' .$user->last_name. ' accepted your bid proposal.';
            $notification->link = 'bid-details/'. $bid->id;
            $notification->save();
            
            return redirect()->back()->with('success', 'Payment Successfull.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function declineBid(Request $request)
    {
        $user = Auth::user();
        $bid_proposal = BidProposal::where('id', $request->id)->first();
        $bid_proposal->status = 2;
        $bid_proposal->save();

        // $sendMessage = new UserMessage();
        // $sendMessage->sender_id = $user->id;
        // $sendMessage->receiver_id = $request->receiver_id;
        // $sendMessage->message = "<p>Your proposal is declined.</p>";
        // $sendMessage->save();

        return redirect()->back()->with('success', 'User proposal Declined.');
    }

    // public function bidChat($proposal_id)
    // {
    //     $user = Auth::user();

    //     $bid_proposal = BidProposal::where('id', $proposal_id)->first();
    //     // dd($bid_proposal);
    //     $bid_messages = BidMessage::where('proposal_id', $proposal_id)->orderBy('created_at', 'asc')->get();
    //     $sender = User::where('id', $bid_proposal->sender_id)->first();

    //     return view('business.bid_chat', compact('sender', 'bid_messages', 'user', 'bid_proposal'));
    // }

    public function sendBidMessage(Request $request)
    {
        $user = Auth::user();

        $send_message = new BidMessage();
        $send_message->sender_id = $user->id;
        $send_message->receiver_id = $request->receiver_id;
        $send_message->proposal_id = $request->proposal_id;
        $send_message->message = $request->message;
        $send_message->save();

        return redirect()->route('business.bid.chat', $request->proposal_id);
    }

    public function gigCheckout($id)
    {
        $user = Auth::user();
        $gig_details = Gig::where('id', $id)->first();

        return view('business.gig.gigs_checkout', compact('user', 'gig_details'));
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon', $request->coupon)->first();

        if ($coupon) {
            $discount = $coupon->discount / 100;
            
            $gigPrice = $request->price;
            $discountedPrice = $gigPrice - ($gigPrice * $discount);

            return response()->json([
                'success' => true,
                'message' => 'Coupon code applied!',
                'discounted_price' => number_format($discountedPrice, 2)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid coupon code!', 'discounted_price' => number_format($request->price, 2)]);
    }

    public function processPayment(Request $request)
    {
        // $request->validate([
        //     'card_name' => 'required|string',
        //     'card_number' => 'required|digits:16',
        //     'cvc' => 'required|digits:3',
        //     'exp_month' => 'required|numeric|min:1|max:12',
        //     'exp_year' => 'required|numeric|min:' . date('Y')
        // ]);

        // Stripe::setApiKey(config('services.stripe.secret'));
        Stripe::setApiKey('***REMOVED***');

        try {
            // Create a charge
            $charge = Charge::create([
                'amount' => $request->amount * 100, // Amount in cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Test payment',
            ]);

            return back()->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function gigBillSubmit(Request $request)
    {
        Stripe::setApiKey('***REMOVED***');

        try {
            // Create a charge
            $charge = Charge::create([
                'amount' => $request->amount * 100, // Amount in cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Test payment',
            ]);


            $user = Auth::user();

            $addBill = new GigCheckout();
            $addBill->user_id = $user->id;
            $addBill->gig_id = $request->gig_id;
            $addBill->first_name = $request->first_name;
            $addBill->last_name = $request->last_name;
            $addBill->phone = $request->phone;
            $addBill->email = $request->email;
            $addBill->address = $request->address;
            $addBill->city = $request->city;
            $addBill->state = $request->state;
            $addBill->zip = $request->zip;
            $addBill->country = $request->country;
            $addBill->subtotal = $request->amount;
            $addBill->save();
    
            $gigDetails = Gig::where('id', $request->gig_id)->first();
            $timestamp = Carbon::now()->format('dmyHis');
            $transactionId = 'SWBI'.$user->id.''.$timestamp;
    
            $add_transaction = new Transaction();
            $add_transaction->business_id = $user->id;
            $add_transaction->influencer_id = $gigDetails->user_id;
            $add_transaction->type = "Gig";
            $add_transaction->details = "Gig purchased, Title - " .$gigDetails->title;
            $add_transaction->transaction_id = $transactionId;
            $add_transaction->amount = $request->amount;
            $add_transaction->save();
    
            $add_order = new GigOrder();
            $add_order->business_id = $user->id;
            $add_order->influencer_id = $gigDetails->user_id;
            $add_order->gig_id = $request->gig_id;
            $add_order->save();

            $paymentRequest = new PaymentRequest();
            $paymentRequest->made_by = $user->id;
            $paymentRequest->payment_to = $gigDetails->user_id;
            $paymentRequest->amount = $request->amount;
            $paymentRequest->gig_order_id = $add_order->id;
            $paymentRequest->save();
    
            $notification = new Notification();
            $notification->user_id = $gigDetails->user_id;
            $notification->title = $user->first_name. ' ' .$user->last_name. ' purchased your gig.';
            $notification->link = 'gig-order';
            $notification->save();
            
            // return back()->with('success', 'Payment successful!');
            return redirect()->route('business.gig.invoice', $addBill->id)->with('success', 'Gig purchased successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        // return view('business.gigs_invoice');
        // return redirect()->route('business.gig.invoice', $addBill->id)->with('success', 'Gig purchased successfully.');
    }

    public function gigInvoice($bill_id)
    {
        $user = Auth::user();
        $billInvoice = GigCheckout::where('id', $bill_id)->first();
        $gig_details = Gig::where('id', $billInvoice->gig_id)->first();

        return view('business.gig.gigs_invoice', compact('user', 'billInvoice', 'gig_details'));
    }

    public function printGigInvoice($bill_id)
    {
        $user = Auth::user();
        $billInvoice = GigCheckout::where('id', $bill_id)->first();
        $gig_details = Gig::where('id', $billInvoice->gig_id)->first();

        return view('business.gig.print_gigs_invoice', compact('user', 'billInvoice', 'gig_details'));
    }

    public function gigsOrder(Request $request)
    {
        $user = Auth::user();
        $gigs_order = GigOrder::where('business_id', $user->id)->get();

        return view('business.gig.gig_orders', compact('user', 'gigs_order'));
    }

    public function gigsOrderStatus($order_id)
    {
        $user = Auth::user();
        $gigs_order = GigOrder::where('id', $order_id)->first();
        $work_status = GigOrderWork::where('gig_order_id', $gigs_order->id)->orderBy('id', 'asc')->get();
        $work_status_count = GigOrderWork::where('gig_order_id', $gigs_order->id)->count();

        return view('business.gig.gig_order_status', compact('gigs_order', 'work_status', 'user', 'work_status_count'));
    }

    public function acceptGigStatus(Request $request)
    {
        $user = Auth::user();

        $updateGigOrder = GigOrderWork::where('gig_order_id', $request->order_id)->get();
        foreach($updateGigOrder as $ord) {
            $ord->status = 1;
            $ord->save();
        }

        $postStatus = new GigOrderWork();
        $postStatus->gig_order_id = $request->order_id;
        $postStatus->sender_id = $user->id;
        $postStatus->receiver_id = $request->receiver_id;
        $postStatus->message = "Your work is approved.";
        $postStatus->status = 1;
        $postStatus->save();
        
        $gigs_order = GigOrder::where('id', $request->order_id)->first();
        $gigs_order->status = 1;
        $gigs_order->approval_status = 1;
        $gigs_order->save();

        $gig_checkout = GigCheckout::where('gig_id', $gigs_order->gig_id)->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();

        $paymentRequest = PaymentRequest::where('gig_order_id', $request->order_id)->where('made_by', $user->id)->first();
        $paymentRequest->status = 1;
        $paymentRequest->save();

        $notification = new Notification();
        $notification->user_id = $request->receiver_id;
        $notification->title = $user->first_name. ' ' .$user->last_name. ' accepted the gig order work status.';
        $notification->link = 'gig-order-status/'.$request->order_id;
        $notification->save();

        return redirect()->route('business.gig.order.status', $request->order_id)->with('success', 'You have approved the work status.');
    }

    public function declineGigStatus(Request $request)
    {
        $user = Auth::user();

        $updateGigOrder = GigOrderWork::where('gig_order_id', $request->order_id)->get();
        foreach($updateGigOrder as $ord) {
            $ord->status = 1;
            $ord->save();
        }

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
        $postStatus->status = 1;
        $postStatus->save();
        
        $gigs_order = GigOrder::where('id', $request->order_id)->first();
        $gigs_order->approval_status = 2;
        $gigs_order->save();

        $notification = new Notification();
        $notification->user_id = $request->receiver_id;
        $notification->title = $user->first_name. ' ' .$user->last_name. ' declined the gig order work status.';
        $notification->link = 'gig-order-status/'.$request->order_id;
        $notification->save();

        return redirect()->route('business.gig.order.status', $request->order_id)->with('success', 'Work is declined & message sent to influencer.');
    }

    public function gigsCart(Request $request)
    {
        $user = Auth::user();
        $cartItems = GigCart::where('user_id', $user->id)->get();

        return view('business.gig.cart', compact('cartItems', 'user'));
    }

   public function addGigCart(Request $request)
{
    $user = Auth::user();
    $existCartItems = GigCart::where('user_id', $user->id)->where('gig_id', $request->gig_id)->first();

    if($existCartItems) {
        $cartCount = GigCart::where('user_id', $user->id)->whereNull('status')->count();
        return response()->json([
            'success' => true,
            'message' => 'Gigs already added in Cart.',
            'cart_count' => $cartCount
        ]);
    } else {
        $cartItems = new GigCart();
        $cartItems->user_id = $user->id;
        $cartItems->gig_id = $request->gig_id;
        $cartItems->save();

        $cartCount = GigCart::where('user_id', $user->id)->whereNull('status')->count();

        return response()->json([
            'success' => true,
            'message' => 'Gigs added to Cart.',
            'cart_count' => $cartCount
        ]);            
    }
}


    public function removeGigCart(Request $request)
    {
        $existCartItems = GigCart::where('id', $request->gig_cart_id)->first();
        $existCartItems->delete();

        return redirect()->back()->with('success', 'Gig removed from Cart.');
    }

    public function purchaseGigCart(Request $request)
    {
        $user = Auth::user();
        // dd($request->cart_gigs);

        $cartItems = json_decode($request->cart_gigs, true);
        if($cartItems) {
        foreach($cartItems as $items) {
            
            $gigDetails = Gig::where('id', $items['gig_id'])->first();

            $addBill = new GigCheckout();
            $addBill->user_id = $user->id;
            $addBill->gig_id = $items['gig_id'];
            $addBill->first_name = $request->first_name;
            $addBill->last_name = $request->last_name;
            $addBill->phone = $request->phone;
            $addBill->email = $request->email;
            $addBill->address = $request->address;
            $addBill->city = $request->city;
            $addBill->state = $request->state;
            $addBill->zip = $request->zip;
            $addBill->country = $request->country;
            $addBill->subtotal = $gigDetails->price;
            $addBill->save();

            $timestamp = Carbon::now()->format('dmyHis');
            $randomNumber = rand(1000, 9999);
            $transactionId = 'SWBI'.$user->id.''.$timestamp.''.$randomNumber;

            $add_transaction = new Transaction();
            $add_transaction->business_id = $user->id;
            $add_transaction->influencer_id = $gigDetails->user_id;
            $add_transaction->type = "Paid";
            $add_transaction->details = "Gig purchased, Title - " .$gigDetails->title;
            $add_transaction->transaction_id = $transactionId;
            $add_transaction->amount = $gigDetails->price;
            $add_transaction->save();

            $addEscrow = new EscrowPayment();
            $addEscrow->payment_by = $user->id;
            $addEscrow->payment_to = $gigDetails->user_id;
            $addEscrow->amount = $gigDetails->price;
            $addEscrow->details = "Gig purchased, Title - " .$gigDetails->title;
            $addEscrow->save();

            $add_transaction = new GigOrder();
            $add_transaction->business_id = $user->id;
            $add_transaction->influencer_id = $gigDetails->user_id;
            $add_transaction->gig_id = $items['gig_id'];
            $add_transaction->save();

            $notification = new Notification();
            $notification->user_id = $gigDetails->user_id;
            $notification->title = $user->first_name. ' ' .$user->last_name. ' purchased your gig.';
            $notification->link = 'gig-order';
            $notification->save();

            
            $existCartItems = GigCart::where('id', $items['id'])->first();
            $existCartItems->delete();
        }

        return redirect()->route('business.gigs.list')->with('success', 'Gig purchased successfully.');
        }
    }

    public function replyBid(Request $request)
    {
        $user = Auth::user();

        $bidMessage = new UserMessage();
        $bidMessage->sender_id = $user->id;
        $bidMessage->receiver_id = $request->receiver_id;
        $bidMessage->message = $request->description;
        $bidMessage->save();

        return redirect()->route('business.chat');
    }

    public function startChat(Request $request) 
    {
        $current_user = Auth::user();

        $startMessage = new UserMessage();
        $startMessage->sender_id = $current_user->id;
        $startMessage->receiver_id = $request->receiver_id;
        $startMessage->message = null;
        $startMessage->save();

        return redirect()->route('business.chat.message', $request->receiver_id);
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
        return view('business.chat.chat', compact('current_user', 'user_ids', 'userChat'));
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
                'status' => 'success'
            ]);
        }

        return view('business.chat.chat', compact('current_user', 'userChat', 'user_ids'));
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        // if($request->file('chat_attachment')) {
        //     $attachmentPath = $request->file('chat_attachment')->store('chat_attachment', 'public');
        // } else {
        //     $attachmentPath = null;
        // }
        if ($request->file('chat_attachment')) {
            $file = $request->file('chat_attachment');
            $attachmentPath = $file->store('chat_attachment', 'public');
            $attachmentName = $file->getClientOriginalName();
        } else {
            $attachmentPath = null;
            $attachmentName = null;
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
        return view('business.chat.message', compact('user_messages', 'user', 'current_user'))->render();
    }

    // public function sendGigMessage(Request $request)
    // {
    //     $user = Auth::user();

    //     $send_message = new UserMessage();
    //     $send_message->sender_id = $user->id;
    //     $send_message->receiver_id = $request->receiver_id;
    //     $send_message->message = "Hello, this is " .$user->first_name. ' ' .$user->last_name;
    //     $send_message->save();

    //     return redirect()->route('business.chat');
    // }

    public function socialPost(Request $request)
    {
        $user = Auth::user();

        return view('business.social_post');
    }

    public function contractList(Request $request)
    {
        $user = Auth::user();
        $contract_list = Contract::where('person_one', $user->id)->orderBy('created_at', 'desc')->get();

        return view('business.contract.contract_list', compact('contract_list'));
    }

    public function createContract($bid_proposal_id)
    {
        $bid_proposal = BidProposal::where('id', $bid_proposal_id)->first();
        $business = User::where('id', $bid_proposal->receiver_id)->first();
        $influencer = User::where('id', $bid_proposal->sender_id)->first();
        return view('business.contract.create_contract', compact('business', 'influencer', 'bid_proposal'));
    }

    public function createDefaultContract(Request $request)
    {
        $user = Auth::user();
        $ipAddress = $request->ip();

        $contract = new Contract();

        $contract->person_one = $request->business;
        $contract->person_two = $request->influencer;
        $contract->bid_id = $request->bid_id;
        $contract->business_name = $request->business_name;
        $contract->business_email = $request->business_email;
        $contract->business_phone = $request->business_phone;
        $contract->business_website = $request->business_website;
        $contract->influencer_name = $request->influencer_name;
        $contract->influencer_email = $request->influencer_email;
        $contract->influencer_phone = $request->influencer_phone;
        $contract->influencer_website = $request->influencer_website;
        $contract->title = $request->title;
        $contract->content = $request->content;
        $contract->ship_status = $request->ship_check;
        $contract->return_shipping_address = $request->shipping_address;
        $contract->return_shipping_city = $request->city;
        $contract->return_shipping_state = $request->state;
        $contract->return_shipping_zip = $request->zip;
        $contract->return_shipping_country = $request->country;
        $contract->person_one_agree = $request->contract_accept_checkbox;
        $contract->business_ip_address = $ipAddress;
        $contract->save();

        return redirect()->route('business.contract.list')->with('success', 'Contract created successfully.');
    }

    public function updateContract(Request $request)
    {
        $user = Auth::user();
        $ipAddress = $request->ip();

        $contract = Contract::where('id', $request->contract_id)->first();

        $contract->business_name = $request->business_name;
        $contract->business_email = $request->business_email;
        $contract->business_phone = $request->business_phone;
        $contract->business_website = $request->business_website;
        $contract->influencer_name = $request->influencer_name;
        $contract->influencer_email = $request->influencer_email;
        $contract->influencer_phone = $request->influencer_phone;
        $contract->influencer_website = $request->influencer_website;
        $contract->title = $request->title;
        $contract->content = $request->content;
        $contract->ship_status = $request->ship_check;
        $contract->return_shipping_address = $request->shipping_address;
        $contract->return_shipping_city = $request->city;
        $contract->return_shipping_state = $request->state;
        $contract->return_shipping_zip = $request->zip;
        $contract->return_shipping_country = $request->country;
        $contract->person_one_agree = $request->contract_accept_checkbox;
        $contract->business_ip_address = $ipAddress;
        $contract->save();

        return redirect()->route('business.contract.list')->with('success', 'Contract updated successfully.');
    }

    public function makeContract(Request $request, $contract_id)
    {
        $user = Auth::user();
        $contract = Contract::where('id', $contract_id)->first();
        $business = User::where('id', $contract->person_one)->first();
        $influencer = User::where('id', $contract->person_two)->first();

        return view('business.contract.make_contract', compact('contract', 'business', 'influencer'));
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

                $contract->person_one_signature = $contractSignPath;
                $contract->status = 1;
                $contract->save();

                return redirect()->route('business.make.contract', $request->contract_id)->with('success', 'Signature updated successfully.');
            } elseif($request->hasFile('signature_image')) {
                $contractSign = $request->file('signature_image')->store('contract_sign', 'public');
                $contract->person_one_signature = $contractSign;
                $contract->status = 1;
                $contract->save();

                return redirect()->route('business.make.contract', $request->contract_id)->with('success', 'Signature updated successfully.');
            } else {
                return redirect()->route('business.make.contract', $request->contract_id)->with('error', 'Please upload signature.');
            }
        } else {
            $bid_proposal = BidProposal::where('id', $request->proposal_id)->first();
            $bid_proposal->status = 1;
            $bid_proposal->save();

            $contract = new Contract();
            
            if($request->signature_pad_image) {
                $base64String = $request->signature_pad_image;
                $imageData = substr($base64String, strpos($base64String, ',') + 1);
                $image = base64_decode($imageData);
                $fileName = 'contract_signature_' . uniqid() . '.png';
                $contractSignPath = 'contract_sign/' . $fileName;

                Storage::disk('public')->put($contractSignPath, $image);

                $contract->person_one_signature = $contractSignPath;
                $contract->title = $request->title;
                $contract->content = $request->content;
                $contract->person_one = $request->person_one;
                $contract->person_two = $request->person_two;
                $contract->bid_id = $request->bid_id;
                $contract->status = 1;
                $contract->save();

                return redirect()->route('business.make.contract', $contract->id)->with('success', 'Signature updated successfully.');
            } elseif($request->hasFile('signature_image')) {
                $contractSign = $request->file('signature_image')->store('contract_sign', 'public');
                $contract->person_one_signature = $contractSign;
                $contract->title = $request->title;
                $contract->content = $request->content;
                $contract->person_one = $request->person_one;
                $contract->person_two = $request->person_two;
                $contract->bid_id = $request->bid_id;
                $contract->status = 1;
                $contract->save();

                return redirect()->route('business.make.contract', $contract->id)->with('success', 'Signature updated successfully.');
            } else {
                return redirect()->route('business.make.contract', $contract->id)->with('error', 'Please upload signature.');
            }
        }
    }

    public function downloadContrant(Request $request, $contract_id)
    {
        $user = Auth::user();
        $contract = Contract::where('id', $contract_id)->first();
        $personOne = User::where('id', $contract->person_one)->first();
        $personTwo = User::where('id', $contract->person_two)->first();

        return view('business.contract.download_contract', compact('contract', 'personOne', 'personTwo'));
    }

    public function storeContract(Request $request)
    {
        $user = Auth::user();

        $contract = Contract::where('id', $request->contract_id)->first();

        $contract->ship_status = $request->ship_check;
        $contract->return_shipping_address = $request->shipping_address;
        $contract->return_shipping_city = $request->city;
        $contract->return_shipping_state = $request->state;
        $contract->return_shipping_zip = $request->zip;
        $contract->return_shipping_country = $request->country;
        if($contract->status == 1) {
            $contract->status = 2;
        } else {
            $contract->status = 1;
        }
        $contract->person_one_agree = $request->contract_accept_checkbox;
        $contract->save();

        $notification = new Notification();
        $notification->user_id = $contract->person_two;
        $notification->title = $user->first_name. ' ' .$user->last_name. ' want to make contract with you.';
        $notification->link = 'make-contract/'.$contract->id;
        $notification->save();

        return redirect()->route('business.contract.list')->with('success', 'Contract submitted successfully.');
    }

    public function contractWorkstatus(Request $request, $contract_id)
    {
        $user = Auth::user();
        $contractDetails = Contract::where('id', $contract_id)->first();

        $contractComments = ContractWorkComment::where('contract_id', $contract_id)->get();
        $bidProposals = BidProposal::where('bid_id', $contractDetails->bid_id)->where('sender_id', $contractDetails->person_two)->first();
        $work_status_count = ContractWorkComment::where('contract_id', $contract_id)->count();

        return view('business.contract.contract_work_status', compact('contractComments', 'user', 'bidProposals', 'contractDetails', 'work_status_count'));
    }

    public function declineContractStatus(Request $request)
    {
        $user = Auth::user();

        $addComment = new ContractWorkComment();
        $addComment->contract_id = $request->contract_id;
        $addComment->bid_id = $request->bid_id;
        $addComment->sender_id = $user->id;
        $addComment->receiver_id = $request->sender_id;
        $addComment->message = $request->message;
        $addComment->save();

        $bidProposal = BidProposal::where('bid_id', $request->bid_id)->where('sender_id', $request->sender_id)->first();
        $bidProposal->work_status = 2;
        $bidProposal->save();

        return redirect()->route('business.contract.workstatus', $request->contract_id)->with('success', 'Request declined and changes sent.');
    }

    public function acceptContractStatus(Request $request)
    {            
        $user = Auth::user();

        $bidProposal = BidProposal::where('bid_id', $request->bid_id)->where('sender_id', $request->sender_id)->first();
        $bidProposal->work_status = 1;
        $bidProposal->save();        

        $bidDetails = Bid::where('id', $request->bid_id)->first();

        $paymentRequest = PaymentRequest::where('bid_proposal_id', $bidProposal->id)->where('made_by', $user->id)->first();
        $paymentRequest->status = 1;
        $paymentRequest->save();

        $notification = new Notification();
        $notification->user_id = $request->sender_id;
        $notification->title = $user->first_name. ' ' .$user->last_name. ' accepted your request.';
        $notification->link = 'contract-work-status/'.$request->contract_id;
        $notification->save();

        return redirect()->route('business.contract.workstatus', $request->contract_id)->with('success', 'Contract Work Accepted.');
    }

    public function compareGigs(Request $request)
    {
        $gig_ids = $request->input('select_gig', []);
        $gigs_list = Gig::whereIn('id', $gig_ids)->get();
        return view('business.compare_gigs', compact('gigs_list'));
    }

    public function compareInfluencer(Request $request)
    {
        $inflr_ids = $request->input('select_inflr', []);
        $influencer_list = User::whereIn('id', $inflr_ids)->get();
        return view('business.compare_influencer', compact('influencer_list'));
    }

    // public function getGigsForCompare(Request $request)
    // {
    //     $gigs_list = $request->all();
    //     return view('business.compare_influencer', compact('gigs_list'));
    // }

    public function influencerList(Request $request)
    {
        $user = Auth::user();

        $query = User::where('user_role', 'influencer')->where('role_id', '3');

        if (isset($request->search_name)) {
            $query->where('first_name', 'like', '%' . $request->search_name . '%');
            $search_name = $request->search_name;
        } else {
            $search_name = "";
        }

        if (isset($request->search_name)) {
            $query->orWhere('last_name', 'like', '%' . $request->search_name . '%');
            $search_name = $request->search_name;
        } else {
            $search_name = "";
        }
        
        if (isset($request->search_skill)) {
            $query->where('bio', 'like', '%' . $request->search_skill . '%');
            $search_skill = $request->search_skill;
        } else {
            $search_skill = "";
        }

        $influencer_list = $query->orderBy('id', 'desc')->paginate(20)->appends($request->except('page'));

        return view('business.influencers.influencer_list', compact('influencer_list', 'search_name', 'search_skill', 'user'));
    }

    public function addFavoriteInfluencer(Request $request)
    {
        $user = Auth::user();
        $influencerId = $request->influencer_id;
    
        $favorite = FavoriteInfluencer::where('user_id', $user->id)->first();
        
        if (!$favorite) {
            $addFavorite = new FavoriteInfluencer();
            $addFavorite->user_id = $user->id;
            $addFavorite->influencer_id = json_encode([$influencerId]);
            $addFavorite->save();
        } else {
            $existingFav = json_decode($favorite->influencer_id, true) ?? [];
            if (!in_array($influencerId, $existingFav)) {
                $existingFav[] = $influencerId;
                $favorite->influencer_id = json_encode($existingFav);
                $favorite->save();
            }
        }
    
        return response()->json(['success' => true, 'message' => 'Added to favorites.']);
    }

    public function removeFavoriteInfluencer(Request $request)
    {
        $user = Auth::user();
        $influencerId = $request->influencer_id;
    
        $favorite = FavoriteInfluencer::where('user_id', $user->id)->first();
        
        if ($favorite) {
            $existingFav = json_decode($favorite->influencer_id, true) ?? [];

            if (in_array($influencerId, $existingFav)) {
                $updatedFav = array_diff($existingFav, [$influencerId]);

                // if (empty($updatedFav)) {
                //     $favorite->delete();
                // } else {
                    $favorite->influencer_id = json_encode(array_values($updatedFav));
                    $favorite->save();
                // }
            }
        }
    
        return response()->json(['success' => true, 'message' => 'Removed from favorites.']);
    }
    

    public function favoriteInfluencers(Request $request)
    {
        $user = Auth::user();
        $fav_influencer_list = FavoriteInfluencer::where('user_id', $user->id)->first();

        if($fav_influencer_list) {
            $fav_influencer = json_decode($fav_influencer_list->influencer_id, true) ?? [];
        } else {
            $fav_influencer = [];
        }

        $query = User::where('user_role', 'influencer')->where('role_id', '3')->whereIn('id', $fav_influencer);

        if (isset($request->search_name)) {
            $query->where('first_name', 'like', '%' . $request->search_name . '%');
            $search_name = $request->search_name;
        } else {
            $search_name = "";
        }

        if (isset($request->search_name)) {
            $query->orWhere('last_name', 'like', '%' . $request->search_name . '%');
            $search_name = $request->search_name;
        } else {
            $search_name = "";
        }
        
        if (isset($request->search_skill)) {
            $query->where('bio', 'like', '%' . $request->search_skill . '%');
            $search_skill = $request->search_skill;
        } else {
            $search_skill = "";
        }

        $influencer_list = $query->orderBy('id', 'desc')->paginate(20)->appends($request->except('page'));

        return view('business.influencers.favorite_influencer', compact('influencer_list', 'search_name', 'search_skill'));
    }

    public function hiredInfluencers(Request $request)
    {
        $user = Auth::user();
        $contracts = Contract::where('person_one', $user->id)->pluck('person_two');

        $query = User::where('user_role', 'influencer')->where('role_id', '3')->whereIn('id', $contracts);

        if (isset($request->search_name)) {
            $query->where('first_name', 'like', '%' . $request->search_name . '%');
            $search_name = $request->search_name;
        } else {
            $search_name = "";
        }

        if (isset($request->search_name)) {
            $query->orWhere('last_name', 'like', '%' . $request->search_name . '%');
            $search_name = $request->search_name;
        } else {
            $search_name = "";
        }
        
        if (isset($request->search_skill)) {
            $query->where('bio', 'like', '%' . $request->search_skill . '%');
            $search_skill = $request->search_skill;
        } else {
            $search_skill = "";
        }

        $influencer_list = $query->orderBy('id', 'desc')->paginate(20)->appends($request->except('page'));

        return view('business.influencers.hired_influencer', compact('influencer_list', 'search_name', 'search_skill'));
    }

    public function createCampaign(Request $request)
    {
        $influencers = User::where('user_role', 'influencer')->where('role_id', '3')->get();

        return view('business.campaign.create_campaign', compact('influencers'));
    }

    public function storeCampaign(Request $request)
    {
        $user = Auth::user();
        // dd($request->all());

        if($request->file('attachment')) {
            $attachmentPath = $request->file('attachment')->store('campaign_attachment', 'public');
        } else {
            $attachmentPath = null;
        }
        $influencers = $request->influencer_id;

        $addCampaign = new Campaign();
        $addCampaign->user_id = $user->id;
        $addCampaign->name = $request->name;
        $addCampaign->start_date = $request->start_date;
        $addCampaign->end_date = $request->end_date;
        $addCampaign->objectives = $request->objectives;
        $addCampaign->attachment = $attachmentPath;
        if($influencers) {
            $addCampaign->camp_status = 2;
        } else {
            $addCampaign->camp_status = 1;
        }
        $addCampaign->save();

        if($influencers) {
            foreach($influencers as $inf) {
                $addCampInfl = new CampaignInfluencer();
                $addCampInfl->user_id = $user->id;
                $addCampInfl->campaign_id = $addCampaign->id;
                $addCampInfl->influencer_id = $inf;
                $addCampInfl->save();

                $sendNotification = new Notification();
                $sendNotification->user_id = $inf;
                $sendNotification->title = $user->first_name. ' ' .$user->last_name. " added you in a campaign.";
                $sendNotification->link = 'campaign-list';
                $sendNotification->save();
            }
        }

        return redirect()->route('business.campaign.list')->with('success', 'Campaign created successfully.');
    }

    public function campaignList(Request $request)
    {
        $current_user = Auth::user();

        $campaign_list = Campaign::where('user_id', $current_user->id)->get();
        return view('business.campaign.campaign_list', compact('campaign_list', 'current_user'));
    }

    public function campaignView($campaign_id)
    {
        $user = Auth::user();
        $campaignDetails = Campaign::where('id', $campaign_id)->first();

        $influencers_list = CampaignInfluencer::where('campaign_id', $campaignDetails->id)->where('user_id', $user->id)->get();

        return view('business.campaign.campaign_details', compact('campaignDetails', 'influencers_list', 'user'));
    }

    public function editCampaign($campaign_id)
    {
        $current_user = Auth::user();
        $campaignDetails = Campaign::where('id', $campaign_id)->first();
        $influencers = User::where('user_role', 'influencer')->where('role_id', '3')->get();
        $campaigninfluencers = CampaignInfluencer::where('campaign_id', $campaignDetails->id)->where('user_id', $current_user->id)->get();
        return view('business.campaign.edit_campaign', compact('campaignDetails', 'influencers', 'campaigninfluencers'));
    }

    public function updateCampaign(Request $request)
    {
        $user = Auth::user();

        if($request->file('attachment')) {
            $attachmentPath = $request->file('attachment')->store('campaign_attachment', 'public');
        } else {
            $attachmentPath = null;
        }
        $influencers = $request->influencer_id;

        $updateCampaign = Campaign::where('id', $request->campaign_id)->first();
        $updateCampaign->user_id = $user->id;
        $updateCampaign->name = $request->name;
        $updateCampaign->start_date = $request->start_date;
        $updateCampaign->end_date = $request->end_date;
        $updateCampaign->objectives = $request->objectives;
        $updateCampaign->attachment = $attachmentPath;
        $updateCampaign->save();

        foreach($influencers as $inf) {
            $infExist = CampaignInfluencer::where('campaign_id', $request->campaign_id)->where('user_id', $user->id)->where('influencer_id', $inf)->first();

            if(!$infExist) {
                $addCampInfl = new CampaignInfluencer();
                $addCampInfl->user_id = $user->id;
                $addCampInfl->campaign_id = $updateCampaign->id;
                $addCampInfl->influencer_id = $inf;
                $addCampInfl->save();

                $sendNotification = new Notification();
                $sendNotification->user_id = $inf;
                $sendNotification->title = $user->first_name. ' ' .$user->last_name. " added you in a campaign.";
                $sendNotification->link = '/campaign-list';
                $sendNotification->save();
            }
        }
        
        return redirect()->route('business.campaign.list')->with('success', 'Campaign update successfully.');
    }

    public function deleteCampaign(Request $request)
    {
        $user = Auth::user();
        $campaign = Campaign::find($request->id);
        
        if (!$campaign) {
            return redirect()->route('business.campaign.list')->with('error', 'Campaign not found.');
        }

        if ($campaign->attachment) {
            Storage::disk('public')->delete($campaign->attachment);
        }
        
        $cmp_influencers = CampaignInfluencer::where('campaign_id', $request->id)->where('user_id', $user->id)->delete();
        
        $campaign->delete();

        return redirect()->route('business.campaign.list')->with('success', 'Campaign deleted successfully.');
    }

    public function analyticsCampaign(Request $request)
    {
        return view('business.campaign.campaign_analytics');
    }

    public function closeCampaign(Request $request)
    {
        $user = Auth::user();

        $updateCampaign = Campaign::where('id', $request->id)->first();
        $updateCampaign->status = 1;
        $updateCampaign->save();

        return redirect()->route('business.campaign.list')->with('success', 'Campaign closed successfully.');
    }

    public function activateCampaign(Request $request)
    {
        $user = Auth::user();

        $updateCampaign = Campaign::where('id', $request->id)->first();
        $updateCampaign->status = null;
        $updateCampaign->save();

        return redirect()->route('business.campaign.list')->with('success', 'Campaign activated successfully.');
    }

    public function campaignWorkstatus(Request $request, $campaign_id, $influencer_id)
    {
        $user = Auth::user();
        $campaignId = $campaign_id;
        $infId = $influencer_id;

        $campaignComments = CampaignComment::where('campaign_id', $campaignId)
            ->where(function ($query) use ($infId) {
                $query
                    ->where('sender_id', $infId)
                    ->orWhere('receiver_id', $infId);
            })
            ->get();

        $influencer = CampaignInfluencer::where('campaign_id', $campaignId)->where('influencer_id', $infId)->first();

        return view ('business.campaign.campaign_work_status', compact('campaignComments', 'campaignId', 'influencer', 'user'));
    }

    public function acceptRequest(Request $request)
    {
        $user = Auth::user();

        $updateStatus = CampaignInfluencer::where('id', $request->id)->first();
        $updateStatus->request_status = 1;
        $updateStatus->save();

        $updateCampaignStatus = Campaign::where('id', $updateStatus->campaign_id)->first();
        $updateCampaignStatus->camp_status = 5;
        $updateCampaignStatus->save();
        
        // $updateComment = new CampaignComment();
        // $updateComment->campaign_id = $updateStatus->campaign_id;
        // $updateComment->sender_id = $user->id;
        // $updateComment->receiver_id = $request->receiver_id;
        // $updateComment->comment = "Your request is approved.";
        // $updateComment->save();

        // $paymentRequest = new PaymentRequest();
        // $paymentRequest->user_id = $user->id;
        // $paymentRequest->payment_to = $request->receiver_id;
        // $paymentRequest->amount = $gig_checkout->subtotal;
        // $paymentRequest->save();

        $notification = new Notification();
        $notification->user_id = $request->receiver_id;
        $notification->title = $user->first_name. ' ' .$user->last_name. ' approved your work for campaign.';
        $notification->link = 'campaign-work-status/'.$updateStatus->campaign_id;
        $notification->save();

        return redirect()->route('business.campaign.workstatus', ['campaign_id' => $request->campaign_id, 'influencer_id' => $request->receiver_id])->with('success', 'Request Accepted.');
    }

    public function declineRequest(Request $request)
    {
        $user = Auth::user();

        $postComment = new CampaignComment();
        $postComment->campaign_id = $request->campaign_id;
        $postComment->sender_id = $user->id;
        $postComment->receiver_id = $request->receiver_id;
        $postComment->comment = $request->comment;
        $postComment->save();

        $updateStatus = CampaignInfluencer::where('campaign_id', $request->campaign_id)->where('influencer_id', $request->receiver_id)->first();
        $updateStatus->request_status = 2;
        $updateStatus->save();

        // $updateCampaignStatus = Campaign::where('id', $updateStatus->campaign_id)->first();
        // $updateCampaignStatus->camp_status = 5;
        // $updateCampaignStatus->save();

        return redirect()->route('business.campaign.workstatus', ['campaign_id' => $request->campaign_id, 'influencer_id' => $request->receiver_id])->with('success', 'Request Declined.');
    }

    // public function replyComment(Request $request)
    // {
    //     $user = Auth::user();

    //     $postComment = new CampaignComment();
    //     $postComment->campaign_id = $request->campaign_id;
    //     $postComment->sender_id = $user->id;
    //     $postComment->receiver_id = $request->receiver_id;
    //     $postComment->comment = $request->comment;
    //     $postComment->save();

    //     return redirect()->route('business.campaign.view', $request->campaign_id)->with('success', 'Reply Sent.');
    // }

    public function viewNotification(Request $request)
    {
        $user = Auth::user();
        $notification_list = Notification::where('user_id', $user->id)->get();

        return view('business.notification', compact('notification_list'));
    }

    public function readNotification(Request $request)
    {
        $user = Auth::user();

        $readNotfications = Notification::where('user_id', $user->id)->get();
        foreach($readNotfications as $notf) {
            $notf->status = 1;
            $notf->save();
        }

        return redirect()->route('business.notification')->with('success', 'All notifications mark as read.');
    }

    public function ProductList(Request $request)
    {
        $user = Auth::user();

        $product_list = Product::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return view('business.products.product_list', compact('product_list'));
    }

    public function addProduct(Request $request)
    {
        $user = Auth::user();

        if($request->file('image')) {
            $productImage = $request->file('image')->store('product_image', 'public');
        } else {
            $productImage = null;
        }

        $addProduct = new Product();
        $addProduct->user_id = $user->id;
        $addProduct->name = $request->productname;
        $addProduct->type = $request->type;
        $addProduct->category = $request->category;
        $addProduct->price = $request->price;
        $addProduct->image = $productImage;
        $addProduct->description = $request->description;
        $addProduct->save();

        return redirect()->route('business.product.list')->with('success', 'Product Added Successfully.');
    }

    public function updateProduct(Request $request)
    {
        $user = Auth::user();
        $updateProduct = Product::where('id', $request->product_id)->first();

        $updateProduct->name = $request->productname;
        $updateProduct->type = $request->type;
        $updateProduct->category = $request->category;
        $updateProduct->price = $request->price;

        if($request->hasFile('image')) {
            if ($updateProduct->image && Storage::disk('public')->exists($updateProduct->image)) {
                Storage::disk('public')->delete($updateProduct->image);
            }
            $productImage = $request->file('image')->store('product_image', 'public');
            $updateProduct->image = $productImage;
        }

        $updateProduct->description = $request->description;
        $updateProduct->save();

        return redirect()->route('business.product.list')->with('success', 'Product Updated Successfully.');
    }

    public function deleteProduct(Request $request)
    {
        $user = Auth::user();
        $product = Product::find($request->id);
        
        if (!$product) {
            return redirect()->route('business.product.list')->with('error', 'Product not found.');
        }
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('business.product.list')->with('success', 'Product deleted successfully.');
    }

    public function calender(Request $request)
    {
        $user = Auth::user();

        $campaign_list = Campaign::where('user_id', $user->id)->get();
        return view('business.calender', compact('campaign_list'));
    }

    public function transactionList(Request $request)
    {
        $user = Auth::user();
        $transaction_list = Transaction::orderBy('id', 'desc')->where('business_id', $user->id)->get();

        return view('business.payment.transaction', compact('transaction_list'));
    }

    public function downloadReceipt($transaction_id)
    {
        $user = Auth::user();
        $transaction = Transaction::where('id', $transaction_id)->first();

        return view('business.payment.download_receipt', compact('transaction'));
    }

    public function escrowPayment(Request $request)
    {
        $user = Auth::user();
        $payment_list = EscrowPayment::where('payment_by', $user->id)->orderBy('id', 'desc')->get();

        return view('business.payment.escrow_payment', compact('payment_list'));
    }

    public function learnSwayit(Request $request)
    {
        $swayit_tutorial = LearnSwayitTutorial::orderBy('created_at', 'desc')->get();
        $swayit_category = LearnSwayitCategory::orderBy('created_at', 'desc')->get();

        return view('business.learn_swayit.learn_swayit', compact('swayit_category', 'swayit_tutorial'));
    }

    public function tutorialDetails($tutorial_id)
    {
        $swayit_tutorial = LearnSwayitTutorial::where('id', $tutorial_id)->first();
        return view('business.learn_swayit.tutorial_details', compact('swayit_tutorial'));
    }

    public function bankList()
    {
        $user = Auth::user();

        $bank_list = BankDetail::orderBy('created_at', 'desc')->where('user_id', $user->id)->where('status', null)->get();
        $paypal_list = Paypal::orderBy('created_at', 'desc')->where('user_id', $user->id)->where('status', null)->get();
        return view('business.bank.bank', compact('bank_list', 'paypal_list'));
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