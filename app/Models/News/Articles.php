<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model {

	protected $table       = 'articles';
	protected $primary_key = 'id';
	protected $fillable    = array(
		'slug',
		'author',
		'title',
		'description',
		'url',
		'urlToImage',
		'publishedAt',
		'content',
		'source',
		'created_at',
		'updated_at',
	);

	public function source() {
		return $this->belongsTo( 'App\Models\News\Source', 'source', 'id' );
	}

}
