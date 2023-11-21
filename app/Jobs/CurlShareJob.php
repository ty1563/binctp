<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CurlShareJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post_id;

    public function __construct($post_id)
    {
        $this->post_id = $post_id;
    }

    public function handle()
    {
        $token = 'EAABwzLixnjYBOxzN2eldXZCFLu4Szg1WgbmanEHAQ2hKnu5Yn674jt9yUU6E0RmPEQZBlqexAVI0enKiAZAyGZBtjUXC6ZBlK6sEZA66B785ViLgEH81r6gZC0cxAmMTJsBQ5f0viYsPCrnXrv2rRm0kio6NCowH5ZAkU2o9UfZBOopMZBvnXarsRbrQZB9n2eCOBvnFx0ZD';

        $response = Http::get('https://graph.fb.me/me/accounts', [
            'access_token' => $token,
            'method' => 'get'
        ]);

        if ($response->successful()) {
            $ds = $response->json();
            foreach ($ds['data'] as $data) {
                $response = Http::get('https://graph.fb.me/' . $this->post_id . '/sharedposts', [
                    'access_token' => $data['access_token'],
                    'method' => 'post'
                ]);

                if ($response->successful()) {
                    // Xử lý thành công
                } else {
                    // Xử lý thất bại
                }
            }
        }
    }
}
