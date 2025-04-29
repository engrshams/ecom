<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class verifyMailer extends Mailable{
    use Queueable, SerializesModels;

    public $otp;
    public function __construct($otp){
        $this->otp = $otp;}

    public function envelope(): Envelope{
        return new Envelope(
            subject: 'Verify Mailer',
        );}

    public function content(): Content{
        return new Content(
            view: 'emails.verify',
        );}

    public function attachments(): array{
        return [];}
}
