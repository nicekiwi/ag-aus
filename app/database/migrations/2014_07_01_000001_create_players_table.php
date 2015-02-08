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
			$table->string('steam_id32')->unique()->nullable();
			$table->string('steam_id64')->unique()->nullable();
			$table->string('steam_id3')->unique()->nullable();
			$table->text('steam_image')->nullable();
			$table->text('steam_url')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});

		// Creates the assigned_roles (Many-to-Many relation) table
		Schema::create('player_user', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('player_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});

		Schema::create('player_role', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('player_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
		Schema::table('map_feedback', function(Blueprint $table) {
			$table->dropForeign('map_feedback_player_id_foreign');
			$table->dropForeign('map_feedback_map_id_foreign');
		});

		Schema::drop('player_user');
		Schema::drop('player_role');
		Schema::drop('players');
	}

}
