<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMapMapFileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('map_map_file', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('map_id')->unsigned()->index();
			$table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
			$table->integer('map_file_id')->unsigned()->index();
			$table->foreign('map_file_id')->references('id')->on('map_files')->onDelete('cascade');
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
		Schema::drop('map_map_file');
	}

}
