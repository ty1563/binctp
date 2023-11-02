<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class XacNhanResetAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $hash_reset;
    public function __construct($hash_reset)
    {
        $this->hash_reset = $hash_reset;
    }

    public function build()
    {
        return $this->subject('[BinCtp.com] Mã Xác Nhận')
                    ->view('Admin.Admin.MailResetPassWord', [
                        'hash_reset' => $this->hash_reset,
                    ]);
    }

}
