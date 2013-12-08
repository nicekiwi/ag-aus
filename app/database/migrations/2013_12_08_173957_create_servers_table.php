<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('servers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order');
			$table->string('name');
			$table->text('vanilla_name');
			$table->string('ip');
			$table->string('port');
			$table->string('type');
			$table->string('game');
			$table->integer('offline');
			$table->integer('maxPlayers');
			$table->integer('players');
			$table->integer('current_map')->nullable();
			$table->string('version')->nullable();

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
		Schema::drop('servers');
	}

}
