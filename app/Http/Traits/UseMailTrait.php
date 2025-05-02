<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonMail;
use Illuminate\Support\Facades\Log;

trait UseMailTrait {

    public function mailProcess($emailId, $template, $data){
        try {
            return Mail::to($emailId)->send(new CommonMail($template, $data));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return trans('messages.PROCESS_MAIL_FAILS');
        }
    } 

}