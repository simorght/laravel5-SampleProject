<?php namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends Request {

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
		return
		[
			'commenter' => 'required|min:3|max:255',
			'email' => 'required|email',
			'comment' => 'required|min:4|max:65000',
			'pst_id' => 'required'
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
