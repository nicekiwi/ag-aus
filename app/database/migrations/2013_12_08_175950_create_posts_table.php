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
			$table->string('title');
			$table->string('slug');
			$table->text('desc');
			$table->text('desc_md');
			$table->text('featured_image');
			$table->integer('event')->nullable();
			$table->timestamp('event_date');
			$table->timestamp('event_timezone');
			$table->text('tags');

			$table->softDeletes();
			$table->integer('updated_by');
			$table->integer('created_by');
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
