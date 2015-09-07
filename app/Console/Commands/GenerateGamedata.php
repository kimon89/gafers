<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Game;

class GenerateGamedata extends Command {

        /**
         * The console command name.
         *
         * @var string
         */
        protected $name = 'generateGamedata';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Generate gamedata.json file';

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct()
        {
                parent::__construct();
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function fire()
        {   
            $all_games_db = Game::all()->toArray();
         
            //game aliases
            $aliases = [
                'gta' => 'grand theft auto',
                'lol' => 'league of legends'
            ];

            $main_obj = [];
            $main_obj['suggestions'] = [];

            foreach ($all_games_db as $game_data) {
               $game = [];
               $game['data'] = $game_data['id'];
               $game['value'] = $game_data['name'];
               $main_obj['suggestions'][] = $game;
            }
            $main_obj->aliases = $aliases;
            //create the json file
            file_put_contents('public/gamedata.json',json_encode($main_obj));
            $this->info('gamedata.json done');
        }
}
