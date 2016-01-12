<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalogs', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade');

			$table->integer('serial_id')->unsigned();
			$table->foreign('serial_id')
				->references('id')->on('serials')
				->onDelete('cascade');

			$table->tinyInteger('season');
			$table->tinyInteger('serie');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('catalogs');
	}

}
