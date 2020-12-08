<?php

namespace App\Models;

use App\Config;
use Fantom\Log\Log;
use Fantom\Database\Model;
use App\Support\Mail\Mail;
use App\Support\Traits\LastErrorTrait;
use App\Support\Traits\NotificationTrait;
use Fantom\Support\Auth\User as Authenticatable;

/**
 * User model
 */
class User extends Authenticatable
{
	protected $primary = 'id';
	protected $table   = 'users';

	use LastErrorTrait;
	use NotificationTrait;

	public static function make(array $data)
	{
		$user = new static;

		$user->first_name 	= title_case(trim($data['first_name']));
		$user->last_name 	= title_case(trim($data['last_name']));
		$user->email 		= strtolower(trim($data['email']));
		$user->password 	= password_hash(trim($data['password']), PASSWORD_DEFAULT);

		return $user;
	}

	public function sendPasswordResetLinkByEmail(array $data): bool
	{
		$email = $data['user']->email;
        $full_name = $data['user']->first_name . ' ' . $data['user']->last_name;
        $company_email = Config::get('mail_sender_email');
        $sender_fullname = Config::get("mail_sender_name");

        $mail = new Mail(
            $company_email,
            $sender_fullname
        );

        $template = VIEW_PATH . '/templates/mail/forgot_password.php';
        $recipients = [
            $email,
        ];

        $variables = [
            'full_name' => $full_name,
            'email'     => $email,
            'token'     => $data['password_reset']->token,
        ];

        $ret = true;
        try {
            $mail->useTemplate($template, $variables)
                ->setSubject("Recover your account - " . Config::get('site_name'))
                ->setReplyTo($company_email, $sender_fullname)
                ->send($recipients);
            if ($mail->hasFailedAny()) {
                $ret = false;
                $this->setLastError("Failed to send email. Please try later.");
            }
        } catch (\Exception $e) {
            Log::warning("mail: " . $e->getMessage());
            $this->setLastError("Failed to send email. Please try later.");
            $ret = false;
        }

        return $ret;
	}

}
