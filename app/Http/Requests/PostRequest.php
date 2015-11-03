<?php namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return
		[
			'title' => 'required|max:255',
			'read_more' => 'required|max:65000',
			'Pcontent' => 'required|max:65000',
			'tag' => 'required'
		];
	}
	/**
	 * {@inheritdoc}
	 */
	protected function formatErrors(Validator $validator)
	{
		return $validator->errors()->all();
	}	
   	public function response(array $errors)
    {
		$response="";
		foreach ($errors as $key => $value)
			$response = $response.$value."<br>";
        return response()->json($response,400);
    }	

}