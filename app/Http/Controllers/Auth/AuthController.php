<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  App\Http\Requests\LoginRequest  $request
	 * @param  App\Services\MaxValueDelay  $maxValueDelay
	 * @param  Guard  $auth
	 * @return Response
	 */
	public function postLogin(
		LoginRequest $request,
		Guard $auth)
	{
		$logValue = $request->input('user_name');

		$logAccess = filter_var($logValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        $throttles = in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
			return redirect('/auth/login')
				->with('error', trans('layout/template.maxattempt'))
				->withInput($request->only('user_name'));
        }

		$credentials = [
			$logAccess  => $logValue, 
			'password'  => $request->input('password')
		];

		if(!$auth->validate($credentials)) {
			if ($throttles) {
	            $this->incrementLoginAttempts($request);
	        }

			return redirect('/auth/login')
				->with('error', trans('layout/template.credentials'))
				->withInput($request->only('user_name'));
		}
			
		$user = $auth->getLastAttempted();

		if($user->confirmed) {
			if ($throttles) {
                $this->clearLoginAttempts($request);
            }

			$auth->login($user, $request->has('remember'));
			$request->session()->put('id', $user->id);
			$request->session()->put('name', $user->name);
			return redirect('/admin');
		}
		
		if($request->session()->has('id'))
		{
			$request->session()->forget('id');
			$request->session()->forget('name');
		}
		return redirect('/auth/login')->with('error', trans('layout/verify.again'));			
	}
	public function getLogout() {
		 auth()->logout();
		 session()->flush();
		return redirect()->back();
}	
}
