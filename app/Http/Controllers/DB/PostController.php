<?php namespace App\Http\Controllers\DB;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\PostRequest;
use App\Repositories\PostRepository;

class PostController extends Controller {

	/**
	 * The PostRepository instance.
	 *
	 * @var App\Repositories\PostRepository
	 */
	protected $PostRepository;


	/**
	 * The pagination number.
	 *
	 * @var int
	 */
	protected $nbrPages;

	/**
	 * Create a new PostController instance.
	 *
	 * @param  App\Repositories\PostRepository $PostRepository
	 * @return void
	*/
	public function __construct(
		PostRepository $PostRepository)
	{
		$this->PostRepository = $PostRepository;
		$this->nbrPages = 2;

		$this->middleware('admin');
		$this->middleware('ajax');
	}

//-----------------------------ویرایش اطلاعات--------------------------

	/**
	 * ویرایش یک پست
	 *
	 * @param  App\Http\Requests\PostUpdateRequest $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(PostRequest $request)
	{
		$pst_id = $request->input('pst_id');
		$this->PostRepository->update($request->all(),$pst_id);
		return response()->json();
	}

	/**
	 * ویرایش فیلد فعال یک یا دسته ای از  پستها
	 *
	 * @param  Illuminate\Http\Request $request
	 * @param  int  $Request
	 * @return Response
	 */
	public function updateActive(Request $request)
	{
		$input=$request->all();
		$SendParam = $input['SendParam'];
		$SendParam = json_decode($SendParam);
		$active = ($SendParam->active == 'true');
		if(is_array($SendParam->pst_ids))			
			$this->PostRepository->updateBatchActive($active, $SendParam->pst_ids);
		else
			$this->PostRepository->updateActive($active , $SendParam->pst_ids);
		return response()->json();
	}

	
//-----------------------------حذف اطلاعات-----------------------------
	/**
	 * حذف یک یا دسته ای از  پستها
	 *
	 * @param  Illuminate\Http\Request $request
	 * @param  int  $Request
	 * @return Response
	 */
	public function delete(Request $request)
	{
		$input=$request->all();
		$SendParam = $input['SendParam'];
		$SendParam = json_decode($SendParam);
		if(is_array($SendParam->pst_ids))			
			$this->PostRepository->deleteBatch($SendParam->pst_ids);
		else
			$this->PostRepository->delete($SendParam->pst_ids);
		return response()->json();
	}
//-----------------------------افزودن اطلاعات--------------------------
	/**
	 * افزودن پست جدید
	 *
	 * @param  App\Http\Requests\PostRequest $request
	 * @return Response
	 */
	public function insert(PostRequest $request)
	{
		$this->PostRepository->insert($request->all());
		return response()->json();
	}
	
}
