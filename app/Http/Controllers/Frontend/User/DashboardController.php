<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News\Articles;
use App\Models\News\Rating;
use App\News\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		return view( 'frontend.user.dashboard' );
	}

	/**
	 * Rate update listener function.
	 *
	 * @param Request $request Request payloads.
	 */
	public function rate( Request $request ) {

		$reaction      = new Like();
		$current_user  = Auth::user();
		$article       = Articles::where( 'slug', $request->slug )->first();
		$rating        = Rating::where( 'id_news', $article->id )->first();
		$reactionModel = $reaction->where( 'news_id', $article->id )->first();

		// Arrays for transaction
		$updates_rating = array();

		// Prevent tampers/Issues with retrieval.
		if ( ! $current_user || ! in_array( $request->type, array( 'like', 'dislike' ) ) ) {
			return response()->json(
				array(
					'status' => 'error',
				),
				401
			);

		}

		// Updating reaction type.
		if ( ! $reactionModel ) {
			$updates_rating['news_id'] = $article->id;
			$updates_rating['user']    = $current_user->id;
			$updates_rating['rating']  = $request->type;
		} else {

			if ( $reactionModel->rating === $request->type ) {
				return response()->json(
					array(
						'status' => 'success',
						'data'   => 'redundant',
						403,
					),
					200
				);
			}

			$reactionModel->rating = $request->type;
		}

		// Affecting the counter.
		switch ( $request->type ) {

			case 'like':
				$rating->likes    = ++$rating->likes;
				$rating->dislikes = ( 0 !== $rating->dislikes ) ? --$rating->dislikes : $rating->dislikes;
				break;

			case 'dislike':
				$rating->dislikes = ++$rating->dislikes;
				$rating->likes    = ( 0 !== $rating->likes ) ? --$rating->likes : $rating->likes;
				break;
		}

		try {

			// We approach it as an immutable transaction :
			// If either fails, rollback entirely.
			DB::transaction(
				function () use ( $rating, $reaction, $updates_rating, $reactionModel ) {

					if ( $reactionModel ) {
						$reactionModel->update();
					} else {
						$reaction->create( $updates_rating );
					}
					$rating->update();
				}
			);
		} catch ( \Exception $ex ) {
			return response()->json(
				array(
					'status' => 'error',
					'error'  => $ex->getMessage(),
				),
				500
			);
		}
		return response()->json(
			array(
				'status' => 'success',
				'data'   => array(
					'type'     => $request->type,
					'likes'    => $rating->likes,
					'dislikes' => $rating->dislikes,
				),
				200,
			)
		);
	}
}
