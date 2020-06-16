<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create(
			'likes',
			function ( Blueprint $table ) {
				$table->bigIncrements( 'id' );
				$table->unsignedBigInteger( 'news_id' );
				$table->unsignedBigInteger( 'user' );
				$table->enum( 'rating', array( 'like', 'dislike' ) )->nullable();
				$table->timestamps();

				$table->foreign( 'user' )->references( 'id' )->on( 'users' );
				$table->foreign( 'news_id' )->references( 'id' )->on( 'articles' );
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'likes' );
	}
}
