<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{

	public function authorize()
	{
		// Honeypot 
		return  true;//$this->input('address') == '';
	}
	protected function formatErrors(Validator $validator)
	{
		return $validator->errors()->all();
	}	
}
