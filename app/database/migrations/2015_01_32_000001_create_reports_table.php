<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reports', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('player_id')->unsigned()->index();
			$table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');

			$table->integer('map_id')->unsigned()->index();
			$table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');

			$table->integer('donation_id')->unsigned()->index();
			$table->foreign('donation_id')->references('id')->on('donations')->onDelete('cascade');

			$table->integer('quarter_id')->unsigned()->index();
			$table->foreign('quarter_id')->references('id')->on('donation_quarters')->onDelete('cascade');

			$table->integer('type');
			$table->text('desc');

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
		Schema::drop('reports');
	}

}
