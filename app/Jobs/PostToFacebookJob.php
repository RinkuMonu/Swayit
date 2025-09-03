<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostToFacebookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pageId;
    protected $pageToken;
    protected $type; // 'photo', 'video', or 'text'
    protected $data; // additional data like path, caption, etc.

    /**
     * Create a new job instance.
     */
    public function __construct($pageId, $pageToken, $type, $data)
    {
        $this->pageId = $pageId;
        $this->pageToken = $pageToken;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Execute the job.    */
    public function handle()
{
    try {
        $response = null;

        switch ($this->type) {
            case 'photo':
                $response = Http::withToken($this->pageToken)
                    ->attach(
                        'source',
                        file_get_contents($this->data['photo_path']),
                        basename($this->data['photo_path'])
                    )
                    ->post("https://graph.facebook.com/{$this->pageId}/photos", [
                        'caption' => $this->data['caption'] ?? '',
                    ]);
                break;

            case 'video':
                $response = Http::post("https://graph.facebook.com/{$this->pageId}/videos", [
                    'file_url' => $this->data['video_url'],
                    'description' => $this->data['caption'] ?? '',
                    'access_token' => $this->pageToken,
                ]);
                break;

            case 'text':
                $response = Http::post("https://graph.facebook.com/{$this->pageId}/feed", [
                    'message' => $this->data['message'] ?? '',
                    'access_token' => $this->pageToken,
                ]);
                break;
        }

        if ($response && $response->failed()) {
            \Log::error('Facebook API error: ' . $response->body());
        }

    } catch (\Exception $e) {
        \Log::error("Facebook Post Failed: " . $e->getMessage());
    }
}

   
}
