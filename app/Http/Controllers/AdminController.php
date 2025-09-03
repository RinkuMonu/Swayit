<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Ticket;
use App\Models\TicketChat;
use App\Models\User;
use App\Models\Industry;
use App\Models\Transaction;
use App\Models\GigCheckout;
use App\Models\EscrowPayment;
use App\Models\PaymentRequest;
use App\Models\Coupon;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\HomeContent;
use App\Models\AboutContent;
use App\Models\AboutFeatureContent;
use App\Models\BlogContent;
use App\Models\Blog;
use App\Models\ContactContent;
use App\Models\SocialMedias;
use App\Models\ContractContent;
use App\Models\Paypal;
use App\Models\LearnSwayitCategory;
use App\Models\LearnSwayitTutorial;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(Request $request) 
    {
        $user = Auth::user();
        return view('admin.dashboard', compact('user'));
    }

    public function category(Request $request)
    {
        $user = Auth::user();
        $ctg_list = Category::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return view('admin.category', compact('ctg_list'));
    }

    public function addCategory(Request $request)
    {
        $user = Auth::user();

        $newCategory = new Category();
        $newCategory->user_id = $user->id;
        $newCategory->name = $request->category_name;
        $newCategory->status = true;
        $newCategory->save();

        return redirect()->route('admin.category')->with('success', 'Category Added Successfully.');
    }

    public function deleteCategory(Request $request)
    {
        // dd($request->id);
        $user = Auth::user();
        $category = Category::find($request->id);
        
        if (!$category) {
            return redirect()->route('admin.category')->with('error', 'Category not found.');
        }

        $category->delete();

        return redirect()->route('admin.category')->with('success', 'Category deleted successfully.');
    }

    public function updateCategory(Request $request)
    {
        $updateCtg = Category::where('id', $request->id)->first();
        $updateCtg->name = $request->category_name;
        $updateCtg->save();

        return redirect()->route('admin.category')->with('success', 'Category Updated Successfully.');
    }

    public function subCategory(Request $request)
    {
        $user = Auth::user();
        $subctg_list = SubCategory::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $ctg_list = Category::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return view('admin.sub_category', compact('subctg_list', 'ctg_list'));
    }

    public function addSubcategory(Request $request)
    {
        $user = Auth::user();

        $newSubCtg = new SubCategory();
        $newSubCtg->user_id = $user->id;
        $newSubCtg->name = $request->sub_category_name;
        $newSubCtg->ctg_id = $request->category;
        $newSubCtg->status = true;
        $newSubCtg->save();

        return redirect()->route('admin.sub.category')->with('success', 'Sub-category Added Successfully.');
    }

    public function deleteSubcategory(Request $request)
    {
        // dd($request->id);
        $user = Auth::user();
        $subCategory = SubCategory::find($request->id);
        
        if (!$subCategory) {
            return redirect()->route('admin.category')->with('error', 'Category not found.');
        }

        $subCategory->delete();

        return redirect()->route('admin.sub.category')->with('success', 'Sub-category deleted successfully.');
    }

    public function updateSubcategory(Request $request)
    {
        // dd($request->all());
        $updateCtg = SubCategory::where('id', $request->id)->first();
        $updateCtg->name = $request->sub_category_name;
        $updateCtg->ctg_id = $request->category;
        $updateCtg->save();

        return redirect()->route('admin.sub.category')->with('success', 'Sub-category Updated Successfully.');
    }

    public function ticketList(Request $request)
    {
        $ticket_list = Ticket::orderBy('id', 'desc')->get();
        return view('admin.ticket_list', compact('ticket_list'));
    }

    public function viewTicket($id)
    {
        $ticket_details = Ticket::where('id', $id)->first();
        return view('admin.ticket', compact('ticket_details'));
    }

    public function changeStatusTicket(Request $request)
    {
        $ticket_details = Ticket::where('id', $request->id)->first();
        $ticket_details->status = null;
        $ticket_details->save();
        
        return redirect()->route('admin.ticket.list')->with('success', 'Ticket Status changed successfully.');
    }

    public function deleteTicket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        
        if (!$ticket) {
            return redirect()->route('admin.ticket.list')->with('error', 'Ticket not found.');
        }

        $ticket->delete();

        return redirect()->route('admin.ticket.list')->with('success', 'Ticket deleted successfully.');
    }

    public function sendAdminTicketMessage(Request $request)
    {
        $ticketChat = new TicketChat();
        $ticketChat->user_id = $request->user_id;
        $ticketChat->ticket_id = $request->ticket_id;
        $ticketChat->message = $request->message;
        $ticketChat->status = 0; // status 1 is user message and 0 is admin message
        $ticketChat->save();

        return redirect()->route('admin.view.ticket', $request->ticket_id)->with('success', 'Message sent successfully.');
    }

    public function influencerList(Request $request)
    {
        $influencer_list = User::where('user_role', 'influencer')->where('role_id', '3')->get();
        return view('admin.influencer_list', compact('influencer_list'));
    }

    public function businessList(Request $request)
    {
        $business_list = User::where('user_role', 'business')->where('role_id', '4')->get();
        return view('admin.business_list', compact('business_list'));
    }

    public function industry(Request $request)
    {
        $industry_list = Industry::orderBy('id', 'desc')->get();
        return view('admin.industry', compact('industry_list'));
    }

    public function storeIndustry(Request $request)
    {
        $newIndustry = new Industry();
        $newIndustry->name = $request->industry_name;
        $newIndustry->save();

        return redirect()->route('admin.industry')->with('success', 'Industry Added Successfully.');
    }

    public function updateIndustry(Request $request)
    {
        $updateIndustry = Industry::where('id', $request->id)->first();
        $updateIndustry->name = $request->industry_name;
        $updateIndustry->save();

        return redirect()->route('admin.industry')->with('success', 'Industry Updated Successfully.');
    }

    public function deleteIndustry(Request $request)
    {
        $industry = Industry::find($request->id);
        
        if (!$industry) {
            return redirect()->route('admin.industry')->with('error', 'Industry not found.');
        }

        $industry->delete();

        return redirect()->route('admin.industry')->with('success', 'Industry deleted successfully.');
    }

    public function activeIndustry(Request $request)
    {
        $updateIndustry = Industry::where('id', $request->id)->first();
        $updateIndustry->status = null;
        $updateIndustry->save();

        return redirect()->route('admin.industry')->with('success', 'Industry Activated Successfully.');
    }

    public function couponList(Request $request)
    {
        $coupon_list = Coupon::orderBy('id', 'desc')->get();
        return view('admin.payment.coupon', compact('coupon_list'));
    }

    public function addCoupon(Request $request)
    {
        $addCoupon = new Coupon();
        $addCoupon->coupon = $request->coupon_name;
        $addCoupon->discount = $request->discount;
        $addCoupon->save();
        
        return redirect()->back()->with('success', 'Coupon Created Successfully.');
    }

    public function activeCoupon(Request $request)
    {
        $updateRequest = Coupon::where('id', $request->id)->first();
        $updateRequest->status = null;
        $updateRequest->save();
        
        return redirect()->back()->with('success', 'Coupon Activated.');
    }

    public function inactiveCoupon(Request $request)
    {
        $updateRequest = Coupon::where('id', $request->id)->first();
        $updateRequest->status = 1;
        $updateRequest->save();
        
        return redirect()->back()->with('success', 'Coupon Inactivated.');
    }

    public function paymentRequest(Request $request)
    {
        $request_list = PaymentRequest::orderBy('id', 'desc')->get();
        return view('admin.payment.payment_request', compact('request_list'));
    }

    public function approvePayment(Request $request)
    {
        $updateRequest = PaymentRequest::where('id', $request->id)->first();
        $updateRequest->status = 1;
        $updateRequest->save();
        
        return redirect()->route('admin.payment.request')->with('success', 'Payment request approved.');
    }

    public function declinePayment(Request $request)
    {
        $updateRequest = PaymentRequest::where('id', $request->id)->first();
        $updateRequest->status = 2;
        $updateRequest->save();
        
        return redirect()->route('admin.payment.request')->with('success', 'Payment request declined.');
    }

    public function withdrawRequest(Request $request)
    {
        $request_list = WithdrawRequest::orderBy('id', 'desc')->get();
        return view('admin.payment.withdraw_request', compact('request_list'));
    }

    public function approveWithdraw(Request $request)
    {
        $updateRequest = WithdrawRequest::where('id', $request->id)->first();
        $updateRequest->status = 1;
        $updateRequest->save();
        
        return redirect()->route('admin.withdraw.request')->with('success', 'Withdraw request approved.');
    }

    public function declineWithdraw(Request $request)
    {
        $updateRequest = WithdrawRequest::where('id', $request->id)->first();
        $updateRequest->status = 2;
        $updateRequest->save();
        
        return redirect()->route('admin.withdraw.request')->with('success', 'Withdraw request declined.');
    }

    public function escrowPayment(Request $request)
    {
        $user = Auth::user();
        $payment_list = EscrowPayment::orderBy('id', 'desc')->get();

        return view('admin.payment.escrow_payment', compact('payment_list'));
    }

    public function home(Request $request)
    {
        $homePage = HomeContent::orderBy('id', 'desc')->first();

        return view('admin.pages.home', compact('homePage'));
    }

    public function updateHomecontent(Request $request)
    {
        $updateContent = HomeContent::orderBy('id', 'desc')->first();

        if($request->file('home_video')) {

            if ($updateContent->video) {
                Storage::disk('public')->delete($updateContent->video);
            }

            $path = $request->file('home_video')->store('page_content', 'public');
            $updateContent->video = $path;
        }

        if($request->file('home_video_two')) {

            if ($updateContent->video_two) {
                Storage::disk('public')->delete($updateContent->video_two);
            }

            $path2 = $request->file('home_video_two')->store('page_content', 'public');
            $updateContent->video_two = $path2;
        }

        if($request->file('home_video_three')) {

            if ($updateContent->video_three) {
                Storage::disk('public')->delete($updateContent->video_three);
            }

            $path3 = $request->file('home_video_three')->store('page_content', 'public');
            $updateContent->video_three = $path3;
        }

        $updateContent->title = $request->home_title;
        $updateContent->save();

        return redirect()->back()->with('success', 'Home Page Content Updated.');
    }

    public function about(Request $request)
    {
        $aboutPage = AboutContent::orderBy('id', 'desc')->first();
        $aboutFeaturePage = AboutFeatureContent::orderBy('id', 'desc')->first();

        return view('admin.pages.about', compact('aboutPage', 'aboutFeaturePage'));
    }

    public function aboutFeature(Request $request)
    {
        $aboutFeature = AboutFeatureContent::orderBy('id', 'desc')->first();

        return view('admin.pages.about_feature', compact('aboutFeature'));
    }

    public function updateAboutContent(Request $request)
    {
        $updateContent = AboutContent::orderBy('id', 'desc')->first();

        if($request->file('image_one')) {

            if ($updateContent->image_one) {
                Storage::disk('public')->delete($updateContent->image_one);
            }

            $ImageOnepath = $request->file('image_one')->store('page_content', 'public');
            $updateContent->image_one = $ImageOnepath;
        }

        if($request->file('image_two')) {

            if ($updateContent->image_two) {
                Storage::disk('public')->delete($updateContent->image_two);
            }

            $ImageTwopath = $request->file('image_two')->store('page_content', 'public');
            $updateContent->image_two = $ImageTwopath;
        }

        if($request->file('image_three')) {

            if ($updateContent->image_three) {
                Storage::disk('public')->delete($updateContent->image_three);
            }

            $ImageThreepath = $request->file('image_three')->store('page_content', 'public');
            $updateContent->image_three = $ImageThreepath;
        }

        $updateContent->title_one = $request->title_one;
        $updateContent->desc_one = $request->description_one;
        $updateContent->title_two = $request->title_two;
        $updateContent->desc_two = $request->description_two;
        $updateContent->title_three = $request->title_three;
        $updateContent->desc_three = $request->description_three;
        $updateContent->link = $request->link;
        $updateContent->save();

        return redirect()->back()->with('success', 'About Page Content Updated.');
    }

    public function updateAboutFeature(Request $request)
    {
        $updateContent = AboutFeatureContent::orderBy('id', 'desc')->first();

        $updateContent->feature_one = $request->feature_one;
        $updateContent->feature_two = $request->feature_two;
        $updateContent->feature_three = $request->feature_three;
        $updateContent->feature_four = $request->feature_four;
        $updateContent->feature_five = $request->feature_five;
        $updateContent->feature_six = $request->feature_six;
        $updateContent->save();

        return redirect()->back()->with('success', 'About Page Features Updated.');
    }

    public function blogContent(Request $request)
    {
        $blogContent = BlogContent::orderBy('id', 'desc')->first();

        return view('admin.pages.blog_content', compact('blogContent'));
    }

    public function updateBlogContent(Request $request)
    {
        $updateContent = BlogContent::orderBy('id', 'desc')->first();

        if($request->file('image')) {

            if ($updateContent->image) {
                Storage::disk('public')->delete($updateContent->image);
            }

            $path = $request->file('image')->store('page_content', 'public');
            $updateContent->image = $path;
        }

        $updateContent->title = $request->title;
        $updateContent->description = $request->description;
        $updateContent->save();

        return redirect()->back()->with('success', 'Blog Page Content Updated.');
    }

    public function blog(Request $request)
    {
        $blogList = Blog::orderBy('id', 'desc')->get();

        return view('admin.pages.blog', compact('blogList'));
    }

    public function storeBlog(Request $request)
    {
        $addBlog = new Blog();

        if($request->file('image')) {
            $path = $request->file('image')->store('blog', 'public');
            $addBlog->image = $path;
        }

        $addBlog->title = $request->title;
        $addBlog->author = $request->author;
        $addBlog->date = $request->date;
        $addBlog->description = $request->description;
        $addBlog->save();

        return redirect()->back()->with('success', 'Blog Added.');
    }

    public function updateBlog(Request $request)
    {
        $updateBlog = Blog::where('id', $request->id)->first();

        if($request->file('image')) {

            if ($updateBlog->image) {
                Storage::disk('public')->delete($updateBlog->image);
            }

            $path = $request->file('image')->store('blog', 'public');
            $updateBlog->image = $path;
        }

        $updateBlog->title = $request->title;
        $updateBlog->author = $request->author;
        $updateBlog->date = $request->date;
        $updateBlog->description = $request->description;
        $updateBlog->save();

        return redirect()->back()->with('success', 'Blog Updated.');
    }

    public function deleteBlog(Request $request)
    {
        $blog = Blog::find($request->id);

        if ($blog) {
            Storage::disk('public')->delete($blog->image);
            $blog->delete();

            return redirect()->back()->with('success', 'Blog Deleted.');
        }
    }

    public function contact(Request $request)
    {
        $homePage = HomeContent::orderBy('id', 'desc')->first();

        return view('admin.pages.home', compact('homePage'));
    }

    public function socialPost(Request $request)
    {
        $socialMedia = SocialMedias::orderBy('id', 'desc')->first();

        return view('admin.pages.social_post', compact('socialMedia'));
    }

    public function updateSocialPost(Request $request)
    {
        $updatePost = SocialMedias::orderBy('id', 'desc')->first();
        $updatePost->facebook = $request->facebook;
        $updatePost->instagram = $request->instagram;
        $updatePost->twitter = $request->twitter;
        $updatePost->youtube = $request->youtube;
        $updatePost->tiktok = $request->tiktok;
        $updatePost->snapchat = $request->snapchat;
        $updatePost->bereal = $request->bereal;
        $updatePost->twitch = $request->twitch;
        $updatePost->save();

        return redirect()->back()->with('success', 'Social Media Updated.');
    }

    public function contractContent(Request $request)
    {
        $contract = ContractContent::orderBy('id', 'desc')->first();

        return view('admin.contract', compact('contract'));
    }

    public function updateContract(Request $request)
    {
        $updateContract = ContractContent::orderBy('id', 'desc')->first();
        $updateContract->color = $request->color;
        $updateContract->sub_title = $request->sub_title;
        $updateContract->description = $request->description;
        $updateContract->save();

        return redirect()->back()->with('success', 'Contract Content Updated.');
    }

    public function tutorialCategory(Request $request)
    {
        $category_list = LearnSwayitCategory::orderBy('created_at', 'desc')->get();
        return view('admin.tutorial.category', compact('category_list'));
    }

    public function storeTutorialCategory(Request $request)
    {
        $newCategory = new LearnSwayitCategory();
        $newCategory->title = $request->category_name;
        $newCategory->save();

        return redirect()->back()->with('success', 'Tutorial Category Added Successfully.');
    }

    public function updateTutorialCategory(Request $request)
    {
        $updateCategory = LearnSwayitCategory::where('id', $request->id)->first();
        $updateCategory->title = $request->category_name;
        $updateCategory->save();

        return redirect()->back()->with('success', 'Tutorial Category Updated Successfully.');
    }

    public function deleteTutorialCategory(Request $request)
    {
        $category = LearnSwayitCategory::find($request->id);
        
        if (!$category) {
            return redirect()->back()->with('error', 'Tutorial Category not found.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Tutorial Category deleted successfully.');
    }

    public function tutorial(Request $request)
    {
        $category_list = LearnSwayitCategory::orderBy('created_at', 'desc')->get();
        $tutorial_list = LearnSwayitTutorial::orderBy('created_at', 'desc')->get();

        return view('admin.tutorial.tutorial', compact('tutorial_list', 'category_list'));
    }

    public function storeTutorial(Request $request)
    {
        $newTutorial = new LearnSwayitTutorial();
        $newTutorial->category_id = $request->category;
        $newTutorial->title = $request->title;

        if($request->file('image')) {
            $path = $request->file('image')->store('tutorial', 'public');
            $newTutorial->image = $path;
        }

        if($request->file('video')) {
            $videoPath = $request->file('video')->store('tutorial', 'public');
            $newTutorial->video = $videoPath;
        }

        $newTutorial->author = $request->author;
        $newTutorial->description = $request->description;
        $newTutorial->save();

        return redirect()->back()->with('success', 'Tutorial Added Successfully.');
    }

    public function updateTutorial(Request $request)
    {
        $updateTutorial = LearnSwayitTutorial::where('id', $request->tutorial_id)->first();
        $updateTutorial->category_id = $request->category;
        $updateTutorial->title = $request->title;

        if($request->file('image')) {

            if ($updateTutorial->image) {
                Storage::disk('public')->delete($updateTutorial->image);
            }

            $path = $request->file('image')->store('tutorial', 'public');
            $updateTutorial->image = $path;
        }

        if($request->file('video')) {

            if ($updateTutorial->video) {
                Storage::disk('public')->delete($updateTutorial->video);
            }

            $videoPath = $request->file('video')->store('tutorial', 'public');
            $updateTutorial->video = $videoPath;
        }

        $updateTutorial->author = $request->author;
        $updateTutorial->description = $request->description;
        $updateTutorial->save();

        return redirect()->back()->with('success', 'Tutorial Category Added Successfully.');
    }
}
