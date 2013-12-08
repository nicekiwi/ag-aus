<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetForeignKeyOnDonations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('donations', function(Blueprint $table)
		{
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
		Schema::table('donations', function(Blueprint $table)
		{
			$table->dropForeign('donations_donator_id_foreign');
		});
	}

}