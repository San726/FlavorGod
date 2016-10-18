<?php 

namespace Flavorgod\Validators;

use Illuminate\Contracts\Validation\Factory;

class ProfileValidator
{
	protected $validator;

	public function __construct(Factory $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Return validator instance when updating customer profile
	 * @param array $data 
	 */
	public function updateProfile($data)
	{
		return $this->validator->make($data, [
			'first_name' => 'required|max:64',
			'last_name' => 'required|max:64'
		]);
	}
}