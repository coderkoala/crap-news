<?php

namespace App\Http\Controllers\Frontend;

use App\News\Like;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Models\News\Source;
use App\Models\News\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController.
 */
class HomeController extends Controller {

	/**
	 * @return \Illuminate\View\View
	 */
	public function index() {
		$data['news']      = array();
		$data['headlines'] = array();

		/**
		 * Making sure we get distinct source for each category.
		 *
		 * Groups by category, so at least one is gotten.
		 *
		 * ref: https://stackoverflow.com/a/4775879
		 */
		$Object_Category = DB::select(
			DB::raw(
				'
                select id, category
                from   (select id, country, category,
                               @num := if(@group = category, @num + 2, 1) as row_number,
                               @group := category as dummy
                        from   sources
                        where country = "us"
                        ) as x
                where  row_number <= 1
                '
			)
		);

		foreach ( $Object_Category as $category ) {
			$articles = new Source();

			$news                                = $articles->find( $category->id )->news()->inRandomOrder()->limit( 6 )->get()->toArray();
			$data['news'][ $category->category ] = $news;
		}
		$data['news'] = collect( $data['news'] );

		return view( 'frontend.index', $data );
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function slug( $slug ) {
		$current_user = Auth::user();
		$current_user = isset( $current_user->id ) ? $current_user->id : null;
		$article      = new DB();
		$rating       = new Rating();
		$article      = (array) DB::table( 'articles' )
								->join( 'sources', 'articles.source', '=', 'sources.id' )
								->select( 'articles.*', 'sources.canonical', 'sources.category' )
								->where( 'articles.slug', $slug )
								->first();
		$reaction     = Like::where( 'news_id', $article['id'] )->first();

		// Register page hit
		$pageHits = $rating->where( 'id_news', $article['id'] )->first();

		if ( $current_user && $reaction ) {
			$current_user = 'like' === $reaction->rating ? 'like' : 'dislike';
		} else {
			$current_user = '';
		}

		// Increment if it already hasn't been.
		if ( $pageHits ) {
			++$pageHits->pagehits;
			$pageHits->update();
			$rating = $pageHits->toArray();
		} else {
			$rating = $rating->create(
				array(
					'id_news'  => $article['id'],
					'pagehits' => 1,
				)
			);
		}

		return view(
			'frontend.slug',
			compact(
				array( 'article', 'rating', 'current_user' )
			)
		);
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function category( Request $request ) {

		// Sanitize just in case.
		$country = filter_var( $request->country, FILTER_SANITIZE_STRING );
		$source  = filter_var( $request->source, FILTER_SANITIZE_STRING );

		// Check offset for "load More"
		$offset = 0 !== (int) $request->next ? 'OFFSET ' . (int) $request->next : '';

		// Direct Access fallback. @todo Middleware & Segregate API with view route.
		if ( $offset && empty( $request->signature ) && $request->expires > now()->timestamp ) {
			return redirect()->route( 'frontend.index' );
		}

		$query_param = '';
		$doing_ajax  = empty( $offset ) ? false : true;

		// Compose SQL param for join.
		if ( ! empty( $source ) && ! empty( $country ) ) {

			$query_param = ! empty( $source ) ? "AND a.`name`='{$source}'" : '';
		} elseif ( ! empty( $country ) && empty( $source ) ) {

			$query_param = ! empty( $country ) ? "AND a.`country`='{$country}' " : '';
		} else {
			$query_param = ! empty( $source ) ? "AND a.`name`='{$source}'" : '';
		}

		// Inject params and begin preparing view.
		$data['results'] = DB::select(
			"
            SELECT
            b.id, b.slug, b.author, b.title, b.description, b.urlToImage, b.publishedAt
            FROM
            `sources` AS a
            INNER JOIN
            `articles` AS b
            ON
            a.`id` = b.`source`
            {$query_param}
            LIMIT 6
            {$offset}
		"
		);
		$offset          = last( $data['results'] ) ? last( $data['results'] )->id : '-1';
		$data['get_url'] = '-1' === $offset ? '' : URL::temporarySignedRoute(
			'frontend.category',
			now()->addMinutes( 30 ),
			array(
				'country' => $country,
				'source'  => $source,
				'next'    => $offset,
			)
		);

		if ( ! $doing_ajax ) {
			// dd( $request->all(), $offset, $data );
			return view( 'frontend.category', $data );
		} else {
			return response()->json(
				array(
					'status'  => 200,
					'payload' => $data,
				),
				200
			);
		}
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function about() {
		return view( 'frontend.about' );
	}
}
