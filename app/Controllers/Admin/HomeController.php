<?php

namespace App\Controllers\Admin;

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
		$this->view->render('Admin/Home/index.php');
	}

	protected function before()
	{
		return (new AuthMiddleware)();
	}
}