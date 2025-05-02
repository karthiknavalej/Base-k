<?php

namespace App\Facades\Helper;

// Jobs
use App\Jobs\SendEmailQueue;
use SendGrid\Mail\Mail;
// Request
use Illuminate\Http\Request;
use Log;
use SendGrid;

class SendMail
{
    /**
    * Send mail to reset password
    *
    * @method forgotPassword
    *
    * @param object $user, Request $request
    *
    * @return void
    *
    */
    public function forgotPassword(object $user)
    {
        
        $template_id = config('constants.sendgrid_template_ids.FORGOT_PASSWORD');
        $toEmailIds = [
            $user->email => $user->email
        ];
        $emailBodyArray = [
            // 'password' => $newPassword,
            'contact_mail_id' => "Example@gmail.com",
        ];
        return self::sendMail($template_id, $toEmailIds, $emailBodyArray);
    }
    
    public function sendUserRegistrationMail(array $data){

        $template_id = config('constants.sendgrid_template_ids.USER_REGISTRATION');
        
        $toEmailIds = [
            $data['user']['email'] => $data['user']['name']
        ];
        $emailBodyArray = [
            'to' => ['email' => $data['user']['email']],
            // 'password' => $data['password']
        ];
        
        return self::sendMail($template_id, $toEmailIds, $emailBodyArray);
    }

    public static function sendMail($template_id, $toEmailIds, $emailBodyArray,$attachment=[],$cc="")
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("sandip.kb@nichi.com", "BaseFrameWork");
        
        $email->addTos($toEmailIds);
        if (!empty($cc)) {
            $email->addCc($cc);
        }
        $email->addDynamicTemplateDatas($emailBodyArray);
        $email->setTemplateId($template_id);
        foreach ($attachment as $attachment) {
            $email->addAttachment($attachment);
        }
        try {
            $sendgrid = new SendGrid(env('services.sendgrid.api_key'));
            $response = $sendgrid->send($email);
            Log::debug(['sendgrid' => $response]);
            return $response;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return trans('messages.admin_mail_fails');
        }
    }
}
