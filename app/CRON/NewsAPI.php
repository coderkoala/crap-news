<?php
namespace App\CRON;

/**
 * NewsOrg Class GuzzleAPI
 *
 * @author  @coderkoala
 * @package CRON\GuzzleAPI
 * @version 1.0.0
 * @since   1.0.0
 */

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Support\Facades\Log;

/**
 * @class NewsAPI Fetch top headlines from newsapi.org.
 */
final class NewsAPI {


	/**
	 * Guzzle Instance
	 *
	 * @var GuzzleHttp\Client
	 */
	private $guzzler;

	/**
	 * API Parameter
	 *
	 * @var array
	 */
	private $param;

	/**
	 * Composer function for the request for news.
	 */
	private function url_param() {
		return "?apiKey={$this->param['apiKey']}&sources={$this->param['source']}";
	}

	/**
	 * Composer function for the sources.
	 */
	private function source_param() {
		return "?apiKey={$this->param['apiKey']}";
	}

		/**
		 * Fetching the news asynchronously.
		 *
		 * !! For CRON purposes only.
		 */
	private function news_fetcher_async() {

		// Send an asynchronous request.
		$do_request = new GuzzleRequest(
			'GET',
			env( 'NEWS_API_ENDPOINT' ) .
			$this->url_param()
		);
		try {
			$this->guzzler->sendAsync( $do_request )->then(
				function ( $response ) {

					// Queue it.
					$doSomething = json_decode( $response->getBody(), true );
				}
			);
		} catch ( Exception $e ) {
			Log::error( $e->getMessage() );
		}
	}

	/**
	 * Synchronous news fetching.
	 */
	private function news_fetcher() {

		// Send an synchronous request.
		try {
			$newsObject = $this->guzzler->request(
				'GET',
				$this->param['endpoint'] .
				$this->url_param()
			);

			return json_decode( $newsObject->getBody(), true );
		} catch ( Exception $e ) {
			Log::error( $e->getMessage() );
		}

	}

		/**
		 * Constructor
		 */
	public function __construct() {
		$this->guzzler = new GuzzleClient();
		$this->param   = array(
			'apiKey'   => env( 'NEWS_API_SECRET' ),
			'endpoint' => env( 'NEWS_API_ENDPOINT' ),
		);

	}

	/**
	 * The invoker function, this helps potentially reuse of object.
	 *
	 * @todo need to make a singleton class so queueing needs less memory.
	 *
	 * @param string $source   Source of the news feed.
	 * @param string $priority 'async' by default.
	 */
	public function invoke( $source, $priority = '' ) {
		$this->param['source'] = $source;

		if ( 'now' === $priority ) {
			return $this->news_fetcher();
		} else {
			$this->news_fetcher_async();
		}
	}

	/**
	 * Synchronous news source fetch.
	 */
	public function source_fetcher() {

		// Send an synchronous request.
		try {
			$newsObject = $this->guzzler->request(
				'GET',
				env( 'NEWS_SOURCE_ENDPOINT' ) .
				$this->source_param()
			);

			return json_decode( $newsObject->getBody(), true );
		} catch ( Exception $e ) {
			Log::error( $e->getMessage() );
		}

	}
}
