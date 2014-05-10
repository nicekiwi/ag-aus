<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('server_id');

			$table->string('title');

			$table->text('desc');
			
			$table->softDeletes();
			$table->integer('updated_by')->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
		});

		// Schema::create('config_variables', function(Blueprint $table)
		// {
		// 	$table->increments('id');
		// 	$table->integer('server_id');

		// 	$table->string('title');

		// 	$table->text('desc');
			
		// 	$table->softDeletes();
		// 	$table->integer('updated_by')->nullable();
		// 	$table->integer('created_by')->nullable();
		// 	$table->timestamps();
		// });

		// Schema::create('config_variable', function(Blueprint $table)
		// {
		// 	$table->increments('id');

		// 	$table->integer('config_id');
		// 	$table->integer('variable_id');

			
		// });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('configs');
	}

}
