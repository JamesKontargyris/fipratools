<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolboxTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('toolbox', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->longText('description');
			$table->string('type');
			$table->string('url');
			$table->string('file');
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
		Schema::drop('toolbox');
	}

}
