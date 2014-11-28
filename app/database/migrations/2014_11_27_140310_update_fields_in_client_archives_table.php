<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsInClientArchivesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('client_archives', function($table)
		{
			$table->dropColumn('start_date');
			$table->dropColumn('end_date');
			$table->date('date')->after('client_id');
			$table->string('unit')->after('date');
			$table->string('account_director')->after('unit');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('client_archives', function($table)
		{
			$table->date('start_date');
			$table->date('end_date');
			$table->dropColumn('date');
			$table->dropColumn('unit');
			$table->dropColumn('account_director');
		});
	}

}
