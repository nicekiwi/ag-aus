<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('options', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('donation_quarter_goal');
			$table->integer('donation_monthly_cost');
			$table->integer('donation_maximum_amount');
			$table->text('donation_admin_email1');
			//$table->text('donation_admin_email2');

			$table->softDeletes();
			$table->integer('updated_by')->unsigned()->index()->nullable();
			$table->foreign('updated_by')->references('id')->on('users');

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
		Schema::drop('options');
	}

}
