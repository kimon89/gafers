<?php
function scrap($letter) {
	$titles = [];
	$data = file_get_contents('http://www.gamerevolution.com/game/all/'.$letter.'/long_name/asc');
	$data = strstr($data,'<!-- / ALPHA NAVBAR -->');
	$data = strstr($data,'<!-- ALPHA NAVBAR -->',true);
	$data = explode('class="headline">',$data);

	foreach($data as $k => $entry) {
		if ($k == 0) {
			continue;
		}
	 	$titles[] = explode('</a></td>',$entry)[0];
	}
	return $titles;
}


$final_titles = scrap('1');

foreach(range('a','z') as $letter) {
	$final_titles = array_merge($final_titles,scrap($letter));
}

// $main_obj = new StdClass();
// $main_obj->suggestions = [];
$fdata = [];
 foreach ($final_titles as $k => $title) {
	$game = new StdClass();
	$game->id = $k;
	$game->name = $title;
	$fdata[] = $game;
 }
file_put_contents('gamedata.json',json_encode($fdata));