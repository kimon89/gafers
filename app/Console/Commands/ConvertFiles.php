<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Post;

class ConvertFiles extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'convertFiles';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sends all unconverted files to the api for conversion';

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
		$this->info('convert files is running');
		$posts = Post::where('status','=','uploaded')->get();
		//call api to convert the file
		$requests = [];
		$mh = curl_multi_init();
		foreach($posts as $post) {
			$requests[$post->id] = curl_init();
			curl_setopt($requests[$post->id], CURLOPT_URL, 'http://upload.gfycat.com/transcodeRelease/' . $post->track_key . '?noResize=true');
			curl_setopt($requests[$post->id], CURLOPT_HEADER, 0);
			curl_setopt($requests[$post->id], CURLOPT_RETURNTRANSFER, 1);
			curl_multi_add_handle($mh, $requests[$post->id]);
			
		}

		$running = 1;
		while($running) {
			curl_multi_exec($mh, $running);
		}

		foreach ($requests as $post_id => $request) {
			$res_obj = json_decode((String) curl_multi_getcontent($request));
			if (isset($res_obj->isOk)) {
				//conversion request sent
				//update the post status in database
				$post = $posts->find($post_id);
				$post->status = 'converting';
				$post->save();
			} else {
				$this->info(json_encode($res_obj));
				//do the same thing for now
				$post = $posts->find($post_id);
				$post->status = 'converting';
				$post->save();
			}
			curl_multi_remove_handle($mh, $request);
		}
		curl_multi_close($mh);
	}
}
