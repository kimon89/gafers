<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
		'App\Console\Commands\Scrape',
		'App\Console\Commands\GenerateGamedata',
		'App\Console\Commands\ConvertFiles',
		'App\Console\Commands\GetConverted',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		//$schedule->command('scrape')->hourly();
		$schedule->command('convertFiles')->withoutOverlapping();
		$schedule->command('getConverted')->withoutOverlapping();
	}

}
