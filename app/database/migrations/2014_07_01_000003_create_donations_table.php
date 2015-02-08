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

			$table->integer('year');
			$table->integer('quarter');
			$table->string('name');

			$table->string('total');
			$table->string('goal');
			$table->integer('percentage');

			$table->softDeletes();
			$table->timestamp('startDate');
			$table->timestamp('endDate');
			$table->timestamps();
		});

		Schema::create('donations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();

			$table->integer('quarter_id')->unsigned()->index()->nullable();
			$table->foreign('quarter_id')->references('id')->on('donation_quarters')->onDelete('set null');

			$table->integer('player_id')->unsigned()->index()->nullable();
			$table->foreign('player_id')->references('id')->on('players')->onDelete('set null');

			$table->string('email');
			$table->string('currency');
			$table->string('amount');

			$table->string('card_token', 150);
			$table->string('card_last4', 4);
			$table->string('card_type', 10);
			$table->string('card_month', 3);
			$table->string('card_year', 6);

			$table->string('status');

			$table->softDeletes();
			$table->timestamps();
		});

		Schema::create('donators', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();

			$table->integer('player_id')->unsigned()->index()->nullable();
			$table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');

			$table->timestamp('expires')->nullable();

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
		Schema::drop('donations');
		Schema::drop('donators');
		Schema::drop('donation_quarters');
		
	}

}
