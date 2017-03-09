<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientIdUnitNameUserNameAccountDirectorNameFieldsToCasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cases', function(Blueprint $table)
		{
			$table->integer('client_id')->unsigned()->index()->after('client');
			$table->string('unit_name')->after('unit_id');
			$table->string('user_name')->after('user_id');
			$table->string('account_director_name')->after('account_director_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cases', function(Blueprint $table)
		{
			$table->dropColumn('client_id');
			$table->dropColumn('unit_name');
			$table->dropColumn('user_name');
			$table->dropColumn('account_director_name');
		});
	}

}
