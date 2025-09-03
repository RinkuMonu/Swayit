<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\VideoCallController;
use App\Http\Controllers\AudioCallController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessSocialMediaController;
use App\Http\Controllers\YouTubeController;


Route::get('command', function () {
    \Artisan::call('optimize:clear');
    dd("Done");
});

Route::get('/view-logs-temp-debug', function () {
    $logPath = storage_path('logs/laravel.log');

    if (File::exists($logPath)) {
        // Read the last 50 lines to keep it manageable
        $content = File::get($logPath);
        $lines = explode("\n", $content);
        $lastLines = array_slice($lines, -100); // Get last 100 lines
        return '<pre>' . htmlspecialchars(implode("\n", $lastLines)) . '</pre>';
    }
});

Route::get('/run-facebook-migration', function () {
    Artisan::call('migrate');
    return 'Facebook Connections table migrated!';
});

Route::get('/privacy-policy', function () {
    return view('privacy');
});

Route::get('/terms', function () {
    return view('terms');
});

Route::get('cache-clear', function () {
    \Artisan::call('cache:clear');
    dd("Done");
});

Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    return 'Configuration cache cleared successfully!';
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully!';
});

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::post('/login', [AuthController::class, 'customLogin'])->name('login');
Route::get('/facebook/pages', [SocialMediaController::class, 'getFacebookPages']);


Route::get('/email-verify', [WebsiteController::class, 'emailVerify'])->name('email.verify');
Route::post('/send-email-otp', [WebsiteController::class, 'sendEmailOtp'])->name('email.otp');

Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/home', [WebsiteController::class, 'home'])->name('home');
Route::get('/privacy-policy', [WebsiteController::class, 'privacyPolicy'])->name('privacy.policy');


Route::get('/about', [WebsiteController::class, 'about'])->name('about');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::get('/blog', [WebsiteController::class, 'blog'])->name('blog');
Route::get('/blog-details/{id}', [WebsiteController::class, 'blogDetails'])->name('blog.details');



Route::get('sync-facebook-posts', [SocialMediaController::class, 'fetchAndStoreFacebookPosts'])->name('facebook.sync');
Route::post('/upload-instagram-post', [SocialMediaController::class, 'upload'])->name('uploadPost');
Route::post('/upload-instagram-photo', [SocialMediaController::class, 'uploadPhotoToInstagram'])->name('upload.instagram.photo');
Route::post('/upload-instagram-video', [SocialMediaController::class, 'uploadVideoToInstagram'])->name('upload.instagram.video');
Route::post('/upload/instagram/text', [SocialMediaController::class, 'uploadTextToInstagram'])->name('upload.instagram.text');
Route::get('/facebook/login', [SocialMediaController::class, 'redirectToFacebook'])->name('redirect.facebook');
Route::post('/influencer/upload/facebook', [SocialMediaController::class, 'facebookUpload'])->name('uploadTofacebook');

Route::get('auth/instagram', [SocialMediaController::class, 'redirectToInstagram'])->name('instagram.connect');
Route::post('/upload/tiktok-photo', [SocialmediaController::class, 'uploadPhotoToTikTok'])->name('uploadTo.tiktok');

Route::get('/twitter/connect', [SocialMediaController::class, 'redirectToTwitter'])->name('twitter.connect');
Route::get('/auth/twitter', [SocialMediaController::class, 'redirectToTwitter'])->name('auth.twitter');
Route::get('/auth/twitter/callback', [SocialMediaController::class, 'handleTwitterCallback'])->name('auth.twitter.callback');
Route::get('/twitter/callback', [SocialMediaController::class, 'handleTwitterCallback'])->name('twitter.callback');
Route::post('/twitter/disconnect', [SocialMediaController::class, 'disconnectTwitter'])->name('disconnect.twitter');


Route::post('/tiktok/disconnect', [SocialMediaController::class, 'disconnectTiktok'])->name('disconnect.tiktok');




Route::post('/facebook/disconnect', [SocialMediaController::class, 'disconnectFacebook'])->name('disconnect.facebook');
Route::post('/instagram/disconnect', [SocialMediaController::class, 'disconnectInstagram'])->name('disconnect.instagram');


Route::post('/youtube/disconnect', [SocialMediaController::class, 'disconnectYoutube'])->name('youtube.disconnect');
Route::get('/youtube/login', [SocialMediaController::class, 'redirectToYouTube'])->name('youtube.login');
Route::get('/youtube/callback', [SocialMediaController::class, 'handleYouTubeCallback'])->name('youtube.callback');
Route::post('/youtube/upload', [SocialMediaController::class, 'uploadVideo'])->name('influencer.upload.youtube.video');
Route::get('/twitter/upload', [SocialMediaController::class, 'uploadTwitter'])->name('influencer.upload.twitter');
Route::get('/upload-to-twitter', [SocialMediaController::class, 'uploadToVideoTwitter'])->name('influencer.uploadTo.twitter');




