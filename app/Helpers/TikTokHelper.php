<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('refreshTikTokToken')) {
    function refreshTikTokToken($user)
    {
        if ($user->tiktok_token_expires_at && $user->tiktok_token_expires_at->isFuture()) {
            return $user->tiktok_access_token;
        }

        $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token', [
            'client_key'     => config('services.tiktok.client_key'),
            'client_secret'  => config('services.tiktok.client_secret'),
            'grant_type'     => 'refresh_token',
            'refresh_token'  => $user->tiktok_refresh_token,
        ]);

        $data = $response->json();

        if ($response->failed() || empty($data['access_token'])) {
            throw new \Exception('Could not refresh TikTok token: ' . json_encode($data));
        }

        $user->update([
            'tiktok_access_token'        => $data['access_token'],
            'tiktok_refresh_token'       => $data['refresh_token'],
            'tiktok_token_expires_at'    => now()->addSeconds($data['expires_in']),
        ]);

        return $data['access_token'];
    }
}
