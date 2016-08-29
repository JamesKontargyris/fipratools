<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cases', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('background');
			$table->string('challenges');
			$table->string('strategy');
			$table->string('result');
			$table->integer('unit_id')->unsigned()->index();
			$table->foreign('unit_id')->references('id')->on('units');
			$table->integer('location_id')->unsigned()->index();
			$table->foreign('location_id')->references('id')->on('locations');
			$table->integer('account_director_id')->unsigned()->index();
			$table->foreign('account_director_id')->references('id')->on('account_directors');
			$table->integer('sector_id')->unsigned()->index();
			$table->foreign('sector_id')->references('id')->on('sectors');
			$table->integer('product_id')->unsigned()->index();
			$table->foreign('product_id')->references('id')->on('products');
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
		Schema::drop('cases');
	}

}