Route::get('/business-one', [WebsiteController::class, 'businessOne'])->name('business.one');
Route::get('/business-two', [WebsiteController::class, 'businessTwo'])->name('business.two');
Route::get('/business-three', [WebsiteController::class, 'businessThree'])->name('business.three');
Route::get('/business-four', [WebsiteController::class, 'businessFour'])->name('business.four');
Route::get('/business-five', [WebsiteController::class, 'businessFive'])->name('business.five');
Route::get('/influencer-one', [WebsiteController::class, 'influencerOne'])->name('influencer.one');
Route::get('/influencer-two', [WebsiteController::class, 'influencerTwo'])->name('influencer.two');
Route::get('/influencer-three', [WebsiteController::class, 'influencerThree'])->name('influencer.three');
Route::get('/influencer-four', [WebsiteController::class, 'influencerFour'])->name('influencer.four');
Route::get('/influencer-five', [WebsiteController::class, 'influencerFive'])->name('influencer.five');
Route::get('/influencer-six', [WebsiteController::class, 'influencerSix'])->name('influencer.six');
Route::get('/influencer-seven', [WebsiteController::class, 'influencerSeven'])->name('influencer.seven');
Route::get('/influencer-eight', [WebsiteController::class, 'influencerEight'])->name('influencer.eight');
Route::get('auth/google', [SocialMediaController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialMediaController::class, 'handleGoogleCallback']);
Route::post('/influencer/post-submit', [SocialMediaController::class, 'postToFacebook'])->name('influencer.post.submit'); 
Route::post('/upload-to-instagram', [SocialMediaController::class, 'InstagramPhotoUpload'])->name('influencer.uploadTo.instagram');
Route::post('/instagram/upload/video', [SocialMediaController::class, 'InstagramVideoUpload'])->name('InstagramUpload');


Route::get('auth/facebook/callback', [SocialMediaController::class, 'handleFacebookCallback'])->name('facebook.callback');
Route::get('auth/instagram/callback', [SocialMediaController::class, 'handleInstagramCallback'])->name('instagram.callback');
Route::get('/auth/tiktok/callback', [SocialmediaController::class, 'handleTikTokCallback'])->name('tiktok.callback');
Route::get('influencer/post/submit/session', [SocialMediaController::class, 'submitPostAfterTwitterAuth'])->name('influencer.post.session');


