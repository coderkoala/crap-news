<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create(
			'sources',
			function ( Blueprint $table ) {
				$table->bigIncrements( 'id' );
				$table->string( 'name', 56 )->unique();
				$table->string( 'canonical', 56 );
				$table->string( 'category', 50 )->index();
				$table->string( 'country', 2 )->index();
				$table->timestamps();
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'sources' );
	}
}
