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
			$table->integer('game_id')->unsigned()->index();
			$table->foreign('game_id')->references('id')->on('games')->onUpdate('cascade')->onDelete('cascade');

			$table->string('name');
			$table->text('desc');
			
			$table->softDeletes();
			$table->integer('updated_by')->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
		});

		Schema::create('config_variables', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('name');
			$table->text('desc');
			
			$table->softDeletes();
			$table->integer('updated_by')->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
		});

		Schema::create('config_variable_groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('server_id');

			$table->string('name');
			$table->text('desc');
			
			$table->softDeletes();
			$table->integer('updated_by')->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
		});

		Schema::create('config_values', function(Blueprint $table)
		{
			$table->increments('id');

			// The required permissions to read and write config values.
			$table->integer('read_permission_id');
			$table->integer('write_permission_id');

			$table->integer('config_id')->unsigned()->index();
			$table->foreign('config_id')->references('id')->on('configs')->onUpdate('cascade');
			$table->integer('group_id')->nullable()->unsigned()->index();
			$table->foreign('group_id')->references('id')->on('config_variable_groups')->onUpdate('cascade');
			$table->integer('variable_id')->unsigned()->index();
			$table->foreign('variable_id')->references('id')->on('config_variables')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('config_variables');
		Schema::drop('config_values');

		Schema::drop('config_variable_groups');
		Schema::drop('configs');
	}

}
