<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFluentFieldFromKnowledgeLanguageUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('knowledge_language_user', function(Blueprint $table)
		{
			$table->dropColumn('fluent');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('knowledge_language_user', function(Blueprint $table)
		{
			$table->boolean('fluent')->default(0);
		});
	}

}
