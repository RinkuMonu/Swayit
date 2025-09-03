<?php

namespace App\Http\Controllers;

use Yasser\Agora\RtcTokenBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AudioCallController extends Controller
{
    public function audioCall() 
    {
        return view('business.audiocall.audio_call');
    }

    public function generateAudiocallToken(Request $request)
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
        return redirect()->route('join.audio.call', $encodedrtcToken);
    }

    public function joinAudioCall($rtc_token) 
    {
        $rtcToken = $rtc_token;
        $token = base64_decode($rtc_token);
        $app_id = 'a81a85c3891140769de197a994ef8c76';
        $channel_name = 'agoraVideo';
        return view('business.audiocall.join_call', compact('rtcToken', 'token', 'app_id', 'channel_name'));
    }
}
