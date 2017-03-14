<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveJoinedFipraAndTotalFipraWorkingTimeFieldsFromUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('joined_fipra');
			$table->dropColumn('total_fipra_working_time');
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
			$table->date('joined_fipra')->after('date_of_birth');
			$table->string('total_fipra_working_time')->after('date_of_birth');
		});
	}

}
