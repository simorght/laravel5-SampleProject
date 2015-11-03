<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\MessageBag;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Repositories\PostRepository;
use App\Repositories\CommentRepository;


class ViewGuestController extends Controller
{
	/**
	 * The PostRepository instance.
	 *
	 * @var App\Repositories\PostRepository
	 */	
	protected $PostRepository;
	/**
	 * The CommentRepository instance.
	 *
	 * @var App\Repositories\CommentRepository
	 */	
	protected $CommentRepository;
	/**
	 * The pagination number.
	 *
	 * @var int
	 */
	protected $nbrPages;

	/**
	 * Create a new HomeController instance.
	 *
	 * @param  App\Repositories\PostRepository $PostRepository
	 * @param  App\Repositories\UserRepository $UserRepository
	 * @return void
	*/
	public function __construct(PostRepository $PostRepository , CommentRepository $CommentRepository)
	{
		$this->PostRepository = $PostRepository;
		$this->CommentRepository = $CommentRepository;
		$this->nbrPages = 5;
		
	}
	/**
	 * تابعی برای نمایش لیستی از پستها
	 *
	 * @return view
	 */	 
	public function Index()
	{
		$posts = $this->PostRepository->lists($this->nbrPages);
		$links = $posts->render();
		$newPostsList=$this->PostRepository->newPostsList($this->nbrPages);
		$mostLikePostsList=$this->PostRepository->mostLikePostsList($this->nbrPages);
		return view('layout.ListPosts', compact('mostLikePostsList','newPostsList', 'posts', 'links'));
	}
	/**
	 * تابعی برای نمایش پستها به صورت لیست بر اساس برچسب پست
	 * @param  String $tag
	 * @return view
	 */	
	public function listPostsByTag($tag)
	{
		$posts = $this->PostRepository->lists($this->nbrPages,$tag);
		$links = $posts->render();
		$newPostsList=$this->PostRepository->newPostsList($this->nbrPages);
		$mostLikePostsList=$this->PostRepository->mostLikePostsList($this->nbrPages);
		return view('layout.ListPosts', compact('newPostsList' ,'mostLikePostsList' ,'tag' , 'posts', 'links'));
	}
	/**
	 * تابعی برای نمایش لیست پستهای مطابق با موارد مورد جستجو
	 * @param  Illuminate\Http\Request $request
	 * @return view
	 */	
	public function Search(Request $Search)
	{
		extract($Search->all());
		$posts = $this->PostRepository->Search($this->nbrPages,$q);
		$links = $posts->render();
		$newPostsList=$this->PostRepository->newPostsList($this->nbrPages);
		$mostLikePostsList=$this->PostRepository->mostLikePostsList($this->nbrPages);
		return view('layout.ListPosts', compact('newPostsList','mostLikePostsList','posts', 'links'));
	}
	/**
	 * تابعی برای نمایش یک پست و کامنتهای مربوطه با آیدی پست
	 * @param  int $pst_id
	 * @return view
	 */
	 
	public function readPost($pst_id)
	{
		$post = $this->PostRepository->get($pst_id); //----> کوئری یوزر عادی
		$comments = $this->CommentRepository->getApprovedByPostId($pst_id);
		$newPostsList=$this->PostRepository->newPostsList($this->nbrPages);
		$mostLikePostsList=$this->PostRepository->mostLikePostsList($this->nbrPages);		
		return view('layout.ReadPost', compact('newPostsList', 'mostLikePostsList', 'pst_id', 'post',  'comments'));
	}		
}
?>
