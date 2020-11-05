<?php

namespace App\Support\Authentication;

use Fantom\Session;
use App\Models\User;

/**
* Authentication Support class
* Handles Authenticating User and fetching current authenticated user.
*/
class Auth
{
	private static $user = null;
	private static $error = "";

	public static function attempt($email, $password)
	{
		$user = User::where('email', $email)->first();
		if(! $user) {
			return false;
		}

		if (! password_verify($password, $user->password)) {
			return false;
		}

		Session::set('user_id', $user->id);

		return true;
	}

	public static function user()
	{
		if (! self::$user) {
			self::$user = User::find(self::userId())->first();
		}
		
		return self::$user;
	}

	public static function userId()
	{
		return Session::get('user_id');
	}

	public static function check()
	{
		return Session::get('user_id') !== null;
	}

	public static function logout()
	{
		Session::delete('user_id');
		return Session::destroy();
	}

	public static function create(array $data)
	{
		$user = User::make($_POST);

		return $user->save();
	}

	public static function attemptChangePassword($old, $new)
	{
		$user = self::user();

		if(! $user) {
			self::$error = "User is not logged in or found.";
			return false;
		}

		if ($user->changePassword($old, $new) === false) {
			self::$error = $user->getError();
			return false;
		}

		return true;
	}

	public static function error()
	{
		return self::$error;
	}
}
