<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model {

	protected $table       = 'rating';
	protected $primary_key = 'id';
	protected $fillable    = array(
		'id_news',
		'likes',
		'dislikes',
		'pagehits',
	);
}
