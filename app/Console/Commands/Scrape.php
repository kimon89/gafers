<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Game;

class Scrape extends Command {

        /**
         * The console command name.
         *
         * @var string
         */
        protected $name = 'scrape';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Get list of games from source';

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
            //get data from source
            $final_titles = $this->scrap('1');

            foreach(range('a','z') as $letter) {
                $final_titles = array_merge($final_titles,$this->scrap($letter));
            }
            file_put_contents('resources/gamedata.json',json_encode($final_titles));
            $this->info('Gamedata json generated');
            
            //compare to database data
            $this->info('Comparing to database');
            $all_games_db = Game::all()->toArray();
            $all_games_db_ready = array_map(function($game){
                return $game['name'];
            }, $all_games_db);
            $all_games_from_json = $final_titles;
            $diff = array_diff($all_games_from_json, $all_games_db_ready);
            
            //insert new data if needed
            if (count($diff)) {
                $this->info('Differences found');
                foreach($diff as $game_name) {
                    //check if games exists
                    if(Game::where('name',$game_name)->exists()) {
                        $this->info($game_name . ' already exists in the database');
                    } else {
                        $this->info($game_name . ' does not exist in the database');
                        $this->info('Inserting: ' . $game_name);
                        $game = new Game();
                        $game->name = $game_name;
                        $id = $game->save();
                        if ($id) {
                            $this->info('Inserting: ' . $game_name . ' Done ' . $id);
                        } else {
                            $this->info('Failed to insert: ' . $game_name);
                        }
                    }
                }
            } else {
                $this->info('No differences found');
            }
            
            
        }
        
        
        private function scrap($letter) {
            $titles = [];
            $url = 'http://www.gamerevolution.com/game/all/'.$letter.'/long_name/asc';
            $this->info('Processing:' . $url);
            $data = file_get_contents($url);
            $data = strstr($data,'<!-- / ALPHA NAVBAR -->');
            $data = strstr($data,'<!-- ALPHA NAVBAR -->',true);
            $data = explode('class="headline">',$data);

            foreach($data as $k => $entry) {
                if ($k == 0) {
                    continue;
                }
                $titles[] = explode('</a></td>',$entry)[0];
            }
            $this->info('Done Processing:' . $url);
            return array_unique($titles);
        }
//
//        /**
//         * Get the console command arguments.
//         *
//         * @return array
//         */
//        protected function getArguments()
//        {
////                return [
////                        ['example', InputArgument::REQUIRED, 'An example argument.'],
////                ];
//        }
//
//        /**
//         * Get the console command options.
//         *
//         * @return array
//         */
//        protected function getOptions()
//        {
////                return [
////                        ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
////                ];
//        }
        
        

}
