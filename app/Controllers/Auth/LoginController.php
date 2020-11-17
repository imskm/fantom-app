<?php

namespace App\Controllers\Auth;

use Fantom\Session;
use Fantom\Controller;
use App\Middlewares\GuestMiddleware;
use App\Support\Authentication\Auth;
use App\Support\Validations\AuthValidator;

/**
 * LoginController
 */
class LoginController extends Controller
{
	protected function index()
	{
		$this->view->render("Auth/Login/index.php");
	}

	protected function authenticate()
	{
		$validator = AuthValidator::validateLogin();

		// No need to set the error in the session
		// it is already handled by view
		if ($validator->hasError()) {
			redirect('auth/login');
		}

		if (!Auth::attempt($_POST['email'], $_POST['password'])) {
			Session::flash('error', 'Invalid email or password.');
			redirect('auth/login');
		}

		redirect('user');
	}

	public function logout()
	{
		Auth::logout();
		redirect('/');
	}

	protected function before()
	{
		return (new GuestMiddleware)();
	}
}