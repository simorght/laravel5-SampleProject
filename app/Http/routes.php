<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//-------------------ViewGust------------------------
	Route::get('post/{pst_id}',['uses' => 'View\ViewGuestController@readPost' , 'as' => 'readPost'])->where(['pst_id' => '[0-9]+']);

	Route::get('search/{link?}',['uses' => 'View\ViewGuestController@Search' , 'as' => 'search']);

	Route::get('tag/{link}',['uses' => 'View\ViewGuestController@listPostsByTag' , 'as' => 'listPostsByTag']);

//-------------------ViewAdmin------------------------
	Route::get('admin/files', ['uses' => 'View\ViewAdminController@filemanager', 'as' => 'medias']);


	Route::get('admin/posts/', 'View\ViewAdminController@redirectToPosts');

	Route::get('admin/posts/order', ['uses' => 'View\ViewAdminController@Posts', 'as' => 'listPosts']);

	Route::get('admin/comments/', 'View\ViewAdminController@redirectToComments');

	Route::get('admin/posts/new', ['uses' => 'View\ViewAdminController@addPostForm', 'as' => 'addPostForm']);

	Route::get('admin/edit/{pst_id}', ['uses' => 'View\ViewAdminController@editPostForm', 'as' => 'editPostForm', 'middleware' => 'admin'])->where(['pst_id' => '[0-9]+']);
	
	Route::get('admin/comments/order', ['uses' => 'View\ViewAdminController@comments', 'as' => 'listComments']);
	
	Route::get('admin/comments/read', ['uses' => 'View\ViewAdminController@getComment', 'as' => 'getComment']);
	
	Route::get('admin/post/{pst_id}',['uses' => 'View\ViewAdminController@readPost' , 'as' => 'adminReadPost'])->where(['pst_id' => '[0-9]+']);	

//------------------Posts-------------------------

   Route::put('admin/posts/updateactive',['uses' => 'DB\PostController@updateActive', 'as' => 'updateActive']);


   Route::put('admin/posts/edit',['uses'=> 'DB\PostController@update', 'as'=>'updatePost']);

   Route::delete('admin/posts/delete',['uses'=>'DB\PostController@delete','as'=>'deletePost']);
	
   Route::post('admin/posts/new',['uses' => 'DB\PostController@insert', 'as'=>'insertPost']);

//-------------------comments----------------
	Route::post( 'postcomment' ,['uses' => 'DB\CommentController@insert' , 'as' => 'insertComment']);

	Route::put('admin/updatespprove/{cmt_id}', ['uses' => 'DB\CommentController@updateApprove', 'as' => 'updateApprove'])->where(['cmt_id' => '[0-9]+']);

//-------------------auth-------------------
	Route::controllers(['auth' => 'Auth\AuthController','password' => 'Auth\PasswordController',]);
	
//-----------------resource-----------------
	
	Route::resource('/', 'View\ViewGuestController');

	Route::resource('/admin', 'View\ViewAdminController');
	

