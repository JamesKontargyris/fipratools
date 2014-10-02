<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAddressAndContactFieldsToUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('units', function(Blueprint $table)
		{
			$table->string('address1');
			$table->string('address2')->nullable();
			$table->string('address3')->nullable();
			$table->string('address4')->nullable();
			$table->string('post_code');
			$table->string('phone');
			$table->string('fax');
			$table->string('email');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('units', function(Blueprint $table)
		{
			$table->dropColumn('address1');
			$table->dropColumn('address2');
			$table->dropColumn('address3');
			$table->dropColumn('address4');
			$table->dropColumn('post_code');
			$table->dropColumn('phone');
			$table->dropColumn('fax');
			$table->dropColumn('email');
		});
	}

}
