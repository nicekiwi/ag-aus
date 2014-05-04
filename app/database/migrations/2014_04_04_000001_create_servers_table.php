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
			$table->integer('game_id');
			$table->integer('config_id');
			$table->string('name');
			$table->text('vanilla_name');
			$table->string('ip');
			$table->string('port');
			$table->integer('order');

			$table->integer('maxPlayers');
			$table->decimal('monthlyCost',5,2);

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
