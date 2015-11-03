<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Comment extends Model implements AuthenticatableContract  {

	use Authenticatable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments_tbl';
	protected $primaryKey = 'cmt_id'; 
    protected $fillable = ['commenter', 'email', 'comment'];	
    public function Post()
    {
        return $this->belongsTo('App\Models\Post' , 'pst_id');
    }
}
?>
