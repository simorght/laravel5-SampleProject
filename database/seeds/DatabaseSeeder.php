<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role, App\Models\User, App\Models\Post, App\Models\Comment;
use App\Services\LoremIpsumGenerator;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$lipsum = new LoremIpsumGenerator;

		Role::create([
			'title' => 'Administrator',
			'slug' => 'admin'
		]);

		Role::create([
			'title' => 'Redactor',
			'slug' => 'redac'
		]);

		Role::create([
			'title' => 'User',
			'slug' => 'user'
		]);

		User::create([
			'user_name' => 'samad',
			'email' => 'soltanzad@engineer.com',
			'name' => 'صمد سلطانزاد',
			'password' => bcrypt('admin'),
			'seen' => true,
			'role_id' => 1,
			'confirmed' => true
		]);

		Post::create([
			'tag' => 'link1',
			'title' => 'پست تست شماره یک', 
			'read_more' => 'این پست برای تست ایجاد شده است. تمامی این وبلاگ با تکنولوژی پی اچ پی و بر اساس ام وی سی با فریم ورک لاراول طراحی شده است.' ,
			'content' => 'این پست برای تست ایجاد شده است. تمامی این وبلاگ با تکنولوژی پی اچ پی و بر اساس ام وی سی با فریم ورک لاراول طراحی شده است.', 
			'active' => true,
			'seen' => 0
		]);
		
		Post::create([
			'tag' => 'link2',
			'title' => 'پست تست شماره دو', 
			'read_more' => 'این پست برای تست ایجاد شده است. تمامی این وبلاگ با تکنولوژی پی اچ پی و بر اساس ام وی سی با فریم ورک لاراول طراحی شده است.' ,
			'content' => 'این پست برای تست ایجاد شده است. تمامی این وبلاگ با تکنولوژی پی اچ پی و بر اساس ام وی سی با فریم ورک لاراول طراحی شده است.', 
			'active' => true,
			'seen' => 0
		]);		

		Comment::create([
			'approved' => '1', 
			'comment' => 'نظری که به منظور تست نهاده شده است', 
			'email' => 'soltanzad@engineer.com', 
			'commenter' => 'صمد سلطانزاد',
			'seen' => '1',
			'pst_id' => 1
		]);
		
		Comment::create([
			'approved' => '1', 
			'comment' => 'نظری که به منظور تست نهاده شده است', 
			'email' => 'soltanzad@engineer.com', 
			'commenter' => 'صمد سلطانزاد',
			'seen' => '1',
			'pst_id' => 2
		]);		

	}

}
