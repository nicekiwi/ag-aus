<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('donations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('donator_id')->unsigned();
			$table->string('message');
			$table->integer('anonymous')->nullable();
			$table->string('currency');
			$table->integer('amount');

			$table->softDeletes();
			$table->timestamps();

			$table->foreign('donator_id')->references('id')->on('donators')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('donations');
	}

}
