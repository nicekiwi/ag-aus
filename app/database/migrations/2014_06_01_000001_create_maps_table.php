<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('maps', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('map_type_id');
			$table->string('filename')->unique();
			$table->string('filesize');
			$table->string('filetype');
			$table->string('name');
			$table->string('slug');
			$table->text('notes');
			$table->string('revision');
			$table->text('more_info_url');
			$table->text('s3_path');
			$table->integer('public');
			$table->text('images');
			$table->text('video');
			$table->string('developer');
			$table->text('developer_url');

			$table->softDeletes();
			$table->integer('updated_by')->nullable();
			$table->integer('created_by')->nullable();
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
		Schema::drop('maps');
	}

}
