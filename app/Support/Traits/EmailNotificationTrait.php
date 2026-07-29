<?php

namespace App\Support\Traits;

use App\Config;
use Fantom\Log\Log;
use App\Support\Mail\Mail;

trait EmailNotificationTrait
{
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