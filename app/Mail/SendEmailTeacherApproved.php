<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailTeacherApproved extends Mailable
{
        use Queueable, SerializesModels;

        public $teacher;

    public function __construct($teacher)
    {
         $this->teacher = $teacher;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
        subject: 'Cadastro aprovado como professor'
        );
    }

        public function content(): Content
        {
        return new Content(
            view: 'emails.teacher_approved',
            with: [
        'teacher' => $this->teacher
        ]
        );
        }

        public function attachments(): array
        {
        return [];
        }
}
