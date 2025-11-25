<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queueing\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class NewsletterPostMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\Post
     */
    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function build(): self
    {
        $subject = 'Tin mới từ ' . config('app.name') . ': ' . Str::limit($this->post->title, 80);

        return $this->subject($subject)
            ->view('emails.newsletter.new-post');
    }
}
