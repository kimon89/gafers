<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Post;
use Log;

class GetConverted extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'getConverted';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get converted files data';

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
		$this->info('get converted files');
		$posts = Post::whereIn('status',['converted','converting'])->get();
		//call api to convert the file
		$requests = [];
		$posts_converted = [];

		$mh = curl_multi_init();
		foreach($posts as $post) {
			if ($post->status == 'converting') {
				$requests[$post->id] = curl_init();
				curl_setopt($requests[$post->id], CURLOPT_URL, 'http://upload.gfycat.com/status/' . $post->track_key);
				curl_setopt($requests[$post->id], CURLOPT_HEADER, 0);
				curl_setopt($requests[$post->id], CURLOPT_RETURNTRANSFER, 1);
				curl_multi_add_handle($mh, $requests[$post->id]);
			} else {
				//it has already been converted
				$posts_converted[$post->file_name] = $post;
			}
		}

		$running = 1;
		while($running) {
			curl_multi_exec($mh, $running);
		}

		
		$posts_invalid = [];
		foreach ($requests as $post_id => $request) {
			$content = curl_multi_getcontent($request);
			$res_obj = json_decode((String) $content);
			if ($res_obj->task == 'encoding')
			{
				continue;
			}
			if ($res_obj->task == 'complete') {
				//convertion was succesful
				//store in array in order to get more data later
				$posts_converted[$res_obj->gfyname] = $posts->find($post_id);
			} else if ($res_obj->task == 'error'){
				//no error code unfortunately
				if (strpos($res_obj->error, 'valid') !== false 
					|| strpos($res_obj->error, 'unique') !== false
					|| strpos($res_obj->error, 'Upload') !== false
					|| strpos($res_obj->error, 'seconds max') !== false
					){
					$posts_invalid[] = $posts->find($post_id);
				}
			} else {
				$posts_invalid[] = $posts->find($post_id);
			}
			curl_multi_remove_handle($mh, $request);
		}

		curl_multi_close($mh);

		$mh = curl_multi_init();
		$requests = [];
		//get the data for the converted files
		foreach ($posts_converted as $file_name => $post) {
			$requests[$post->id] = curl_init();
			curl_setopt($requests[$post->id], CURLOPT_URL, 'http://gfycat.com/cajax/get/' . $file_name);
			curl_setopt($requests[$post->id], CURLOPT_HEADER, 0);
			curl_setopt($requests[$post->id], CURLOPT_RETURNTRANSFER, 1);
			curl_multi_add_handle($mh, $requests[$post->id]);
		}

		$running = 1;
		while($running) {
			curl_multi_exec($mh, $running);
		}

		//update the database
		foreach ($requests as $post_id => $request) {
			$post = $posts->find($post_id);
			$res_obj = json_decode((String) curl_multi_getcontent($request));
			$post->webm = str_replace('http','https',$res_obj->gfyItem->webmUrl);
			$post->mp4 = str_replace('http','https',$res_obj->gfyItem->mp4Url);
			$post->gif = str_replace('http','https',$res_obj->gfyItem->gifUrl);
			$post->file_name = $res_obj->gfyItem->gfyName;
			$post->status = 'active';
			$post->save();
			curl_multi_remove_handle($mh, $request);
		}
		curl_multi_close($mh);

		//update status for invalid files
		foreach ($posts_invalid as $k => $post) {
			$post->status = 'invalid';
			$post->save();
		}
	}


}
