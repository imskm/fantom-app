<?php

namespace App\Controllers\User;

use Fantom\Controller;
use App\Middlewares\AuthMiddleware;
use App\Support\Authentication\Auth;

/**
 * HomeController class
 */
class HomeController extends Controller
{
	protected function index()
	{
		$this->view->render('User/Home/index.php');
	}

	protected function before()
	{
		return (new AuthMiddleware)();
	}
}