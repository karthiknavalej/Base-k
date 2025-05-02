<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $subject = "";
    public $view = "";
    public $body = "";

    /**
     * Create a new message instance.
     *
     * @return void
    */
    public function __construct($data)
    {
        $this->subject = $data['subject'];
        $this->view = $data['view'];
        $this->body = $data['body'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject($this->subject);
        $mail = $mail->markdown($this->view);
        $mail = $mail->with(['body' => $this->body]);
        return $mail;
    }
}
