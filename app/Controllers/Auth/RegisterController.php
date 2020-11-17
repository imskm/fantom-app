<?php

namespace App\Controllers\Auth;

use Fantom\Session;
use Fantom\Controller;
use App\Middlewares\GuestMiddleware;
use App\Support\Authentication\Auth;
use App\Support\Validations\AuthValidator;

/**
 * RegisterController
 */
class RegisterController extends Controller
{
	protected function index()
	{
		$this->view->render("Auth/Register/index.php");
	}

	protected function store()
	{
		$validator = AuthValidator::validateRegistration();

		// No need to set the error in the session
		// it is already handled by view
		if ($validator->hasError()) {
			redirect('auth/register');
		}

		if (Auth::create($_POST) === false) {
			Session::flash('error', 'Failed to create user.');
			redirect('auth/register');
		}

		Session::flash('success', 'Account created successfully.');

		redirect('auth/login');
	}

	protected function before()
	{
		return (new GuestMiddleware)();
	}
}