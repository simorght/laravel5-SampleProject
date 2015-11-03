<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_tbl';


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * One to Many relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function role() 
	{
		return $this->belongsTo('App\Models\Role');
	}

	/**
	 * Check admin role
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		if (isset($this->role->slug))
			return $this->role->slug == 'admin';
		return false;	
	}

	/**
	 * Check not user role
	 *
	 * @return bool
	 */
	public function isNotUser()
	{
		if (isset($this->role->slug))
			return $this->role->slug != 'user';
		return false;	
	}

	/**
	 * Check media all access
	 *
	 * @return bool
	 */
	public function accessMediasAll()
	{
	    return $this->isAdmin();
	}

	/**
	 * Check media access one folder
	 *
	 * @return bool
	 */
	public function accessMediasFolder()
	{
	    return $this->isNotUser();
	}

}