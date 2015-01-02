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

			$table->integer('total');
			$table->integer('goal');
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
			$table->foreign('quarter_id')->references('id')->on('donation_quarters');

			$table->integer('player_id')->unsigned()->index()->nullable();
			$table->foreign('player_id')->references('id')->on('players');

			$table->string('email');

			$table->string('message');
			$table->integer('anonymous')->nullable();
			$table->string('currency');
			$table->integer('amount');

			$table->string('card_token', 150);
			$table->string('card_last4', 4);
			$table->string('card_type', 10);
			$table->string('card_month', 3);
			$table->string('card_year', 6);

			$table->string('confirm_code');
			$table->integer('confirmed');
			$table->integer('confirmed_by')->unsigned()->index()->nullable();
			$table->foreign('confirmed_by')->references('id')->on('users');

			$table->softDeletes();
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
		Schema::drop('donation_quarters');
		
	}

}
