<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('players', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('steam_nickname')->nullable();
			$table->string('steam_id')->unique()->nullable();
			$table->string('steam_64id')->unique()->nullable();
			$table->text('steam_image')->nullable();
			$table->text('steam_url')->nullable();
			
			$table->string('donation_expires')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});

		// Creates the assigned_roles (Many-to-Many relation) table
        Schema::create('player_roles', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('player_id')->references('id')->on('players'); // assumes a users table
            $table->foreign('role_id')->references('id')->on('roles');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('player_roles');
		Schema::drop('players');
	}

}
