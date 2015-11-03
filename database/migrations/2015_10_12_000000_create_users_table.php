<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_tbl', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_name', 30)->unique();
			$table->string('name', 30);
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->integer('role_id')->unsigned();
			$table->boolean('seen')->default(false);
			$table->boolean('valid')->default(false);
			$table->boolean('confirmed')->default(false);
			$table->string('confirmation_code')->nullable();
			$table->dateTime('last_login_at')->default("0000-00-00 00:00:00");
			$table->string('last_login_ip',255)->default("0.0.0.0");
			$table->timestamps();
			$table->rememberToken();			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_tbl');
	}

}
