<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $primaryKey = 'pst_id'; 
    protected $table = 'posts_tbl';
    protected $fillable = ['title', 'read_more', 'content', 'seen', 'active'];	
    public function Comment()
    {
        return $this->hasMany('App\Models\Comment' , 'pst_id');
    }
	/**
	 * return comment count
	 *
	 * @return int
	 */
	public function commentCount()
	{		
		 return $this->Comment()
    ->selectRaw('pst_id, count(*) as aggregate')
    ->groupBy('pst_id');
	}	
		
}
?>