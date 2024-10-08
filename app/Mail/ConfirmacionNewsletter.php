<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmacionNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //$this->data = $data;
    }

    public function build()
    {
        return $this->subject('Confirmación de suscrpción a Vuskoo.com')
                    ->view('email.ConfirmacionNewsletter');
    }
}
