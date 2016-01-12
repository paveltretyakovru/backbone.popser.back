<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('links', function(Blueprint $table)
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

			$table->string('url')->nullable()->default( null );
			$table->tinyInteger('season')->default( 0 );
			$table->tinyInteger('serie')->default( 0 );
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
		Schema::drop('links');
	}

}
