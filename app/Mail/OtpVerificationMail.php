<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $user;
    public $expiryMinutes;

    public function __construct($otp, $user, $expiryMinutes = 10)
    {
        $this->otp = $otp;
        $this->user = $user;
        $this->expiryMinutes = $expiryMinutes;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Kode OTP Verifikasi Akun - ' . config('app.name'),
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.otp-verification',
            with: [
                'otp' => $this->otp,
                'user' => $this->user,
                'expiryMinutes' => $this->expiryMinutes,
                'appName' => config('app.name'),
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
