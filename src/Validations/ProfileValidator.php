<?php

namespace Application\Validations;

use Fantom\Validation\Validator;
use App\Support\Authentication\Auth;
use App\Support\Validations\ImageValidationRuleTrait;

/**
 * ProfileValidator class
 * to validate User profile create and update
 */
class ProfileValidator extends Validator
{
	use ImageValidationRuleTrait;

	public function validatePhotoUpdate()
	{
		$this->validate("POST", [
			'photos' 		=> 'required_file|xfile:image,102400' // type,file_size(1024*100 = 100KB)
		]);
	}

	public function validatePersonalInfoUpdate()
	{
		$this->validate("POST", [
			'first_name' 	=> 'required|alpha_space|max:32',
			'last_name' 	=> 'required|alpha_space|max:32',
			'phone' 		=> 'required|phone|unique_xself:users,phone,id,' . Auth::userId(),
		]);
	}
	
}