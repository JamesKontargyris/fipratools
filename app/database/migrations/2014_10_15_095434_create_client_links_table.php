<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_links', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('unit_id')->unsigned();
			$table->integer('link_to_id')->nullable()->unsigned();

			$table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
			$table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('client_links');
	}

}
