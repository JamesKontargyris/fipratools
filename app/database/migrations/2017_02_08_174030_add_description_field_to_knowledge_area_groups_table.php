<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionFieldToKnowledgeAreaGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('knowledge_area_groups', function(Blueprint $table)
		{
			$table->longText('description')->after('name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('knowledge_area_groups', function(Blueprint $table)
		{
			$table->dropColumn('description');
		});
	}

}
