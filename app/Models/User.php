<?php

namespace App\Models;

use Fantom\Database\Model;

/**
 * User model
 */
class User extends Model
{
	protected $primary = 'id';
	protected $table   = 'users';

	public static function make(array $data)
	{
		$user = new static;

		$user->first_name 	= title_case(trim($data['first_name']));
		$user->last_name 	= title_case(trim($data['last_name']));
		$user->email 		= strtolower(trim($data['email']));
		$user->password 	= password_hash(trim($data['password']), PASSWORD_DEFAULT);

		return $user;
	}
}