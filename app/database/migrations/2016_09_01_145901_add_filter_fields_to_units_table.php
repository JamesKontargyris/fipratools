<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilterFieldsToUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('units', function(Blueprint $table)
		{
			$table->boolean('show_list')->unsigned()->default(1);
			$table->boolean('show_case')->unsigned()->default(1);
			$table->boolean('show_survey')->unsigned()->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('units', function(Blueprint $table)
		{
			$table->dropColumn('show_list');
			$table->dropColumn('show_case');
			$table->dropColumn('show_survey');
		});
	}

}
