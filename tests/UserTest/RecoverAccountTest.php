<?php

declare(strict_types=1);

use App\Models\User;
use PHPUnit\Framework\TestCase;

final class RecoverAccountTest extends TestCase
{
	public function testUserObjectCanBeCreated()
	{
		$this->assertInstanceOf(User::class, new User());
	}

	public function test_recover_account(): void
	{
		// @TODO
	}
}