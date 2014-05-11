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
		Schema::create('donation_quarters', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();

			$table->string('title')->unique();
			$table->integer('quarter');
			$table->integer('year');

			$table->integer('goal_percentage');
			$table->decimal('goal_amount',7,2);
			$table->decimal('total_amount',7,2);

			$table->timestamp('start_at');
			$table->timestamp('end_at');
			$table->timestamps();
		});

		Schema::create('donations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('donator_id')->unsigned();
			$table->integer('quarter_id')->unsigned();
			$table->string('message');
			$table->integer('anonymous')->nullable();
			$table->string('currency');
			$table->integer('amount');

			$table->softDeletes();
			$table->timestamps();

			$table->foreign('donator_id')->references('id')->on('donators');
			//$table->foreign('quarter_id')->references('id')->on('donation_quarters');
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
		Schema::drop('donation_quarters');
	}

}
