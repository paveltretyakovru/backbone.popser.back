<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastlinkFieldToCatalogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('catalogs', function(Blueprint $table)
		{
			// Поле содержит автоматически сохраненную ссылку последней серии сериала
			$table->string('lastlink')->nullable()->default(null)->after('link');
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
			$table->dropColumn('lastlink');
		});
	}

}
