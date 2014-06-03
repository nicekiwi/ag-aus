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
		$dbname = "`".Config::get('database.connections.mysql.database')."`";

		$pdo = new PDO("mysql:host=localhost", Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");
	}

	public function down()
	{
		//
	}
}