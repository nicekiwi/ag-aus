<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMapMapConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('map_map_config', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('map_id')->unsigned()->index();
			$table->foreign('map_id')->references('id')->on('maps')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('map_config_id')->unsigned()->index();
			$table->foreign('map_config_id')->references('id')->on('map_configs')->onUpdate('cascade')->onDelete('cascade');

			$table->integer('admin_voting');
			$table->integer('random_cycle');
			$table->integer('map_chooser');
			$table->integer('nominations');

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
		Schema::drop('map_map_config');
	}

}
