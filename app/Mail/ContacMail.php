<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Route;

class ContacMail extends Mailable implements ShouldQueue
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
    public $contactId;

    public function __construct($firstname, $secondname, $email, $subject, $message, $attachmentPath = null, $attachmentName = null, $attachmentMime = null, $contactId = null)
    {
        $this->firstname = $firstname;
        $this->secondname = $secondname;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->attachmentPath = $attachmentPath;
        $this->attachmentName = $attachmentName;
        $this->attachmentMime = $attachmentMime;
        $this->contactId = $contactId;
    }

    public function build()
    {
        $attachmentUrl = null;

        if ($this->attachmentPath) {
            if ($this->contactId && Route::has('admin.contacts.attachment')) {
                $attachmentUrl = route('admin.contacts.attachment', ['contact' => $this->contactId]);
            }

            if (!$attachmentUrl) {
                $attachmentUrl = asset('storage/' . ltrim($this->attachmentPath, '/'));
            }
        }

        $mail = $this->subject('VN News | Liên hệ mới: ' . $this->subject)
            ->markdown('emails.contact', [
                'hasAttachment' => (bool) $this->attachmentPath,
                'attachmentName' => $this->attachmentName,
                'attachmentUrl' => $attachmentUrl,
                'contactShowUrl' => ($this->contactId && Route::has('admin.contacts.show')) ? route('admin.contacts.show', ['contact' => $this->contactId]) : url('/admin/contacts'),
            ]);

        if ($this->attachmentPath) {
            $mail->attachFromStorageDisk('public', $this->attachmentPath, $this->attachmentName ?? basename($this->attachmentPath), [
                'mime' => $this->attachmentMime,
            ]);
        }

        return $mail;
    }
}
