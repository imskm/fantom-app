<?php

namespace Application\Repositories;

use App\Models\User;
use App\Support\Authentication\Auth;
use Application\Traits\ModelOperationsTrait;

/**
 * UserRepository class
 */
class UserRepository extends User
{
	protected static $_table = "users";

	CONST ROLE_ADMIN = 1;
	CONST ROLE_STAFF = 2;
	CONST ROLE_AUTHOR = 3;
	CONST ROLE_USER = 9;

	use ModelOperationsTrait;

	public static function make(array $data)
	{
		$user = new static;

		$user->first_name 	= title_case(trim($data['first_name']));
		$user->last_name 	= title_case(trim($data['last_name']));
		$user->phone 		= trim($data['phone']);
		$user->gender 		= (int) $data['gender'];
		$user->password 	= password_hash(trim($data['password']), PASSWORD_DEFAULT);
		$user->role 		= self::ROLE_STAFF;
		$user->created_at 	= $user->updated_at = date("Y-m-d H:i:s");

		if ($user->gender === 1) {
			$user->photo 	= 'avatar-male.jpg';
		} else {
			$user->photo 	= 'avatar-female.jpg';
		}

		if ($data['email']) {
			$user->email 	= trim($data['email']);
		} else {
			$user->email 	= null;
		}

		return $user;
	}

	public static function change(User $user, array $data)
	{
		$user->first_name 	= title_case(trim($data['first_name']));
		$user->last_name 	= title_case(trim($data['last_name']));
		$user->phone 		= trim($data['phone']);
		$user->gender 		= (int) $data['gender'];
		$user->updated_at 	= date("Y-m-d H:i:s");

		if ($user->gender === self::GENDER_MALE) {
			$user->photo 	= 'avatar-male.jpg';
		} else {
			$user->photo 	= 'avatar-female.jpg';
		}

		if ($data['email']) {
			$user->email 	= trim($data['email']);
		} else {
			$user->email 	= null;
		}

		return $user;
	}

	public function isAdmin()
	{
		return (int) $this->role === self::ROLE_ADMIN;
	}

	public function isUser()
	{
		return (int) $this->role === self::ROLE_USER;
	}

	public function isStaff()
	{
		return (int) $this->role === self::ROLE_STAFF;
	}

	public function gender()
	{
		return (int) $this->gender === self::GENDER_MALE ? 'Male' : 'Female';
	}

	public static function updatePersonal(array $data)
	{
		$user = self::find(Auth::userId());
		$user->first_name 	= title_case(trim($data['first_name']));
		$user->last_name 	= title_case(trim($data['last_name']));
		$user->phone 		= trim($data['phone']);

		return $user;
	}

	public static function updateEmail(array $data)
	{
		$user = self::find(Auth::userId());
		$user->email 	= trim($data['email']);

		return $user;
	}

	public function isActive()
	{
		return (bool) $this->is_active;
	}

	public function isBlocked()
	{
		return (bool) $this->is_blocked;
	}

	public function makeActive()
	{
		$this->is_active = 1;
		$this->activated_at = date("Y-m-d H:i:s");

		return $this;
	}

	public function address()
	{
		return AddressRepository::findByUserId($this->id);
	}

	public function changePassword($new_password)
	{
		$hashed = password_hash($new_password, PASSWORD_DEFAULT);
		$this->password = $hashed;

		return $this->save();
	}

	public function emailAddress()
	{
		return $this->email;
	}

	public static function statsCount()
	{
		$table = self::$_table;
		$sql   = "
			SELECT COUNT(*) {$table}_count FROM $table
		";

		return static::raw($sql)->first();
	}

	public static function authors()
	{
		return self::where('role', self::ROLE_AUTHOR);
	}

}