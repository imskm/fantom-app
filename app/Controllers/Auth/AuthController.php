<?php

namespace App\Controllers\Auth;

use Fantom\Session;
use Fantom\Controller;
use App\Middlewares\GuestMiddleware;
use App\Support\Authentication\Auth;
use App\Support\Validations\AuthValidator;

/**
 * AuthController class
 */
class AuthController extends Controller
{
	protected function login()
	{
		$this->view->render('Auth/login.php');
	}

	protected function register()
	{
		$this->view->render('Auth/register.php');
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