<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleFieldToLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('links', function(Blueprint $table)
		{
			// Поле содержит заголовок страницы для дополнительного поиска и анализа базы данных
			// при поиске необходимого ресурса
			$table->string('title')->nullable()->default( null )->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('links', function(Blueprint $table)
		{
			$table->dropColumn('title');
		});
	}

}
