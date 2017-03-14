<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('account_director_id')->unsigned()->index();
			$table->string('comments');
			$table->integer('unit_id')->unsigned()->index();
				$table->foreign('unit_id')->references('id')->on('units');
			$table->integer('sector_id')->unsigned()->index();
				$table->foreign('sector_id')->references('id')->on('sectors');
			$table->integer('type_id')->unsigned()->index();
				$table->foreign('type_id')->references('id')->on('types');
			$table->integer('service_id')->unsigned()->index();
				$table->foreign('service_id')->references('id')->on('services');
			$table->boolean('status')->default(1);
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
		Schema::drop('clients');
	}

}
