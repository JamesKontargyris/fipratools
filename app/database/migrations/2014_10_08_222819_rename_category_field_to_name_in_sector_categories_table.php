<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCategoryFieldToNameInSectorCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sector_categories', function(Blueprint $table)
		{
			$table->renameColumn('category', 'name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sector_categories', function(Blueprint $table)
		{
			$table->renameColumn('name', 'category');
		});
	}

}
