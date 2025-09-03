<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpEmail;

class WebsiteController extends Controller
{
    public function emailVerify()
    {
        return view('auth.signup_user');
    }

    public function privacyPolicy(){
         return view('privacy');

    }

    public function sendEmailOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $emailOtp = rand(000000, 999999);

        $request->session()->put('new_email', $request->email);
        $request->session()->put('new_otp', $emailOtp);

        Mail::to($request->email)->send(new OtpEmail($emailOtp));
        return redirect()->route('register')->with('success', 'Check your email. We have sent an otp.');
        // return view('auth.register');
    }

    public function home()
    {
        return view('website.home');
    }
    
    public function about()
    {
        return view('website.about');
    }
    
    public function contact()
    {
        return view('website.contact');
    }
    
    public function blog()
    {
        $blogListHeader = Blog::orderBy('id', 'desc')->get()->take(2);
        $blogListBody = Blog::orderBy('id', 'desc')->get();
        return view('website.blog', compact('blogListHeader', 'blogListBody'));
    }
    
    public function blogDetails($blog_id)
    {
        $blogDetails = Blog::where('id', $blog_id)->first();
        $sideBlogs = Blog::orderBy('id', 'desc')->get();
        return view('website.blog_details', compact('blogDetails', 'sideBlogs'));
    }
    
    public function businessOne()
    {
        return view('website.business_one');
    }

    public function businessTwo()
    {
        return view('website.business_two');
    }
    public function businessThree()
    {
        return view('website.business_three');
    }

    public function businessFour()
    {
        return view('website.business_four');
    }

    public function businessFive()
    {
        return view('website.business_five');
    }

    public function influencerOne()
    {
        return view('website.influencer_one');
    }

    public function influencerTwo()
    {
        return view('website.influencer_two');
    }

    public function influencerThree()
    {
        return view('website.influencer_three');
    }

    public function influencerFour()
    {
        return view('website.influencer_four');
    }

    public function influencerFive()
    {
        return view('website.influencer_five');
    }

    public function influencerSix()
    {
        return view('website.influencer_six');
    }

    public function influencerSeven()
    {
        return view('website.influencer_seven');
    }

    public function influencerEight()
    {
        return view('website.influencer_Eight');
    }
}
