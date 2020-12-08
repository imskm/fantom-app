<?php

namespace App\Support\Traits;

/**
 * This tait is helpful when an object performs action and need to provide
 * caller some way to know exact error message.
 * It only keeps track of last error just like in C errno API.
 */
trait LastErrorTrait
{
	/**
	 * Naming of instance variable is done this way to avoid collision by
	 * actual class that also has the error variable.
	 * Naming this way will avoid double declaration fatal error
	 */
	private $_last_error = "";

	public function setLastError($message)
	{
		$this->_last_error = $message;
	}

	public function getLastError()
	{
		return $this->_last_error;
	}
}
