<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMapConfigServerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('map_config_server', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('map_config_id')->unsigned()->index();
			$table->foreign('map_config_id')->references('id')->on('map_configs')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('server_id')->unsigned()->index();
			$table->foreign('server_id')->references('id')->on('servers')->onUpdate('cascade')->onDelete('cascade');

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
		Schema::drop('map_config_server');
	}

}
