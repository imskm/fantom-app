<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Fantom\Controller;
use App\Models\PasswordReset;
use App\Middlewares\GuestMiddleware;
use Fantom\Support\Auth\Interfaces\ForgotPassword;
use Fantom\Support\Auth\Traits\SendPasswordResetEmails;

/**
 * ForgotPasswordController
 */
class ForgotPasswordController extends Controller implements ForgotPassword
{
	private $redirect_to = "/auth/login";

	use SendPasswordResetEmails;

	public function getUserModel()
	{
		return new User();
	}

	public function getPasswordResetModel()
	{
		return new PasswordReset();
	}

	public function redirectTo()
	{
		return $this->redirect_to;
	}

	protected function before()
	{
		return (new GuestMiddleware)();
	}
}