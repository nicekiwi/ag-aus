<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonatorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('donators', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('steam_nickname')->nullable();
			$table->string('steam_id')->unique()->nullable();
			$table->string('steam_64id')->unique()->nullable();
			$table->text('steam_image')->nullable();
			$table->text('steam_url')->nullable();
			$table->string('email');
			$table->string('donation_expires')->nullable();
			$table->string('card_token', 150);
			$table->string('card_last4', 4);
			$table->string('card_type', 10);
			$table->string('card_month', 3);
			$table->string('card_year', 6);

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
		Schema::drop('donators');
	}

}
