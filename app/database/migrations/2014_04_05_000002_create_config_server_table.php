<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigServerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('config_server', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('config_id')->unsigned()->index();
			$table->foreign('config_id')->references('id')->on('configs')->onDelete('cascade');
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
		Schema::drop('config_server');
	}

}
