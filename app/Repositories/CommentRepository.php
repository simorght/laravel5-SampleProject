<?php namespace App\Repositories;

use App\Models\Comment , App\Utilities\Utility;

class CommentRepository extends BaseRepository {	
	/**
	* @var Dispatcher
	*/
	protected $events;
	/**
	 * Create a new CommentRepository instance.
	 *
	 * @param  App\Models\Comment $comment
	 * @return void
	 */
	 
	public function __construct(Comment $comment , Utility $Utility )
	{
		$this->model = $comment;
		$this->Utility = $Utility;
	}

//-----------------------------دریافت اطلاعات--------------------------
	/**
	 *  تابع دریافت لیست کامنتها در جوین با پستها بر اساس مقادیر در کوئیری 
	 *
	 * @param  int     $n
	 * @param  string  $orderby
	 * @param  string  $direction
	 * @param  string  $tag
	 * @param  int     $approved
	 * @return Illuminate\Support\Collection
	 */
	public function lists($n, $tag = NULL, $orderby = 'updated_at', $direction = 'desc' , $approved = 1)
	{
		$query = $this->model
		->select('comments_tbl.pst_id','comments_tbl.cmt_id', 'comments_tbl.created_at','comments_tbl.updated_at','comments_tbl.seen', 'comments_tbl.approved', 'comments_tbl.comment', 'comments_tbl.email', 'comments_tbl.commenter', 'posts_tbl.tag', 'posts_tbl.title')
		->join('posts_tbl', 'comments_tbl.pst_id', '=', 'posts_tbl.pst_id')
		->orderBy($orderby, $direction);

		if($tag) 
		{
			$query->where('tag', $tag);
		}
		$query->where('approved', $approved);

		$Res = $query->paginate($n);	
		$this->AddJalaliDate($Res,"/");
		return $Res;
	}
	
	/**
	 * تابع دریافت اطلاعات کامنتهای تایید شده زیر یک پست با ایدی آن پست
	 *
	 * @param  int  $Pst_id
	 * @return Illuminate\Support\Collection
	 */
	public function getApprovedByPostId($Pst_id)
	{
		$Res = $this->model->whereApprovedAndPst_id(1,$Pst_id)->latest()->get();
		$this->AddJalaliDate($Res , "/" );
		return $Res;	
	}
	/**
	 * تابع دریافت اطلاعات یک کامنت بر اساس ایدی آن کامنت
	 *
	 * @param  int  $Cmt_id
	 * @return Illuminate\Support\Collection
	 */
	public function get($Cmt_id)
	{
		$Res = $this->model->find($Cmt_id);
		return $Res;	
	}	
//-----------------------------ویرایش اطلاعات--------------------------
	/**
	 * تابع آپدیت وضعیت تایید یک کامنت
	 *
	 * @param  array  $approved
	 * @param  int    $id
	 * @return void
	 */
	public function updateApprove($approved, $Cmt_id)
	{
		$comment = $this->model->find($Cmt_id);
		$comment->approved = $approved;	
		$comment->save();			
	}
	/**
	 * تابع آپدیت وضعیت تایید بصورت دسته ای از کامنتها
	 *
	 * @param  string  $approved
	 * @param  array    $cmt_ids
	 * @return void
	 */
	public function updateBatchApproved($approved , $cmt_ids)
	{
		$this->model->whereIn("cmt_id", $cmt_ids)->update(['approved' => $approved]);
	}

	/**
	 * تابع آپدیت وضعیت مشاهده توسط ادمین بصورت دسته ای از کامنتها
	 * 
	 * @param  string  $seen
	 * @param  array    $cmt_ids
	 * @return void
	 */
	public function updateBatchSeen($seen ,$cmt_ids)
	{
		$this->model->whereIn("cmt_id",$cmt_ids)->update(['seen' => $seen]);
	}
//-----------------------------افزودن اطلاعات--------------------------
	
	/**
	 * تابع افزودن یک کامنت جدید
	 *
	 * @param  array $inputs
	 * @return void
	 */
 	public function insert($inputs)
	{
		$comment = new $this->model;	

		$comment->commenter = $inputs['commenter'];
		$comment->email = $inputs['email'];
		$comment->comment = $inputs['comment'];
		$comment->pst_id = $inputs['pst_id'];
		
		$comment->save();
	}
//--------------------------------------------------------------------	
}