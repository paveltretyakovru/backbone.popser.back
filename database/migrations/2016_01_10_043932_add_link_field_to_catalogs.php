<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkFieldToCatalogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('catalogs', function(Blueprint $table)
		{
			$table->string('link')->after('title');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('catalogs', function(Blueprint $table)
		{
			$table->dropColumn('link');
		});
	}

}
