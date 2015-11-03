<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class IsAjax {

	public function handle($request, Closure $next)
	{
		if ($request->ajax())
		{
			return $next($request);			
		}
		abort(404);
	}

}
