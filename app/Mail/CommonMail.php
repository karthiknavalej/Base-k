<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommonMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    protected $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template, $data)
    {
        $this->template = $template;
        $this->data = $data;
        $this->data['backend_api_url'] = env('APP_URL');
        $this->data['frontend_business_url'] = Config('constants.FRONTEND_BUSINESS_URL');
        $this->data['frontend_admin_url'] = Config('constants.FRONTEND_ADMIN_URL');
        $this->data['contact_mail_id'] = Config('constants.CONTACT_MAIL_ID');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailSubject($this->template))
                ->view("mails.{$this->template}", $this->data);
    }

    /**
     * Return Template Subject
     * 
     * @param $key String
     *
     * @return $string
     */
    private function mailSubject($key)
    {
        $subjects = ['forgot_password_mail' => '【才能データバンク】ログインパスワード再設定のご案内',
                    'registration_approval_mail' => '[タレントデータバンク]アカウントが更新されました。 ',
                    'member_request_approval_mail' => '【才能データバンク】アカウントが作成されました。',
                    'otp_mail' => '[タレントデータバンク]ユーザーのアカウントOTP'];
                    
        return $subjects[$key];            
    }
}
