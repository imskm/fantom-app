<?php

namespace App\Support\Validations;

use Fantom\Validation\Validator;

/**
 * AuthValidation class
 * To handle all vlidations related authentication
 */
class AuthValidator extends Validator
{
	public static function validateRegistration()
	{
		$v = new static;
		$v->validate("POST", [
			"first_name" 	=> "required|alpha_space|max:32",
			"last_name" 	=> "required|alpha_space|max:32",
			"email" 		=> "required|email|unique:users,email",
			"password" 		=> "required|min:6|max:16",
			"confirm" 		=> "required|confirmed:password",
		]);

		return $v;
	}

	public static function validateLogin()
	{
		$v = new static;
		$v->validate("POST", [
			"email" 		=> "required|email",
			"password" 		=> "required|min:6|max:16",
		]);

		return $v;
	}

	public static function validateChangePassword()
	{
		$v = new static;
		$v->validate("POST", [
			"old_password" 	=> "required|min:6|max:16",
			"password" 		=> "required|min:6|max:16",
			"confirm" 		=> "required|confirmed:password",
		]);

		return $v;
	}
}