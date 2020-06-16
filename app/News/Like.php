<?php

namespace App\News;

use Illuminate\Database\Eloquent\Model;

class Like extends Model {

	protected $table       = 'likes';
	protected $primary_key = 'id';
	protected $fillable    = array(
		'news_id',
		'user',
		'rating',
	);
}
