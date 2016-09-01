<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCommentsFieldInClientsTableToLongText extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('clients', function(Blueprint $table)
		{
			$table->dropColumn('comments');
		});

		Schema::table('clients', function(Blueprint $table)
		{
			$table->longText('comments')->after('account_director_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('clients', function(Blueprint $table)
		{
			$table->dropColumn('comments');
		});

		Schema::table('clients', function(Blueprint $table)
		{
			$table->string('comments')->after('account_director_id');
		});
	}

}
