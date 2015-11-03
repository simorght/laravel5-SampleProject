<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create Comment_tbl table 
		Schema::create( 'comments_tbl',
					   function(Blueprint $table){
						    $table->increments('cmt_id');
						    $table->integer('pst_id')->unsigned();
						    $table->string('commenter');
						    $table->string('email');
							$table->text('comment');
							$table->boolean('seen')->default(false);
							$table->tinyInteger('approved')->default(2);
							$table->timestamps();
					   }
					   );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // create Comment_tbl table
		Schema::drop('comments_tbl');
    }
}
