<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
  public function up()
  {
		Schema::table('users_tbl', function(Blueprint $table) {
			$table->foreign('role_id')
						->references('id')
						->on('roles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('comments_tbl', function(Blueprint $table) {
			$table->foreign('pst_id')
						->references('pst_id')
						->on('posts_tbl')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_tbl', function(Blueprint $table) {
			$table->dropForeign('users_tbl_role_id_foreign');
		});
		Schema::table('comments_tbl', function(Blueprint $table) {
			$table->dropForeign('comments_tbl_pst_id_foreign');
		});		
	}

}
