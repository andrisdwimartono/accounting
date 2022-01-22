<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;
    private $otp;
    private $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_otp, $_name)
    {
        $this->otp = $_otp;
        $this->name = $_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        //return $this->view('view.name');
        return $this->from('maosinfotesting@gmail.com')
                   ->view('emailku')
                   ->with(
                    [
                        'nama' => $this->name,
                        'otp' => $this->otp
                    ]);

    }
}
