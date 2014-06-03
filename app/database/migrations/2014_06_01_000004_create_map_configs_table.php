<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMapConfigsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('map_configs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');

			$table->timestamp('start_at');
			$table->timestamp('end_at');
			$table->integer('priority');

			$table->integer('disabled');

			$table->integer('created_by');
			$table->integer('updated_by');
			$table->integer('deleted_by');

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
		Schema::drop('map_configs');
	}

}
