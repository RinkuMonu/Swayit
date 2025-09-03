<?php

namespace App\Http\Controllers;

use Yasser\Agora\RtcTokenBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoCallController extends Controller
{
    public function videoCall() 
    {
        return view('business.videocall.video_call');
    }

    public function generateToken(Request $request)
    {
        $appID = 'a81a85c3891140769de197a994ef8c76';
        $appCertificate = '6e4a24affda24896bfaa6606fe379156';
        $channelName = 'agoraVideo';
        $user = 0;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = now()->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
    
        $rtcToken = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $user, $role, $privilegeExpiredTs);
        // return $rtcToken;
        $encodedrtcToken = base64_encode($rtcToken);
        return redirect()->route('join.video.call', $encodedrtcToken);
    }

    public function videoCallInfluencer() 
    {
        return view('influencer.videocall.video_call');
    }

    public function generateTokenInfluencer(Request $request)
    {
        $appID = 'a81a85c3891140769de197a994ef8c76';
        $appCertificate = '6e4a24affda24896bfaa6606fe379156';
        $channelName = 'agoraVideo';
        $user = 0;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = now()->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
    
        $rtcToken = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $user, $role, $privilegeExpiredTs);
        // return $rtcToken;
        $encodedrtcToken = base64_encode($rtcToken);
        return redirect()->route('join.video.call', $encodedrtcToken);
    }

    public function joinVideoCall($rtc_token) 
    {
        $rtcToken = $rtc_token;
        $token = base64_decode($rtc_token);
        $app_id = 'a81a85c3891140769de197a994ef8c76';
        $channel_name = 'agoraVideo';
        return view('business.videocall.join_call', compact('rtcToken', 'token', 'app_id', 'channel_name'));
    }
}
