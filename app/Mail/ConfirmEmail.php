<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $hash_active;
    public function __construct($hash_active)
    {
        $this->hash_active = $hash_active;
    }

    public function build()
    {
        return $this->subject('Xác Minh Email')
                    ->view('Client.Mail.mail_confirm', [
                        'hash_active' => $this->hash_active,
                    ]);
    }
}
