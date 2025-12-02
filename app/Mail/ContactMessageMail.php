<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $messageContent;
    public $referenceId; // can be order ID or generated reference

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $email
     * @param string $messageContent
     * @param string $referenceId
     */
    public function __construct($name, $email, $messageContent, $referenceId)
    {
        $this->name = $name;
        $this->email = $email;
        $this->messageContent = $messageContent;
        $this->referenceId = $referenceId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Contact Message from TryMyWatch Website')
                    ->view('emails.contact_message');
    }
}
