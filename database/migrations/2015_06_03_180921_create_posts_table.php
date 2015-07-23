<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('game_id');
			$table->string('title',120);
			$table->string('gif');
			$table->string('mp4');
			$table->string('webm');
			$table->string('status');
			$table->string('track_key');
			$table->string('file_name');
			$table->string('url_key');
			$table->int('views')->default(0);
			$table->int('points')->default(0);
			$table->int('category_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
