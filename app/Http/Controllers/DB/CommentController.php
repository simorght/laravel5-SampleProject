<?php namespace App\Http\Controllers\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;
use Illuminate\Translation\Translator;

class CommentController extends Controller {

	/**
	 * The CommentRepository instance.
	 *
	 * @var App\Repositories\CommentRepository
	 */
	protected $CommentRepository;

	/**
	 * Create a new CommentController instance.
	 *
	 * @param  App\Repositories\CommentRepository $CommentRepository
	 * @return void
	 */
	public function __construct(
		CommentRepository $CommentRepository)
	{
		$this->CommentRepository = $CommentRepository;
		$this->middleware('admin', ['except' => ['insert']]);
		$this->middleware('ajax');
	}
//-----------------------------افزودن اطلاعات--------------------------
	
	/**
	 * اضافه کردن کامنت جدید 
	 *
	 * @param  App\requests\CommentRequest $request
	 * @return Response
	 */
	public function insert(
		CommentRequest $request)
	{
		$this->CommentRepository->insert($request->all());
		return response()->json();
	}		

//-----------------------------ویرایش اطلاعات--------------------------
	/**
	 * تایید یک کامنت
	 *
	 * @param  Illuminate\Http\Request $request
	 * @return Response
	 */
	public function updateApprove(Request $request)
	{
		$input=$request->all();
		$SendParam = $input['SendParam'];
		$SendParam = json_decode($SendParam);
		if(is_array($SendParam->cmt_ids))
			$this->CommentRepository->updateBatchApproved($SendParam->approved, $SendParam->cmt_ids);
		else
			$this->CommentRepository->updateApprove($SendParam->approved , $SendParam->cmt_ids);
		return response()->json();
	}
	
}
