<?php

namespace App\Jobs;

use App\Mail\NewsletterPostMail;
use App\Models\Newsletter;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queueing\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    protected int $postId;

    public function __construct(int $postId)
    {
        $this->postId = $postId;
    }

    public function handle(): void
    {
        $post = Post::with('category', 'image')->find($this->postId);

        if (!$post || !$post->approved || !$post->category) {
            return;
        }

        Newsletter::whereHas('categories', function ($query) use ($post) {
            $query->where('categories.id', $post->category_id);
        })->chunk(100, function ($subscribers) use ($post) {
            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->send(new NewsletterPostMail($post));
            }
        });
    }
}
