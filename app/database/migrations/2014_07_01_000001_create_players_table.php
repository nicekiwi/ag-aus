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

			$table->timestamp('donation_expires')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});

		// Creates the assigned_roles (Many-to-Many relation) table
	    // Schema::create('player_roles', function($table)
	    // {
	    //     $table->increments('id')->unsigned();
	    //     $table->integer('player_id')->unsigned();
	    //     $table->integer('role_id')->unsigned();
	    //     $table->foreign('player_id')->references('id')->on('players');
	    //     $table->foreign('role_id')->references('id')->on('roles');
	    // });

	    Schema::table('users', function($table) 
	    {
	    	$table->foreign('player_id')->references('id')->on('players')->onDelete('set null'); // assumes a users table
	    });

	    Schema::table('map_feedback', function($table) 
	    {
	    	$table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
	    	$table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
	    });
	    
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::drop('player_roles');
		Schema::drop('players');
	}

}
