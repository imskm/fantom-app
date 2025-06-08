<?php

namespace Application\Validations;

use Fantom\Validation\Validator;

/**
 * SearchValidator class
 * to validate search
 */
class SearchValidator extends Validator
{
	public function validateSearch()
	{
		$this->validate("GET", [
			'q' 		=> 'required|max:512',
		]);
	}
}