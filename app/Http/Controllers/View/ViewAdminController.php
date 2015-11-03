<?php namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\PostRequest;
use App\Repositories\PostRepository;
use App\Repositories\CommentRepository;

class ViewAdminController extends Controller {

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
     * Create a new AdminController instance.
     *
     * @param  App\Repositories\UserRepository $UserRepository
     * @return void
     */
	public function __construct(
		CommentRepository $CommentRepository,						
		PostRepository $PostRepository)
	{
		$this->CommentRepository = $CommentRepository;
		$this->PostRepository = $PostRepository;
		$this->nbrPages = 5;
		
		$this->middleware('admin');
		$this->middleware('ajax', ['only' => ['getComment','posts']]);
		
	}

	/**
	* نمایش داشبورد ادمین
	*
	* @param  App\Repositories\PostRepository $PostRepository
	* @param  App\Repositories\CommentRepository $CommentRepository
	* @return Response
	*/
	public function Index(
		PostRepository $PostRepository,
		CommentRepository $CommentRepository)
	{	
		
		$nbrPosts = $PostRepository->getNumber();
		$nbrComments = $CommentRepository->getNumber();
		$posts = $PostRepository->lists($this->nbrPages);
		$links = $posts->setPath('')->render();
		
		return view('admin.DashBoard', compact( 'posts', 'links', 'nbrPosts', 'nbrComments'));
	}

	/**
	 *
	 * @return Redirection
	 */
	public function redirectToPosts()
	{
		return redirect(route('listPosts', [
			'name' => 'updated_at',
			'sens' => 'asc',
			'tag' => 'all',
			'active' => 'true'
		]));
	}

	/**
	 *
	 * @return Redirection
	 */
	public function redirectToComments()
	{
		return redirect(route('listComments', [
			'name' => 'updated_at',
			'sens' => 'asc',
			'tag' => 'all',
			'approved' => '1'
		]));
	}

	/**
	 * نمایش لیست پستها
	 *
	 * @param  Illuminate\Http\Request $request
	 * @return Response
	 */
	public function posts(Request $request)
	{
		$nbrPosts = $this->PostRepository->getNumber();
		$nbrComments = $this->CommentRepository->getNumber();		
		$nbrTags = $this->PostRepository->getTags();
		$tag = $request->tag;
		$page=1;
		if (isset($request->page))
			$page = $request->page;
			
		if ($tag=="all")$tag=NULL;
		$posts = $this->PostRepository->lists(
			10, 
			$tag,						
			$request->name,
			$request->sens,
			($request->active == 'true')			
		);
		
		$links = $posts->appends([
				'name' => $request->name, 
				'sens' => $request->sens,
				'tag' => $request->tag,
				'active' => $request->active
			]);

		if($request->ajax()) {
			return response()->json([
				'view' => view('admin.Post.AjaxPostsList', compact( 'posts'))->render(), 
				'links' => $links->setPath('order')->render()
			]);		
		}

		$links->setPath('')->render();

		$order = (object)[
			'name' => $request->name, 
			'sens' => 'sort-' . $request->sens,			
			'tag' => $request->tag,		
			'active' => $request->active			
		];		

		return view('admin.Post.Posts', compact('nbrPosts','nbrComments','nbrTags','posts', 'links', 'order' , 'page'));
	}	

	/**
	 * نمایش لیست کامنتها
	 *
	 * @param  Illuminate\Http\Request $request
	 * @return Response
	 */
	public function comments(Request $request)
	{
		$nbrPosts = $this->PostRepository->getNumber();
		$nbrComments = $this->CommentRepository->getNumber();		
		$nbrTags = $this->PostRepository->getTags();
		$tag = $request->tag;
		$page=1;
		
		if (isset($request->page))
			$page = $request->page;
			
		if ($tag=="all")$tag=NULL;
		$comments = $this->CommentRepository->lists(
			10,
			$tag,						
			$request->name,
			$request->sens,
			$request->approved		
		);
		$links = $comments->appends([
				'name' => $request->name, 
				'sens' => $request->sens,
				'tag' => $request->tag,
				'approved' => $request->approved
			]);
		
		if($request->approved==2)
			$this->CommentRepository->updateBatchSeen(1,$comments->lists('cmt_id'));

		if($request->ajax()) {
			return response()->json([
				'view' => view('admin.Comment.AjaxCommentsList', compact( 'comments'))->render(), 
				'links' => $links->setPath('order')->render()
			]);		
		}

		$links->setPath('')->render();

		$order = (object)[
			'name' => $request->name, 
			'sens' => 'sort-' . $request->sens,			
			'tag' => $request->tag,		
			'approved' => $request->approved			
		];
		return view('admin.Comment.Comments', compact('nbrPosts','nbrComments','nbrTags','comments', 'links', 'order' , 'page'));
	}
	/**
	 * تابعی برای نمایش یک پست و کامنتهای مربوطه با آیدی پست
	 * @param  int $pst_id
	 * @return view
	 */
	 
	public function readPost($pst_id)
	{
		$post = $this->PostRepository->getIsAdmin($pst_id); //----> کوئری ادمین
		$comments = $this->CommentRepository->getApprovedByPostId($pst_id);
		$newPostsList=$this->PostRepository->newPostsList($this->nbrPages);
		$mostLikePostsList=$this->PostRepository->mostLikePostsList($this->nbrPages);		
		return view('layout.ReadPost', compact('newPostsList', 'mostLikePostsList', 'pst_id', 'post',  'comments'));
	}	
	/**
	 * نمایش یک کامنت با کامنت ایدی
	 *
	 * @param  int  $cmt_id
	 * @return Response
	 */	
	public function getComment(Request $request)
	{
		$input=$request->all();
		$cmt_id = $input['cmt_id'];
		$comment = $this->CommentRepository->get($cmt_id);
		return $comment;
	}	
	/**
	 * نمایش فرم ویرایش پست
	 *
	 * @param  int  $pst_id
	 * @return Response
	 */
	public function editPostForm($pst_id)
	{
		$post = $this->PostRepository->getIsAdmin($pst_id);
		$nbrPosts = $this->PostRepository->getNumber();
		$nbrComments = $this->CommentRepository->getNumber();		
		$nbrTags = $this->PostRepository->getTags();		
		$url = config('medias.url');
		$FormUrl= Route('updatePost');
		$FormMethod="PUT";
		return view('admin.Post.Form',  compact('nbrTags','nbrPosts','nbrComments','FormUrl','FormMethod','pst_id','post','url'));
	}
	/**
	 * نمایش فرم افزودن پست
	 *
	 * @return Response
	 */	
	public function addPostForm()
	{
		$nbrPosts = $this->PostRepository->getNumber();
		$nbrComments = $this->CommentRepository->getNumber();		
		$nbrTags = $this->PostRepository->getTags();		
		$url = config('medias.url');
		$FormUrl= Route('insertPost');
		$FormMethod="POST";
		return view('admin.Post.Form',  compact('nbrTags','nbrPosts','nbrComments','FormUrl','FormMethod','url'));
	}	
	/**
	 * نمایش پنل مدیریت فایل
	 *
     * @return Response
	 */
	public function filemanager()
	{
		$url = config('medias.url');
		
		return view('admin.FileManager.filemanager', compact('url'));
	}

}
