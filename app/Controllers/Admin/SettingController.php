<?php

namespace App\Controllers\Admin;

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
		$user = Auth::user();
		$this->view->render('Admin/Setting/index.php', [
			"user" => $user
		]);
	}

	protected function before()
	{
		return (new AuthMiddleware)();
	}
}