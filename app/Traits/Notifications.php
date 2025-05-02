<?php
/**
 * This trait applies accessors and mutators to a model attributes if the config setting to encrypt data at rest is on
 */

namespace App\Traits;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

use App\Models\UserDeviceDetails;
use App\Models\User;

/**
 * Class Notifications
 *
 * @package App\Lib\Domain\Models
 */
trait Notifications
{
    /**
     * Accessor - decrypts the value
     *
     * @access public
     * @param $user_id
     * @param $header
     * @param $message
     */
    public function sendPushNotifications(object $notificationDetails)
    {
            $notificationDetails = array_except($notificationDetails->toArray(),['details','created_by']);  
            //$notificationAcivatedUsers = UserProfile::where('notification_flag',0)->pluck('user_id')->toArray();
            $userIds = User::pluck('id')->toArray();
    		$users = UserDeviceDetails::select('device_token')->whereIn('user_id',$userIds)->get();
            $user_tokens = collect($users)->pluck('device_token')->unique()->toArray();

            if (sizeOf($user_tokens)) {
                //FCM notification
                $optionBuilder = new OptionsBuilder();
                $optionBuilder->setTimeToLive(60 * 20);

                $notificationBuilder = new PayloadNotificationBuilder($notificationDetails['title']);
                $notificationBuilder->setBody($notificationDetails['subject'])
                                        ->setSound('default');

                $dataBuilder = new PayloadDataBuilder();
                $dataBuilder->addData(['event' => $notificationDetails['title'], 'message' => $notificationDetails['subject'], 'data' => $notificationDetails]);

                $option = $optionBuilder->build();
                $notification = $notificationBuilder->build();
                $data = $dataBuilder->build();
                $downstreamResponse = FCM::sendTo($user_tokens, $option, $notification, $data);
            }
            return true;
    }
}