Route::group(['prefix' => 'influencer', 'as' => 'influencer.', 'middleware' => 'influencer'], function(){
    Route::get('dashboard' , [InfluencerController::class, 'dashboard'])->name('dashboard');
    Route::get('video-verification' , [InfluencerController::class, 'videoVerification'])->name('video.verification');
    Route::post('upload-video' , [InfluencerController::class, 'uploadVideo'])->name('upload.video');
    Route::get('otp-verification' , [InfluencerController::class, 'otpVerification'])->name('otp.verification');
    Route::get('send-otp' , [InfluencerController::class, 'sendOtp'])->name('send.otp');


        
    Route::group(['middleware' => 'influencerotp'], function() {
        Route::group(['middleware' => 'influencervideo'], function() {
            Route::get('notifications' , [InfluencerController::class, 'viewNotification'])->name('notification');
            Route::post('read-notifications' , [InfluencerController::class, 'readNotification'])->name('read.notification');

            Route::get('profile/{user_id}' , [InfluencerController::class, 'profileView'])->name('view.profile');
            Route::get('/api/live-influencer-search', [InfluencerController::class, 'search']);


            // Profile
            Route::get('profile' , [InfluencerController::class, 'profile'])->name('profile');
            Route::get('edit-profile' , [InfluencerController::class, 'editProfile'])->name('edit.profile');
            // Route::post('update-profile-image' , [InfluencerController::class, 'updateProfileImage'])->name('update.profile.image');
            // Route::post('update-cover-image' , [InfluencerController::class, 'updateCoverImage'])->name('update.cover.image');
            Route::post('update-profile' , [InfluencerController::class, 'updateProfile'])->name('update.profile');
            Route::post('add-promotion' , [InfluencerController::class, 'addPromotion'])->name('add.promotion');
            Route::post('update-promotion' , [InfluencerController::class, 'updatePromotion'])->name('update.promotion');
            Route::post('delete-promotion' , [InfluencerController::class, 'deletePromotion'])->name('delete.promotion');


            // Gigs
            Route::get('gigs-list' , [InfluencerController::class, 'gigsList'])->name('gigs.list');
            Route::get('/view-gigs/{id}' , [InfluencerController::class, 'viewGigs'])->name('view.gigs');
            Route::get('add-gigs' , [InfluencerController::class, 'addGigs'])->name('add.gigs');
            Route::post('store-gigs' , [InfluencerController::class, 'storeGigs'])->name('store.gigs');
            Route::get('edit-gigs/{id}' , [InfluencerController::class, 'editGigs'])->name('edit.gigs');
            Route::post('update-gigs' , [InfluencerController::class, 'updateGigs'])->name('update.gigs');
            Route::post('delete-gig-image' , [InfluencerController::class, 'deleteGigImage'])->name('delete.gig.img');
            Route::post('gigs/toggle-status', [InfluencerController::class, 'toggleStatus'])->name('gigs.toggle.status');

            Route::post('delete-gigs' , [InfluencerController::class, 'deleteGigs'])->name('delete.gigs');
            Route::get('/gigs-order' , [InfluencerController::class, 'gigsOrder'])->name('gigs.order');
            Route::get('gig-order-status/{order_id}' , [InfluencerController::class, 'gigsOrderStatus'])->name('gig.order.status');
            Route::post('/submit-gig-order' , [InfluencerController::class, 'submitGigOrder'])->name('submit.gig.order');
        
            // Task
            Route::get('to-do-list' , [InfluencerController::class, 'todoList'])->name('todo.list');
            Route::post('add-task' , [InfluencerController::class, 'addTask'])->name('add.task');
            Route::post('update-task' , [InfluencerController::class, 'updateTask'])->name('update.task');
            Route::post('delete-task' , [InfluencerController::class, 'deleteTask'])->name('delete.task');
        
            // Ticket
            Route::get('ticket-list' , [InfluencerController::class, 'ticketList'])->name('ticket.list');
            Route::get('create-ticket' , [InfluencerController::class, 'createTicket'])->name('create.ticket');
            Route::post('add-ticket' , [InfluencerController::class, 'addTicket'])->name('add.ticket');
            Route::post('update-ticket' , [InfluencerController::class, 'updateTicket'])->name('update.ticket');
            Route::post('delete-ticket' , [InfluencerController::class, 'deleteTicket'])->name('delete.ticket');
            Route::get('reply-ticket/{ticket_id}', [InfluencerController::class, 'replyTicket'])->name('reply.ticket');
            Route::post('/close-ticket', [InfluencerController::class, 'closeTicket'])->name('close.ticket');
            Route::post('send-ticket-message' , [InfluencerController::class, 'sendTicketMessage'])->name('send.ticket.message');

            // Bid
            Route::get('bid-list' , [InfluencerController::class, 'bidList'])->name('bid.list');
            Route::get('matching-bids' , [InfluencerController::class, 'matchingBids'])->name('matching.bids');
            Route::get('bid-details/{id}' , [InfluencerController::class, 'bidDetails'])->name('bid.details');
            Route::post('send-bid-proposal' , [InfluencerController::class, 'sendBidProposal'])->name('send.bid.proposal');
            Route::get('bid-proposals' , [InfluencerController::class, 'bidProposals'])->name('bid.proposals');
            Route::get('search-bids', [InfluencerController::class, 'searchBidsAutocomplete'])->name('search.bids');

           
            Route::get('make-contract/{contract_id}' , [InfluencerController::class, 'makeContract'])->name('make.contract');
            Route::post('upload-signature' , [InfluencerController::class, 'uploadSignature'])->name('upload.signature');
            Route::post('update-contract' , [InfluencerController::class, 'updateContract'])->name('update.contract');
            Route::get('download-contract/{contract_id}' , [InfluencerController::class, 'downloadContrant'])->name('download.contract');
            Route::post('store-contract' , [InfluencerController::class, 'storeContrant'])->name('store.contract');
            Route::get('contract-list' , [InfluencerController::class, 'contractList'])->name('contract.list');
            Route::get('contract-work-status/{contract_id}' , [InfluencerController::class, 'contractWorkstatus'])->name('contract.workstatus');
            Route::post('contract-comment' , [InfluencerController::class, 'contractComment'])->name('contract.comment');

            // Chat
            Route::get('chat' , [InfluencerController::class, 'chat'])->name('chat');
            Route::get('chat/message/{user_id}' , [InfluencerController::class, 'chatMessage'])->name('chat.message');
            Route::post('send-message' , [InfluencerController::class, 'sendMessage'])->name('send.message');
            Route::post('start-chat' , [InfluencerController::class, 'startChat'])->name('start.chat');
            Route::get('/get-user-messages/{user_id}', [InfluencerController::class, 'getMessages'])->name('get.user.message');
            Route::post('/gigs/toggle-status', [InfluencerController::class, 'toggleStatus'])->name('gigs.toggle.status');
           
            Route::get('/influencer/bid/autocomplete', [InfluencerController::class, 'autocomplete'])->name('bid.autocomplete');


        
            // Social Media
            Route::get('/auth/tiktok/redirect', [SocialmediaController::class, 'redirectToTikTok'])->name('tiktok.login');
            Route::get('connect-social-media' , [SocialMediaController::class, 'connectSocialMedia'])->name('connect.social.media');
            Route::get('social-post', [SocialMediaController::class, 'socialPost'])->name('social.post');
            Route::get('facebook-details', [SocialMediaController::class, 'facebookDetails'])->name('facebook.details');
            Route::post('post-facebook', [SocialMediaController::class, 'postFacebookPage'])->name('post.facebook');

  


            Route::get('youtube' , [SocialMediaController::class, 'getYouTubeChannelInfo'])->name('youtube.data');
            Route::post('refresh-youtube-token' , [SocialMediaController::class, 'refreshGoogleAccessToken'])->name('refresh.youtube.token');
            Route::post('/upload-youtube-video', [SocialMediaController::class, 'uploadYoutubeVideo'])->name('upload.youtube.video');
            Route::post('/influencer/upload/image', [SocialMediaController::class, 'uploadImage'])->name('upload.image');

            Route::get('twitter' , [SocialMediaController::class, 'twitterPage'])->name('twitter.page');          
            Route::post('/connect-instagram', [SocialMediaController::class, 'connectInstagram'])->name('connectInstagram');
            Route::post('/update-instagram', [SocialMediaController::class, 'updateInstagram'])->name('updateInstagram');
            Route::get('/instagram', [SocialMediaController::class, 'getInstagram'])->name('getInstagram');
            Route::get('upload-facebook' , [SocialMediaController::class, 'uploadFacebook'])->name('upload.facebook');
            Route::get('upload-instagram' , [SocialMediaController::class, 'uploadInstagram'])->name('upload.instagram');
            Route::get('upload-youtube' , [SocialMediaController::class, 'uploadYoutube'])->name('upload.youtube');
         
            Route::get('upload-snapchat' , [SocialMediaController::class, 'uploadSnapchat'])->name('upload.snapchat');
            Route::get('upload-bereal' , [SocialMediaController::class, 'uploadBereal'])->name('upload.bereal');
            Route::get('upload-twitch' , [SocialMediaController::class, 'uploadTwitch'])->name('upload.twitch');
            ;
            Route::post('/tiktok/upload', [SocialmediaController::class, 'upload'])->name('post.tiktok');
            Route::get('upload-tiktok' , [SocialMediaController::class, 'uploadTiktok'])->name('upload.tiktok');

           




            // Campaign
            Route::get('campaign-list' , [InfluencerController::class, 'campaignList'])->name('campaign.list');
            Route::get('campaign-view/{campaign_id}' , [InfluencerController::class, 'campaignView'])->name('campaign.view');
            Route::post('accept-campaign' , [InfluencerController::class, 'acceptCampaign'])->name('accept.campaign');
            Route::post('decline-campaign' , [InfluencerController::class, 'declineCampaign'])->name('decline.campaign');
            Route::post('post-comment' , [InfluencerController::class, 'postComment'])->name('post.comment');
            Route::get('campaign-analytics' , [InfluencerController::class, 'analyticsCampaign'])->name('campaign.analytics');
            Route::get('campaign-work-status/{campaign_id}' , [InfluencerController::class, 'campaignComment'])->name('campaign.comment');

            // Video Call
            Route::get('/video-call', [VideoCallController::class, 'videoCallInfluencer'])->name('video.call');
            Route::post('/generate-token', [VideoCallController::class, 'generateTokenInfluencer'])->name('generate.videocall.token');

            // Calender
            Route::get('/calender', [InfluencerController::class, 'calender'])->name('calender');

            // Wallet
            Route::get('/wallet', [InfluencerController::class, 'wallet'])->name('wallet');
            Route::post('/withdraw-request', [InfluencerController::class, 'withdrawRequest'])->name('withdraw.request');
            Route::get('/escrow-payment', [InfluencerController::class, 'escrowPayment'])->name('escrow.payment');
            Route::get('/transactions', [InfluencerController::class, 'transactionList'])->name('transactionList');
            Route::get('/download-receipt/{transaction_id}', [InfluencerController::class, 'downloadReceipt'])->name('downloadReceipt');

            // Learn SwayIt
            Route::get('/learn-swayit', [InfluencerController::class, 'learnSwayit'])->name('learn.swayit');
            Route::get('/tutorial-details/{tutorial_id}', [InfluencerController::class, 'tutorialDetails'])->name('tutorialDetails');

            // Bank Details
            Route::get('/bank-details', [InfluencerController::class, 'bankList'])->name('bankList');
            Route::post('/add-bank', [InfluencerController::class, 'addBank'])->name('addBank');
            Route::post('/delete-bank', [InfluencerController::class, 'deleteBank'])->name('deleteBank');
            Route::post('/add-paypal', [InfluencerController::class, 'addPaypal'])->name('addPaypal');
            Route::post('/delete-paypal', [InfluencerController::class, 'deletePaypal'])->name('deletePaypal');
        });
    });
});


