<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveShortNameFieldFromKnowledgeLanguagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('knowledge_languages', function(Blueprint $table)
		{
			$table->dropColumn('short_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('knowledge_languages', function(Blueprint $table)
		{
			$table->string('short_name')->after('name');
		});
	}

}
