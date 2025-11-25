<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContacMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $secondname;
    public $email;
    public $subject;
    public $message;
    public $attachmentPath;
    public $attachmentName;
    public $attachmentMime;

    public function __construct($firstname, $secondname, $email, $subject, $message, $attachmentPath = null, $attachmentName = null, $attachmentMime = null)
    {
        $this->firstname = $firstname;
        $this->secondname = $secondname;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->attachmentPath = $attachmentPath;
        $this->attachmentName = $attachmentName;
        $this->attachmentMime = $attachmentMime;
    }

    public function build()
    {
        $mail = $this->subject('VN News | Liên hệ mới: ' . $this->subject)
            ->markdown('emails.contact', [
                'hasAttachment' => (bool) $this->attachmentPath,
                'attachmentName' => $this->attachmentName,
                'attachmentUrl' => $this->attachmentPath ? asset('storage/' . $this->attachmentPath) : null,
            ]);

        if ($this->attachmentPath) {
            $mail->attachFromStorageDisk('public', $this->attachmentPath, $this->attachmentName ?? basename($this->attachmentPath), [
                'mime' => $this->attachmentMime,
            ]);
        }

        return $mail;
    }
}
