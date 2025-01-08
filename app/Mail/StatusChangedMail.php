<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $statusMessage;
    public $newStatus;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact, $newStatus, $statusMessage)
    {
        $this->contact = $contact;
        $this->newStatus = $newStatus;
        $this->statusMessage = $statusMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Contact Status has been Updated')
                    ->view('emails.status_update')
                    ->with([
                        'uni_id' => $this->contact->uni_id,
                        'service' => $this->contact->service,
                        'status' => $this->newStatus,
                        'status_message' => $this->statusMessage,
                    ]);
    }
}
