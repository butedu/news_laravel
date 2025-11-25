<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public Contact $contact;
    public ContactReply $reply;
    public User $admin;

    public function __construct(Contact $contact, ContactReply $reply, User $admin)
    {
        $this->contact = $contact;
        $this->reply = $reply;
        $this->admin = $admin;
    }

    public function build(): self
    {
        return $this->subject($this->reply->subject)
            ->view('emails.contact_reply')
            ->with([
                'contact' => $this->contact,
                'reply' => $this->reply,
                'admin' => $this->admin,
            ]);
    }
}