Route::group(['prefix' => 'business', 'as' => 'business.', 'middleware' => 'business'], function(){
    Route::get('video-verification' , [BusinessController::class, 'videoVerification'])->name('video.verification');
    Route::post('upload-video' , [BusinessController::class, 'uploadVideo'])->name('upload.video');
    Route::get('otp-verification' , [BusinessController::class, 'otpVerification'])->name('otp.verification');
    Route::get('send-otp' , [BusinessController::class, 'sendOtp'])->name('send.otp');

        
    Route::group(['middleware' => 'businessotp'], function() {
        Route::group(['middleware' => 'businessvideo'], function() {
            Route::get('dashboard' , [BusinessController::class, 'dashboard'])->name('dashboard');
            Route::get('notifications' , [BusinessController::class, 'viewNotification'])->name('notification');
            Route::post('read-notifications' , [BusinessController::class, 'readNotification'])->name('read.notification');

            // Profile
            Route::get('profile/{user_id}' , [BusinessController::class, 'profileView'])->name('view.profile');
            Route::get('edit-profile' , [BusinessController::class, 'editProfile'])->name('edit.profile');
            // Route::post('update-profile-image' , [BusinessController::class, 'updateProfileImage'])->name('update.profile.image');
            Route::post('update-profile' , [BusinessController::class, 'updateProfile'])->name('update.profile');
        
            // Social Media
            Route::get('social-post' , [BusinessController::class, 'socialPost'])->name('social.post');

            // Gigs
            Route::get('gigs-list' , [BusinessController::class, 'gigsList'])->name('gigs.list');
            Route::get('gigs/autocomplete', [BusinessController::class, 'autocomplete'])->name('gigs.autocomplete');

            Route::get('gig-details/{id}' , [BusinessController::class, 'gigsDetails'])->name('view.gigs');
            Route::get('gig-checkout/{id}' , [BusinessController::class, 'gigCheckout'])->name('gig.checkout');
            Route::post('/apply-coupon', [BusinessController::class, 'applyCoupon'])->name('apply.coupon');
            Route::get('gig-invoice/{bill_id}' , [BusinessController::class, 'gigInvoice'])->name('gig.invoice');
            Route::get('print-gig-invoice/{bill_id}' , [BusinessController::class, 'printGigInvoice'])->name('print.gig.invoice');
            Route::post('gig-bill-submit' , [BusinessController::class, 'gigBillSubmit'])->name('submit.bill');
            Route::post('send-gig-message' , [BusinessController::class, 'sendGigMessage'])->name('gigcontact.message');
            Route::get('compare-gigs' , [BusinessController::class, 'compareGigs'])->name('compare.gigs');
            Route::post('review-Influencer' , [BusinessController::class, 'reviewInfluencer'])->name('review.Influencer');
            Route::get('gigs-orders' , [BusinessController::class, 'gigsOrder'])->name('gig.orders');
            Route::get('gig-order-status/{order_id}' , [BusinessController::class, 'gigsOrderStatus'])->name('gig.order.status');
            Route::post('/accept-gig-status' , [BusinessController::class, 'acceptGigStatus'])->name('accept.gigwork.status');
            Route::post('/decline-gig-status' , [BusinessController::class, 'declineGigStatus'])->name('decline.gigwork.status');
            Route::get('gigs-cart' , [BusinessController::class, 'gigsCart'])->name('gigs.cart');
            Route::post('/add-gig-to-cart' , [BusinessController::class, 'addGigCart'])->name('addGigCart');
            Route::post('/remove-gig-to-cart' , [BusinessController::class, 'removeGigCart'])->name('removeGigCart');
            Route::post('/purchase-cart-gigs' , [BusinessController::class, 'purchaseGigCart'])->name('purchaseGigCart');
            
            // Task
            Route::get('to-do-list' , [BusinessController::class, 'todoList'])->name('todo.list');
            Route::post('add-task' , [BusinessController::class, 'addTask'])->name('add.task');
            Route::post('update-task' , [BusinessController::class, 'updateTask'])->name('update.task');
            Route::post('delete-task' , [BusinessController::class, 'deleteTask'])->name('delete.task');
        
            // Ticket
            Route::get('ticket-list' , [BusinessController::class, 'ticketList'])->name('ticket.list');
            Route::get('create-ticket' , [BusinessController::class, 'createTicket'])->name('create.ticket');
            Route::post('add-ticket' , [BusinessController::class, 'addTicket'])->name('add.ticket');
            Route::post('update-ticket' , [BusinessController::class, 'updateTicket'])->name('update.ticket');
            Route::post('delete-ticket' , [BusinessController::class, 'deleteTicket'])->name('delete.ticket');
            Route::get('reply-ticket/{ticket_id}', [BusinessController::class, 'replyTicket'])->name('reply.ticket');
            Route::post('/close-ticket', [BusinessController::class, 'closeTicket'])->name('close.ticket');
            Route::post('send-ticket-message' , [BusinessController::class, 'sendTicketMessage'])->name('send.ticket.message');

            // Bid
            Route::get('add-bid' , [BusinessController::class, 'addBid'])->name('add.bid');
            Route::post('store-bid' , [BusinessController::class, 'storeBid'])->name('store.bid');
            Route::get('bid-list' , [BusinessController::class, 'bidList'])->name('bid.list');

            Route::get('bid-details/{id}' , [BusinessController::class, 'bidDetails'])->name('bid.details');
            Route::get('edit-bid/{id}' , [BusinessController::class, 'editBid'])->name('edit.bid');
            Route::post('update-bid' , [BusinessController::class, 'updateBid'])->name('update.bid');
            Route::post('close-bid' , [BusinessController::class, 'closeBid'])->name('close.bid');
            Route::post('open-bid' , [BusinessController::class, 'openBid'])->name('open.bid');
            Route::post('delete-bid' , [BusinessController::class, 'deleteBid'])->name('delete.bid');
            Route::post('reply-bid' , [BusinessController::class, 'replyBid'])->name('reply.bid');
            Route::post('accept-bid' , [BusinessController::class, 'acceptBid'])->name('accept.bid');
            Route::post('decline-bid' , [BusinessController::class, 'declineBid'])->name('decline.bid');
            // Route::get('bid-chat/{proposal_id}' , [BusinessController::class, 'bidChat'])->name('bid.chat');
            // Route::post('send-bid-message' , [BusinessController::class, 'sendBidMessage'])->name('send.bidmessage');
            Route::get('bid-proposals' , [BusinessController::class, 'bidProposals'])->name('bid.proposals');

            Route::get('download-contract/{contract_id}' , [BusinessController::class, 'downloadContrant'])->name('download.contract');
            Route::post('store-contract' , [BusinessController::class, 'storeContract'])->name('store.contract');
            Route::get('contract-list' , [BusinessController::class, 'contractList'])->name('contract.list');
            Route::get('contract-work-status/{contract_id}' , [BusinessController::class, 'contractWorkstatus'])->name('contract.workstatus');
            Route::post('decline-contract-work' , [BusinessController::class, 'declineContractStatus'])->name('decline.contract.work');
            Route::post('accept-contract-work' , [BusinessController::class, 'acceptContractStatus'])->name('accept.contract.work');

            Route::get('create-contract/{bid_proposal_id}' , [BusinessController::class, 'createContract'])->name('create.contract');
            Route::post('create-default-contract' , [BusinessController::class, 'createDefaultContract'])->name('create.default.contract');
            Route::post('update-contract' , [BusinessController::class, 'updateContract'])->name('update.contract');
            Route::get('make-contract/{contract_id}' , [BusinessController::class, 'makeContract'])->name('make.contract');
            Route::post('upload-signature' , [BusinessController::class, 'uploadSignature'])->name('upload.signature');

            // Chat
            Route::get('chat' , [BusinessController::class, 'chat'])->name('chat');
            Route::get('chat/message/{user_id}' , [BusinessController::class, 'chatMessage'])->name('chat.message');
            Route::post('send-message' , [BusinessController::class, 'sendMessage'])->name('send.message');
            Route::post('start-chat' , [BusinessController::class, 'startChat'])->name('start.chat');
            Route::get('/get-user-messages/{user_id}', [BusinessController::class, 'getMessages'])->name('get.user.message');
            Route::get('/business/gigs/details/ajax', [BusinessController::class, 'ajaxGigDetails'])->name('gigs.details.ajax');

        
            // Social Media
            Route::get('connect-social-media' , [BusinessSocialMediaController::class, 'connectSocialMedia'])->name('connect.social.media');
            Route::get('social-post' , [BusinessSocialMediaController::class, 'socialPost'])->name('social.post');
            Route::post('post-facebook' , [BusinessSocialMediaController::class, 'postFacebookPage'])->name('post.facebook');
            Route::get('youtube' , [BusinessSocialMediaController::class, 'getYouTubeChannelInfo'])->name('youtube.data');
            Route::post('refresh-youtube-token' , [BusinessSocialMediaController::class, 'refreshGoogleAccessToken'])->name('refresh.youtube.token');
            Route::get('/auth', [YouTubeController::class, 'auth'])->name('youtube.auth');
            Route::get('/auth/callback', [YouTubeController::class, 'callback'])->name('youtube.callback');
            Route::get('/analytics', [YouTubeController::class, 'showAnalytics'])->name('youtube.analytics');
            Route::post('/connect-instagram', [BusinessSocialMediaController::class, 'connectInstagram'])->name('connectInstagram');
            Route::post('/update-instagram', [BusinessSocialMediaController::class, 'updateInstagram'])->name('updateInstagram');
            Route::get('/instagram', [BusinessSocialMediaController::class, 'getInstagram'])->name('getInstagram');

            

            // Social Upload
            Route::get('upload-facebook' , [BusinessSocialMediaController::class, 'uploadFacebook'])->name('upload.facebook');
            Route::get('upload-instagram' , [BusinessSocialMediaController::class, 'uploadInstagram'])->name('upload.instagram');
            Route::get('upload-youtube' , [BusinessSocialMediaController::class, 'uploadYoutube'])->name('upload.youtube');
            Route::get('upload-snapchat' , [BusinessSocialMediaController::class, 'uploadSnapchat'])->name('upload.snapchat');
            Route::get('upload-bereal' , [BusinessSocialMediaController::class, 'uploadBereal'])->name('upload.bereal');
            Route::get('upload-twitch' , [BusinessSocialMediaController::class, 'uploadTwitch'])->name('upload.twitch');
            Route::post('upload-twitter', [BusinessSocialMediaController::class, 'uploadTwitter'])->name('upload.twitter');
            Route::post('upload-tiktok', [BusinessSocialMediaController::class, 'uploadTiktok'])->name('upload.tiktok');





            //Influencer
            Route::get('influencer-list' , [BusinessController::class, 'influencerList'])->name('influencer.list');
            Route::get('/search-influencers', [BusinessController::class, 'searchInfluencers'])->name('search.influencers');

            Route::post('add-favorite-Influencer' , [BusinessController::class, 'addFavoriteInfluencer'])->name('add.favorite.Influencer');
            Route::post('remove-favorite-Influencer' , [BusinessController::class, 'removeFavoriteInfluencer'])->name('remove.favorite.Influencer');
            Route::get('favorite-influencers' , [BusinessController::class, 'favoriteInfluencers'])->name('favorite.influencers');
            Route::get('hired-influencers' , [BusinessController::class, 'hiredInfluencers'])->name('hired.influencers');
            Route::get('compare-influencer' , [BusinessController::class, 'compareInfluencer'])->name('compare.influencer');
            // Route::post('get-gigs-for-compare' , [BusinessController::class, 'getGigsForCompare'])->name('get.gigs.compare');

            // Campaign
            Route::get('create-campaign' , [BusinessController::class, 'createCampaign'])->name('create.campaign');
            Route::post('store-campaign' , [BusinessController::class, 'storeCampaign'])->name('store.campaign');
            Route::get('campaign-list' , [BusinessController::class, 'campaignList'])->name('campaign.list');
            Route::get('edit-campaign/{campaign_id}' , [BusinessController::class, 'editCampaign'])->name('edit.campaign');
            Route::post('update-campaign' , [BusinessController::class, 'updateCampaign'])->name('update.campaign');
            Route::get('campaign-view/{campaign_id}' , [BusinessController::class, 'campaignView'])->name('campaign.view');
            Route::post('delete-campaign' , [BusinessController::class, 'deleteCampaign'])->name('delete.campaign');
            Route::get('campaign-analytics' , [BusinessController::class, 'analyticsCampaign'])->name('campaign.analytics');
            Route::post('close-campaign' , [BusinessController::class, 'closeCampaign'])->name('close.campaign');
            Route::post('activate-campaign' , [BusinessController::class, 'activateCampaign'])->name('activate.campaign');
            Route::post('accept-request' , [BusinessController::class, 'acceptRequest'])->name('accept.request');
            Route::post('decline-request' , [BusinessController::class, 'declineRequest'])->name('decline.request');
            Route::post('reply-comment' , [BusinessController::class, 'replyComment'])->name('reply.comment');
            Route::get('campaign-workstatus/{campaign_id}/{influencer_id}' , [BusinessController::class, 'campaignWorkstatus'])->name('campaign.workstatus');

            // Video Call
            Route::get('/video-call', [VideoCallController::class, 'videoCall'])->name('video.call');
            Route::post('/generate-token', [VideoCallController::class, 'generateToken'])->name('generate.videocall.token');

            // Audio Call
            Route::get('/audio-call', [AudioCallController::class, 'audioCall'])->name('audio.call');
            Route::post('/generate-audiocall-token', [AudioCallController::class, 'generateAudiocallToken'])->name('generate.audiocall.token');

            // Product & Service
            Route::get('/product-list', [BusinessController::class, 'ProductList'])->name('product.list');
            Route::post('add-product' , [BusinessController::class, 'addProduct'])->name('add.product');
            Route::post('update-product' , [BusinessController::class, 'updateProduct'])->name('update.product');
            Route::post('delete-product' , [BusinessController::class, 'deleteProduct'])->name('delete.product');

            // Calender
            Route::get('/calender', [BusinessController::class, 'calender'])->name('calender');

            // Transaction
            Route::get('/transactions', [BusinessController::class, 'transactionList'])->name('transactionList');
            Route::get('/download-receipt/{transaction_id}', [BusinessController::class, 'downloadReceipt'])->name('downloadReceipt');
            Route::get('/escrow-payment', [BusinessController::class, 'escrowPayment'])->name('escrow.payment');

            // Learn SwayIt
            Route::get('/learn-swayit', [BusinessController::class, 'learnSwayit'])->name('learn.swayit');
            Route::get('/tutorial-details/{tutorial_id}', [BusinessController::class, 'tutorialDetails'])->name('tutorialDetails');

            // Stripe
            // Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
            Route::post('stripe/payment', [BusinessController::class, 'processPayment'])->name('stripe.payment');

            // Bank Details
            Route::get('/bank-details', [BusinessController::class, 'bankList'])->name('bankList');
            Route::post('/add-bank', [BusinessController::class, 'addBank'])->name('addBank');
            Route::post('/delete-bank', [BusinessController::class, 'deleteBank'])->name('deleteBank');
            Route::post('/add-paypal', [BusinessController::class, 'addPaypal'])->name('addPaypal');
            Route::post('/delete-paypal', [BusinessController::class, 'deletePaypal'])->name('deletePaypal');
        });
    });
});

