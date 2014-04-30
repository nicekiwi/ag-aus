<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMapServerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('map_server', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('map_id')->unsigned()->index();
			$table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
			$table->integer('server_id')->unsigned()->index();
			$table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
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
		Schema::drop('map_server');
	}

}
