<?php

namespace App\Jobs;

use App\Mail\ContacMail;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Contact $contact, public string $recipient)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty($this->recipient)) {
            return;
        }

        Mail::to($this->recipient)->send(new ContacMail(
            $this->contact->first_name,
            $this->contact->last_name,
            $this->contact->email,
            $this->contact->subject,
            $this->contact->message,
            $this->contact->attachment_path,
            $this->contact->attachment_original_name,
            $this->contact->attachment_mime,
            $this->contact->getKey()
        ));
    }
}
