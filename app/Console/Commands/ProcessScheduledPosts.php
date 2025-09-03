<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ProcessScheduledPosts extends Command
{
    protected $signature = 'posts:process';
    protected $description = 'Send scheduled posts to Facebook';

    public function handle()
    {
        $posts = DB::table('scheduled_posts')
            ->where('posted', false)
            ->where('post_time', '<=', now())
            ->get();

        foreach ($posts as $post) {
            $fb = DB::table('facebook_connections')->where('user_id', $post->user_id)->first();

            if (!$fb) continue;

            $pageId = $fb->facebook_page_id;
            $token = $fb->facebook_page_token;

            try {
                switch ($post->type) {
                    case 'photo':
                        Http::withToken($token)
                            ->attach(
                                'source',
                                file_get_contents(public_path($post->file_path)),
                                basename($post->file_path)
                            )
                            ->post("https://graph.facebook.com/{$pageId}/photos", [
                                'caption' => $post->caption ?? '',
                            ]);
                        break;

                    case 'video':
                        $videoUrl = asset($post->file_path);
                        Http::post("https://graph.facebook.com/{$pageId}/videos", [
                            'file_url' => $videoUrl,
                            'description' => $post->caption ?? '',
                            'access_token' => $token,
                        ]);
                        break;

                    case 'text':
                        Http::post("https://graph.facebook.com/{$pageId}/feed", [
                            'message' => $post->caption ?? '',
                            'access_token' => $token,
                        ]);
                        break;
                }

                DB::table('scheduled_posts')->where('id', $post->id)->update(['posted' => true]);
            } catch (\Exception $e) {
                \Log::error('Facebook post failed: ' . $e->getMessage());
            }
        }

        $this->info('Scheduled posts processed.');
    }
}
