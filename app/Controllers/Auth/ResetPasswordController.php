<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Fantom\Controller;
use App\Models\PasswordReset;
use App\Middlewares\GuestMiddleware;
use Fantom\Support\Auth\Traits\ResetPasswords;
use Fantom\Support\Auth\Interfaces\ResetPassword;

/**
 * ResetPassword Controller
 */
class ResetPasswordController extends Controller implements ResetPassword
{
	private $redirect_to = "/auth/login";

	use ResetPasswords;

	public function getPasswordResetModel()
	{
		return new PasswordReset();
	}

	public function getUserModel()
	{
		return new User();
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