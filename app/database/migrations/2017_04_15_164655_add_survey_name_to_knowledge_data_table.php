<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSurveyNameToKnowledgeDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('knowledge_data', function(Blueprint $table)
		{
			$table->string('survey_name')->after('data_value');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('knowledge_data', function(Blueprint $table)
		{
			$table->dropColumn('survey_name');
		});
	}

}
