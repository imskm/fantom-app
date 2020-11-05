<?php

namespace App\Models;

use Fantom\Database\Model;
use App\Support\Traits\LastErrorTrait;

/**
 * User model
 */
class User extends Model
{
	protected $primary = 'id';
	protected $table   = 'users';

	use LastErrorTrait;

	public static function make(array $data)
	{
		$user = new static;

		$user->first_name 	= title_case(trim($data['first_name']));
		$user->last_name 	= title_case(trim($data['last_name']));
		$user->email 		= strtolower(trim($data['email']));
		$user->password 	= password_hash(trim($data['password']), PASSWORD_DEFAULT);

		return $user;
	}

	public function changePassword($old_password, $new_password)
	{
		if (! password_verify($old_password, $this->password)) {
			$this->setError("Old password doesn't match in database.");
			return false;
		}

		$this->password = password_hash($new_password, PASSWORD_DEFAULT);
		
		if ($this->save() === false) {
			$this->setError("Failed to update new password.");
			return false;
		}

		return true;
	}
}
