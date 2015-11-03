<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_tbl', function (Blueprint $table) {
            $table->increments('pst_id');
            $table->string('tag');
            $table->string('title');
            $table->text('read_more');
            $table->text('content');
			$table->unsignedInteger('seen')->default(1);
			$table->boolean('active')->default(true);			
            $table->timestamps();
        });
        DB::statement('ALTER TABLE Posts_tbl ADD FULLTEXT search_idx(title, content)');
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts_tbl', function (Blueprint $table) {
            $table->dropIndex('search_idx');
            $table->drop();
        });
    }
	
}
