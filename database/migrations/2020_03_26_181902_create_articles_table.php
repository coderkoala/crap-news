<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create(
			'articles',
			function ( Blueprint $table ) {
				$table->bigIncrements( 'id' );
				$table->string( 'slug' )->unique();
				$table->string( 'author', 256 )->index();
				$table->string( 'title', 320 )->index();
				$table->string( 'description', 320 );
				$table->string( 'url' )->default( 'null' );
				$table->string( 'urlToImage' );
				$table->dateTime( 'publishedAt' );
				$table->string( 'content', 500 );
				$table->unsignedBigInteger( 'source' );
				$table->timestamps();

				$table->foreign( 'source' )->references( 'id' )->on( 'sources' );
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'articles' );
	}
}
