<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create(
			'rating',
			function ( Blueprint $table ) {
				$table->bigIncrements( 'id' );
				$table->unsignedBigInteger( 'id_news' )->index();
				$table->unsignedBigInteger( 'likes' )->index()->default( 0 );
				$table->unsignedBigInteger( 'dislikes' )->index()->default( 0 );
				$table->unsignedBigInteger( 'pagehits' )->index()->default( 0 );
				// $table->unsignedBigInteger( 'user' );
				$table->timestamps();
				$table->index(
					array(
						'likes',
						'dislikes',
						'pagehits',
						// 'user',
					)
				);

				// $table->foreign( 'user' )->references( 'id' )->on( 'users' );
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'rating' );
	}
}
