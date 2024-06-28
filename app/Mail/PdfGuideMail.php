<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PdfGuideMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $userName;
    public function __construct($pdf, $userName)
    {
        $this->pdf = $pdf;
        $this->userName = $userName;
    }

    public function build(): self
    {
        return $this->markdown('emails.pdf_guide', ['userName' => $this->userName])
            ->subject('Your Property Buying Guide')
            ->attachData($this->pdf, 'property_buying_guide.pdf', [
                'mime' => 'application/pdf',
            ]);
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pdf Guide Mail',
        );
    }


    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pdf_guide',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
