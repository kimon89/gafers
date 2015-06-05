<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Game;

class GameTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('games')->delete();
		$file_data = json_decode(file_get_contents('public/gamedata.json'));
		foreach ($file_data as  $game_title) {
			Game::create(['name' => $game_title]);
		}
	}

}
