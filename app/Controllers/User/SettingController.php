<?php

namespace App\Controllers\User;

use Fantom\Session;
use Fantom\Controller;
use App\Middlewares\AuthMiddleware;
use App\Support\Authentication\Auth;
use App\Support\Validations\AuthValidator;

/**
 * ProfileController class
 */
class SettingController extends Controller
{
	protected function index()
	{
		$this->view->render('User/Setting/index.php');
	}

	protected function changePassword()
	{
		$validator = AuthValidator::validateChangePassword();
		if ($validator->hasError()) {
			redirect('user/setting');
		}

		$old_password = trim($_POST['old_password']);
		$new_password = trim($_POST['password']);
		if (!Auth::attemptChangePassword($old_password, $new_password)) {
			Session::flash('error', Auth::error());
		} else {
			Session::flash('success', 'Password changed successfully.');
		}

		redirect('user/setting');
	}

	protected function before()
	{
		return (new AuthMiddleware)();
	}
}