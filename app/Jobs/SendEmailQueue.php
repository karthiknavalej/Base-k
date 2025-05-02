<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ForgotPasswordMail;
use Mail;

class SendEmailQueue implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $email = "";
    protected $data = "";
    protected $type = "";
    
    /**
     *
     * Create a new job instance.
     *
     * @return void
     *
     */
    public function __construct($data, $type)
    {
        $this->email = $data['email'];
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->type) {
            case 'forgot':
                $email = new ForgotPasswordMail($this->data);
            break;
        }
        
        Mail::to($this->email)->send($email);
    }
}
