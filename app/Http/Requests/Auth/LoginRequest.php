<?php namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	  public function authorize() {
		return true;
	  }
	public function rules()
	{
		return [
			'user_name' => 'required', 'password' => 'required',
		];
	}

}