Route::get('/join-video-call/{rtc_token}', [VideoCallController::class, 'joinVideoCall'])->name('join.video.call');
Route::get('/join-audio-call/{rtc_token}', [AudioCallController::class, 'joinAudioCall'])->name('join.audio.call');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
    Route::get('dashboard' , [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Page
    Route::get('home' , [AdminController::class, 'home'])->name('pages.home');
    Route::post('update-home-content' , [AdminController::class, 'updateHomecontent'])->name('update.homecontent');
    Route::get('about' , [AdminController::class, 'about'])->name('pages.about');
    Route::post('update-about-content' , [AdminController::class, 'updateAboutContent'])->name('update.aboutContent');
    Route::get('about-feature' , [AdminController::class, 'aboutFeature'])->name('pages.about.feature');
    Route::post('update-about-feature' , [AdminController::class, 'updateAboutFeature'])->name('update.aboutFeature');
    Route::get('blog-content' , [AdminController::class, 'blogContent'])->name('pages.blogContent');
    Route::post('update-blog-content' , [AdminController::class, 'updateBlogContent'])->name('update.blogContent');
    Route::get('blog' , [AdminController::class, 'blog'])->name('pages.blog');
    Route::post('store-blog' , [AdminController::class, 'storeBlog'])->name('storeBlog');
    Route::post('update-blog' , [AdminController::class, 'updateBlog'])->name('updateBlog');
    Route::post('delete-blog' , [AdminController::class, 'deleteBlog'])->name('deleteBlog');
    Route::get('contact' , [AdminController::class, 'contact'])->name('pages.contact');

    Route::get('social-post' , [AdminController::class, 'socialPost'])->name('pages.socialPost');
    Route::post('update-social-post' , [AdminController::class, 'updateSocialPost'])->name('update.Socialpost');
    Route::get('contract' , [AdminController::class, 'contractContent'])->name('contract.content');
    Route::post('update-scontract' , [AdminController::class, 'updateContract'])->name('update.contract');

    // Category
    Route::get('category' , [AdminController::class, 'category'])->name('category');
    Route::post('add-category' , [AdminController::class, 'addCategory'])->name('add.category');
    Route::post('delete-category' , [AdminController::class, 'deleteCategory'])->name('delete.category');
    Route::post('update-category' , [AdminController::class, 'updateCategory'])->name('update.category');
    Route::get('sub-category' , [AdminController::class, 'subCategory'])->name('sub.category');
    Route::post('add-subcategory' , [AdminController::class, 'addSubcategory'])->name('add.subcategory');
    Route::post('delete-subcategory' , [AdminController::class, 'deleteSubcategory'])->name('delete.subcategory');
    Route::post('update-subcategory' , [AdminController::class, 'updateSubcategory'])->name('update.subcategory');

    // Industry
    Route::get('industry' , [AdminController::class, 'industry'])->name('industry');
    Route::post('store-industry' , [AdminController::class, 'storeIndustry'])->name('store.industry');
    Route::post('update-industry' , [AdminController::class, 'updateIndustry'])->name('update.industry');
    Route::post('delete-industry' , [AdminController::class, 'deleteIndustry'])->name('delete.industry');
    Route::post('active-industry' , [AdminController::class, 'activeIndustry'])->name('active.industry');

    // Users
    Route::get('influencer-list' , [AdminController::class, 'influencerList'])->name('influencer.list');
    Route::get('business-list' , [AdminController::class, 'businessList'])->name('business.list');

    // Ticket
    Route::get('ticket-list' , [AdminController::class, 'ticketList'])->name('ticket.list');
    Route::get('view-ticket/{id}' , [AdminController::class, 'viewTicket'])->name('view.ticket');
    Route::post('delete-ticket' , [AdminController::class, 'deleteTicket'])->name('delete.ticket');
    Route::post('change-ticket-status' , [AdminController::class, 'changeStatusTicket'])->name('status.ticket');
    Route::post('send-admin-ticket-message' , [AdminController::class, 'sendAdminTicketMessage'])->name('send.admin.ticket.message');

    // Payment
    Route::get('coupon-list' , [AdminController::class, 'couponList'])->name('coupon.list');
    Route::post('addCoupon' , [AdminController::class, 'addCoupon'])->name('add.coupon');
    Route::post('activeCoupon' , [AdminController::class, 'activeCoupon'])->name('active.coupon');
    Route::post('inactiveCoupon' , [AdminController::class, 'inactiveCoupon'])->name('inactive.coupon');
    Route::get('payment-request' , [AdminController::class, 'paymentRequest'])->name('payment.request');
    Route::post('approve-payment' , [AdminController::class, 'approvePayment'])->name('approve.payment');
    Route::post('decline-payment' , [AdminController::class, 'declinePayment'])->name('decline.payment');
    Route::get('withdraw-request' , [AdminController::class, 'withdrawRequest'])->name('withdraw.request');
    Route::post('approve-withdraw' , [AdminController::class, 'approveWithdraw'])->name('approve.withdraw');
    Route::post('decline-withdraw' , [AdminController::class, 'declineWithdraw'])->name('decline.withdraw');
    Route::get('/escrow-payment', [AdminController::class, 'escrowPayment'])->name('escrow.payment');
    
    // Industry
    Route::get('tutorial-category' , [AdminController::class, 'tutorialCategory'])->name('tutorialCategory');
    Route::post('store-tutorial-category' , [AdminController::class, 'storeTutorialCategory'])->name('storeTutorialCategory');
    Route::post('update-tutorial-category' , [AdminController::class, 'updateTutorialCategory'])->name('updateTutorialCategory');
    Route::post('delete-tutorial-category' , [AdminController::class, 'deleteTutorialCategory'])->name('deleteTutorialCategory');
    
    // Industry
    Route::get('tutorials' , [AdminController::class, 'tutorial'])->name('tutorial');
    Route::post('store-tutorial' , [AdminController::class, 'storeTutorial'])->name('storeTutorial');
    Route::post('update-tutorial' , [AdminController::class, 'updateTutorial'])->name('updateTutorial');
    Route::post('delete-tutorial' , [AdminController::class, 'deleteTutorial'])->name('deleteTutorial');
});


