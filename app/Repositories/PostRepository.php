<?php namespace App\Repositories;
use App\Models\User, App\Models\Post, App\Models\Comment , App\Utilities\Utility;
use Lang;
class PostRepository extends BaseRepository{
	/**
	 * The Comment instance.
	 *
	 * @var App\Models\Post
	 */
	 protected $model;
	/**
	 * The Comment instance.
	 *
	 * @var App\Models\Utility
	 */
	 protected $Utility;
	/**
	 * The Comment instance.
	 *
	 * @var App\Models\Comment
	 */
	 protected $Comment;	 
	/**
	 * Create a new BlogRepository instance.
	 *
	 * @param  App\Models\Post $post
	 * @param  App\Models\Utility $Utility
	 * @param  App\Models\Comment $comment
	 * @return void
	 */
	public function __construct(
		Post $post, 
		Utility $Utility, 
		Comment $comment)
	{
		$this->model = $post;
		$this->comment = $comment;
		$this->Utility = $Utility;
	}
//-----------------------------دریافت اطلاعات--------------------------		
	/**
	 * دریافت پست بر اساس ایدی و اکتیو پیش فرض ترو
	 *
	 * @param  int  $pst_id
	 * @return Illuminate\Support\Collection
	 */
	public function get($pst_id)
	{
		$Res = $this->model->where('pst_id', "$pst_id")
		->where('active', true)
		->first();
		$this->AddJalaliDate($Res , " " , false);		
		return $Res;	
	}
	/**
	 * دریافت پست بر اساس ایدی و در صورتیکه درخواست کننده ادمین باشد 
	 *        و دسترسی به هر نوع پست غیرفعال نیز دارد   
	 *
	 * @param  int  $pst_id
	 * @return Illuminate\Support\Collection
	 */
	public function getIsAdmin($pst_id)
	{
		$Res = $this->model->where('pst_id', "$pst_id")
		->first();
		$this->AddJalaliDate($Res , " " , false);		
		return $Res;	
	}	
	/**
	 * جستجو در بین تایتل و محتوا و خلاصه پست
	 *
	 * @param  int  $n
	 * @param  string  $search
	 * @return Illuminate\Support\Collection
	 */
	public function Search($n, $search)
	{
		$query = $this->queryActiveOrderByDate();
		$Res = $query->where(function($q) use ($search) {
			$q->where('read_more', 'like', "%$search%")
				->orWhere('content', 'like', "%$search%")
				->orWhere('title', 'like', "%$search%");
		})->paginate($n);
		$this->AddJalaliDate($Res);
		return $Res;
	}
	/**
	 * دریافت پستها بر اساس مقادیر
	 *
	 * @param  int     $n
	 * @param          $tag
	 * @param          $active
	 * @param  string  $orderby
	 * @param  string  $direction
	 * @return Illuminate\Support\Collection
	 */
	public function lists($n, $tag = NULL, $orderby = 'updated_at', $direction = 'desc' , $active = true)
	{
		$query = $this->model
		->select('pst_id', 'tag', 'title', 'read_more', 'content', 'seen', 'active', 'created_at', 'updated_at')
		->orderBy($orderby, $direction);

		if($tag) 
		{
			$query->where('tag', $tag);
		}
		$query->where('active', $active);
		$Res = $query->paginate($n);
		$this->AddJalaliDate($Res);
		return $Res;
	}
	
	/**
	 * دریافت تعداد کامنتهای زیر هر پست
	 * @param  int    $n
	 * @return Illuminate\Support\Collection
	 */
	public function listsWithcommentsCount($n)
	{
		$Res = $this->model
		->selectRaw('posts_tbl.pst_id, posts_tbl.title, posts_tbl.active, count(*) as aggregate')
		->join('comments_tbl','posts_tbl.pst_id','=','comments_tbl.pst_id')
		->whereActive(true)
		->groupBy('posts_tbl.pst_id')
		->orderBy('aggregate', 'desc')
		->take($n)->get();
		return $Res;	
	}
	/**
	 * دریافت برچسبها از فایل 
	 * 
	*/
	public function getTags()
	{
		$translations = Lang::getLoader()->load(Lang::getLocale(),"layout/headermenu");
		return $translations; // return entire array;
	}
		
