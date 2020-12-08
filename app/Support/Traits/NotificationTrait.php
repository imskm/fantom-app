<?php

namespace App\Support\Traits;

use App\Config;
use Fantom\Log\Log;
use SendSMS\Textlocal;

trait NotificationTrait
{
	public function notifyBySMS($message)
	{
		$apikey 	= Config::get("sms_apikey");
		// When api key is given then no username and hash is required
		$textlocal 	= new Textlocal($username = false, $hash = false, $apikey);

		$receivers 	= ['91' . $this->phone ];
		$sender 	= Config::get("sms_sender");
		$mode 		= Config::get("sms_mode");

		$ret = true;
		try {
			$response = $textlocal->sendSms(
				$receivers,
				$message,
				$sender,
				null,
				$mode
			);
		} catch (\Exception $e) {
			// @TODO Log the error message
			// var_dump($e->getMessage());
			Log::error("sms: " . $e->getMessage());
			$ret = false;
		}

		return $ret;
	}

	public function notifyByEmail(array $options)
	{
		$template = $options['template'];
		$subject  = $options['subject'];
		$argv 	  = $options['argv'];
		
		$mail = new Mail(
            Config::get("mail_sender_email"),
            Config::get("mail_sender_name")
        );
        $argv['user'] = $this;

        $ret = true;
        try {
            $mail->useTemplate($template, $argv)
                    ->setSubject($subject)
                    ->send([$this->email]);
            $ret = !$mail->hasFailedAny();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $ret = false;
        }

        return $ret; 
	}
}