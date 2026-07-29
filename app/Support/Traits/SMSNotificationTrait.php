<?php

namespace App\Support\Traits;

use App\Config;
use Fantom\Log\Log;
use SendSMS\Textlocal;

trait SMSNotificationTrait
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
}