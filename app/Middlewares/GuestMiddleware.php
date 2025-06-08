<?php

namespace App\Middlewares;

use App\Support\Authentication\Auth;

/**
* Guest Middleware
*/
class GuestMiddleware
{
	protected $redirect_to = 'user/home/index';

    public function __invoke()
    {
        if (! Auth::check()) {
        	return true;
        }

        if (Auth::isAdmin()) {
            redirect('admin/home/index');
        } else if (Auth::isUser()) {
            redirect($this->redirect_to);
        }

        return false;
    }
}
