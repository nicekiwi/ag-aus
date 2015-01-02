<?php

use Illuminate\Database\Migrations\Migration;

class CreateDatabase extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
		// $driver   = Config::get('database.connections.default');
    // $database = Config::get('database.connections.{$driver}.database');
    // $username = Config::get('database.connections.{$driver}.username');
    // $password = Config::get('database.connections.{$driver}.password');
    //
    // $connection = new PDO("{$driver}:user={$username} password={$password}");
    // $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $connection->query("CREATE DATABASE IF NOT EXISTS " . $database);

	}

	public function down()
	{
		//
	}
}
