<?php

namespace App\Handlers\Events;

use Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

use App\Events;
use App\Models\User;

class AuthLoginEventHandler
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * برای ثبت و دریافت زمان و آی پی آخرین لاگین
     * این ایونت در ایونت سرویس پرو وایدر حین لاگین لیسن می گردد
     * @param  User $user
     * @return void
     */
    public function handle(User $user)
    {
		session()->put('last_login_at', $user->last_login_at);
		session()->put('last_login_ip', $user->last_login_ip);
		
		date_default_timezone_set(config('app.timezone','UTC'));
		$user->last_login_at = date('Y-m-d H:i:s');
		
		$request = request()->instance();
		$request->setTrustedProxies(array('127.0.0.1')); // only trust proxy headers coming from the IP addresses on the array (change this to suit your needs)

		$user->last_login_ip = $request->getClientIp(true);
		$user->save();
    }

}
