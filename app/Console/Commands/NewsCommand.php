<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Models\News\Source;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\CRON\NewsAPI;

class NewsCommand extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'fetch {arg}';

	/**
	 * Source Model for iterating over news sources.
	 *
	 * @var App\Models\News\Source
	 */
	private $sources;

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Allows importing News from API endpoints.';


	/**
	 * News Populator in Database.
	 *
	 * @param array $sources
	 */
	private function news_populator( &$sources ) {
		$api       = new NewsAPI();
		$newsArray = array();
		$count     = 0;

		foreach ( $sources as $sourcesTuple ) {
			$newsObject = $api->invoke( $sourcesTuple['name'], 'now' );
			$this->logger->writeln( "<comment>[FETCH]</comment>   {$sourcesTuple['canonical']}" );

			if ( isset( $newsObject['articles'] ) ) {

				$count += count( $newsObject['articles'] );

				// Map values with model.
				array_walk(
					$newsObject['articles'],
					// Callback function.
					function( &$tuple, $key, $mapper ) {
						$date = date( 'Y-m-d H:i:s', strtotime( $tuple['publishedAt'] ) );

						// Content can't be null - skip record.
						if ( ! empty( $tuple['content'] ) && ! empty( $tuple['urlToImage'] ) || ( null === (string) $tuple['urlToImage'] ) ) {
							$mapper['news'][] = array(
								'slug'        => md5( base64_encode( $tuple['author'] . $tuple['title'] . $tuple['publishedAt'] ) ),
								'author'      => empty( $tuple['author'] ) ? 'Anonymous' : $tuple['author'],
								'title'       => $tuple['title'],
								'description' => $tuple['description'],
								'url'         => $tuple['url'],
								'urlToImage'  => $tuple['urlToImage'],
								'publishedAt' => $date,
								'content'     => $tuple['content'],
								'source'      => $mapper['source']['id'],
								'created_at'  => $date,
								'updated_at'  => $date,
							);
						}
					},
					// Address pass into callback.
					array(
						'source' => &$sourcesTuple,
						'news'   => &$newsArray,
						'total'  => count( $newsObject['articles'] ),
					)
				);

				$this->logger->writeln( "<info>[SUCCESS]</info> {$sourcesTuple['canonical']}" );
			} else {
				// Maybe API rate got limited/server downtime/connection issues.
				$this->logger->writeln( '<comment>[FAILED]</comment>  Possible API throttle.' );
				continue;
			}
		}

		try {
			$this->logger->writeln( "<comment>[COMMIT]</comment>  Attempting to write {$count} news entries in Database. " );
			DB::table( 'articles' )->insertOrIgnore( $newsArray );
			$this->logger->writeln( '<info>[SUCCESS]</info> Successfully commited into the Database. ' );
			return $count;
		} catch ( \Exception $e ) {
			if ( 1062 !== $e->getCode() ) {
				$this->logger->writeln( '<info>[ERROR]</info> SQL Error Code.' . $e->getCode() );

			}
			$sqlState  = $e->errorInfo[0];
			$errorCode = $e->errorInfo[1];
			if ( $sqlState === '23000' && $errorCode === 1062 ) {
				return $count;
			}

			$this->logger->writeln( '<info>[ERROR]</info> ' . $e->getMessage() );
			return $count;
		}
	}

	/**
	 * Gather existing sources.
	 */
	private function sources_fetcher() {
		$sources = new Source();
		$sources = $sources->select( 'id', 'name', 'canonical' )->get()->toArray();
		$count   = count( $sources );

		if ( 0 === $count ) {
			return $count;
		} else {
			return $this->news_populator( $sources );
		}
	}
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->logger = new ConsoleOutput();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$command = $this->argument( 'arg' );

		switch ( $command ) {

			case 'sources':
				Artisan::call(
					'db:seed',
					array(
						'--class' => 'SourcesSeeder',
					)
				);
				break;

			case 'news':
				// pull news
				$count = $this->sources_fetcher();
				if ( 0 === $count ) {
					$this->logger->writeln( 'No news imported. Did you run <info>php artisan fetch sources</info> first?' );
				} else {
					$this->logger->writeln( "<info>[SUCCESS]</info> Processed {$count} news." );
				}
				break;

			default:
				$this->logger->writeln( '<error>Unknown Command.  Available commands:</error>' );
				$this->logger->writeln( '<info>php artisan fetch sources</info> - Fetch Sources.' );
				$this->logger->writeln( '<info>php artisan fetch news</info> - Fetch News.' );
				$this->logger->writeln( '<comment>Make sure to fetch sources first!</comment>' );
		}
	}
}
