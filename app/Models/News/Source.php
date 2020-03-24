<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

class Source extends Model {

	protected $table       = 'sources';
	protected $primary_key = 'id';
	protected $fillable    = array(
		'name',
		'canonical',
		'category',
		'country',
	);

	public function news() {
		return $this->hasMany( 'App\Models\News\Articles', 'source', 'id' );
	}
}