	/**
	 * تابعی برای لیستی از تازه ترین پستها به مقدار موردی
	 * تابع صرفا به منظور ملموس بودن نام آن برای برنامه نویس دوباره تعریف شده است 
	 * و می توان از تابع لیست داخل تابع نیز به جای آن استفاده کرد
	 * @param  int $n as limit 
	 * @return list
	 */	
	public function newPostsList($n)
	{
		return $this->lists($n);
	}
	/**
	 * تابعی برای لیستی از پرمخاطب ترین پستها به مقدار موردی
	 * تابع صرفا به منظور ملموس بودن نام آن برای برنامه نویس دوباره تعریف شده است 
	 * و می توان از تابع لیست داخل تابع نیز به جای آن استفاده کرد	 
	 * @param  int $n as limit 
	 * @return list
	 */	
	public function mostLikePostsList($n)
	{
		return $this->listsWithcommentsCount($n);
	}		
//-----------------------------ویرایش اطلاعات--------------------------
	/**
	 * بروزرسانی یک پست
	 *
	 * @param  App\Models\Post $post
	 * @param  array  $inputs
	 * @return App\Models\Post
	 */
	public function update($inputs, $id)
	{
		$post = $this->model->find($id);
		$post->tag = $inputs['tag'];
		$post->title = $inputs['title'];	
		$post->read_more = $inputs['read_more'];	
		$post->content = $inputs['Pcontent'];
		$post->save();
	}
	/**
	 * بروزرسانی تعداد بازدیدها از یک پست
	 *
	 * @param  array  $inputs
	 * @param  int    $id
	 * @return void
	 */
	public function updateSeen($id)
	{
		$post = $this->model->find($id);
		$post->seen = $post->seen + 1;
		$post->save();			
	}
	/**
	 * بروزرسانی فیلد اکتیو یک پست
	 *
	 * @param  array  $inputs
	 * @param  int    $id
	 * @return void
	 */
	public function updateActive($active, $id)
	{
		$post = $this->model->find($id);
		$post->active = $active;	
		$post->save();			
	}
	/**
	 * بروزرسانی دسته ای فیلد اکتیو چندین پست
	 *
	 * @param  string  $active
	 * @param  array    $ids
	 * @return void
	 */
	public function updateBatchActive($active, $ids)
	{
		$this->model->whereIn("pst_id", $ids)->update(['active' => $active]);
	}	
//-----------------------------افزودن اطلاعات--------------------------
	/**
	 * افزودن یک پست
	 *
	 * @param  array  $inputs
	 * @param  int    $user_id
	 * @return App\Models\Post
	 */
	public function insert($inputs)
	{
		$post = new $this->model;
		$post->tag = $inputs['tag'];
		$post->title = $inputs['title'];	
		$post->read_more = $inputs['read_more'];	
		$post->content = $inputs['Pcontent'];
		$post->save();		
	}	
//-----------------------------حذف اطلاعات------------------------------

	//------------------------------------------------------------------------//
	//       کلید اصلی پست به عنوان کلید خارجی کامنت معرفی شده است            //
	//      اکشن آن دیلیت کلید خارجی کامنت بصورت کاسکید تعریف شده است         //
	// بنابراین در صورت حذف یک پست تمامی کامنتهای مربوط به آن نیز حذف می شود  //
	//------------------------------------------------------------------------//
	
	/**
	 * حذف یک پست
	 *
	 * @param  array  $inputs
	 * @param  int    $id
	 * @return void
	 */
	public function delete($id)
	{
		$this->model->find($id)->delete();
	}
	/**
	 * حذف دسته ای از پستها
	 *
	 * @param  string  $active
	 * @param  array    $ids
	 * @return void
	 */
	public function deleteBatch($ids)
	{
		$this->model->whereIn("pst_id", $ids)->delete();
	}	
//---------------------------------------------------------------------	
}
?>