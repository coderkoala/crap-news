<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\CRON\NewsAPI;
use Symfony\Component\Console\Output\ConsoleOutput;

class SourcesSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$iterator   = 0;
		$api        = new NewsAPI();
		$logger     = new ConsoleOutput();
		$newsObject = $api->source_fetcher();
		$mapper     = array();

		if ( ! isset( $newsObject ) ) {
			$logger->writeln( '<error>[ERROR]</error> Couldn\'t load sources. Possible API throttling.' );
			exit;
		} else {
			$newsObject = $newsObject['sources'];
		}
		$count = count( $newsObject );
		$logger->writeln( "<comment>[INFO]</comment> {$count} sources found. Writing them to the DB, please wait ..." );
		array_walk(
			$newsObject,
			function( &$tuple, $key, $mapper ) {
				++$mapper['iterator'];
				$mapper['payload'] [] = array(
					'name'      => $tuple['id'],
					'canonical' => $tuple['name'],
					'category'  => $tuple['category'],
					'country'   => $tuple['country'],
				);
				$mapper['logger']->writeln( "<comment>[INFO]</comment> ({$mapper['iterator']}/{$mapper['count']}) Discovered {$tuple['name']}" );
			},
			array(
				'payload'  => &$mapper,
				'iterator' => &$iterator,
				'count'    => count( $newsObject ),
				'logger'   => $logger,
			)
		);

		$logger->writeln( '<comment>[INFO]</comment> Writing to database, please wait.' );

		try {
			DB::table( 'sources' )->insertOrIgnore( $mapper );
			$logger->writeln( '<info>[SUCCESS]</info> Done with importing news Sources.' );
		} catch ( Exception $e ) {
			$sqlState  = $e->errorInfo[0];
			$errorCode = $e->errorInfo[1];
			if ( $sqlState === '23000' && $errorCode === 1062 ) {
				$logger->writeln( '<info>[SUCCESS]</info> Done with importing news Sources. No new entries.' );
			} else {
				$this->logger->writeln( '<warning>[ERROR]</warning> Couldn\'t commit the fetched sources : [SQLCODE] ' . $e->getCode() );

			}
		}

	}
}
