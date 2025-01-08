<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $message;

    public function __construct(Contact $contact, $message)
    {
        $this->contact = $contact;
        $this->message = $message;
    }

    public function build()
    {
        return $this->view('emails.status_update')
                    ->with([
                        'contact' => $this->contact,
                        'message' => $this->message,
                    ]);
    }
}
