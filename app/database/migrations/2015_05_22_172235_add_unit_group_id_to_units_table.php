<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnitGroupIdToUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('units', function(Blueprint $table)
        {
            $table->integer('unit_group_id')->unsigned()->default(0)->after('email');
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
            $table->dropColumn('unit_group_id');
        });
	}

}
