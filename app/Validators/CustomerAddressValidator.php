<?php 

namespace Flavorgod\Validators;

use Illuminate\Contracts\Validation\Factory;

class CustomerAddressValidator
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
	public function update($data)
	{
		return $this->validator->make($data, [
			'address_street' => 'required|max:200',
			'address_country_name' => 'required|max:2',
			'address_state' => 'required|max:200',
			'address_city' => 'required|max:200',
			'address_zip' => 'required|max:20'
		], [
			'address_street.required' => 'The street address field is required.',
			'address_street.max' => 'The street address field is too long.',
			'address_state.required' => 'The state field is required.',
			'address_state.max' => 'The state field is too long',
			'address_city.required' => 'The city field is required',
			'address_city.max' => 'The city field is too long',
			'address_zip.required' => 'The zip code is required.',
			'address_zip.max' => 'The zip code is too long.'

		]);
	}

	/**
	 * Return validator instance when updating customer profile
	 * @param array $data 
	 */
	public function store($data)
	{
		return $this->validator->make($data, [
			'address_street' => 'required|max:200',
			'address_country_name' => 'required|max:2',
			'address_state' => 'required|max:200',
			'address_city' => 'required|max:200',
			'address_zip' => 'required|max:20'
		], [
			'address_street.required' => 'The street address field is required.',
			'address_street.max' => 'The street address field is too long.',
			'address_state.required' => 'The state field is required.',
			'address_state.max' => 'The state field is too long',
			'address_city.required' => 'The city field is required',
			'address_city.max' => 'The city field is too long',
			'address_zip.required' => 'The zip code is required.',
			'address_zip.max' => 'The zip code is too long.'

		]);
	}
}