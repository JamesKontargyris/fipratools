<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSurveyFieldsToUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->date('date_of_birth');
			$table->date('joined_fipra');
			$table->string('total_fipra_working_time');
			$table->string('other_network');
			$table->string('formal_positions');
			$table->boolean('survey_updated')->unsigned()->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('date_of_birth');
			$table->dropColumn('joined_fipra');
			$table->dropColumn('total_fipra_working_time');
			$table->dropColumn('other_network');
			$table->dropColumn('formal_positions');
			$table->dropColumn('survey_updated');
		});
	}

}
