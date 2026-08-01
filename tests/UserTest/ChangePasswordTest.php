<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Support\Authentication\Auth;

final class ChangePasswordTests extends TestCase
{
	public function testAuthObjectCanBeCreated()
	{
		$this->assertInstanceOf(Auth::class, new Auth());
	}

	public function testPassesForValidPasswordChangeUsingAuthClass()
	{
		$_SESSION['user_id'] = 1;
		$auth = new Auth();
		$this->assertTrue($auth->attemptChangePassword('12345678', 'newpassword'));
	}

	public function testPassesForValidPasswordChangeUsingAuthClassUndo()
	{
		$_SESSION['user_id'] = 1;
		$auth = new Auth();
		$this->assertTrue($auth->attemptChangePassword('newpassword', '12345678'));
	}
}

