<?php

namespace App\Models;

use Fantom\Support\Auth\PasswordReset as AccountRecovery;


/**
 * PasswordReset Model
 */
class PasswordReset extends AccountRecovery
{
	protected $table = "password_resets";
	protected $primary = "id";

}