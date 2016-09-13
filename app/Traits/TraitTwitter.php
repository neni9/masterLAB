<?php

namespace App\Traits;

use File;

trait TraitTwitter
{
	public function getTweets($limit)
	{
		return json_decode(\Twitter::getUserTimeline(['screen_name' => 'elyceelab', 'count' => $limit, 'format' => 'json']));
	}

	public function setTweet($content)
	{
		if(strlen($content) > 140) return false;

		return \Twitter::postTweet(['status' => $content , 'format' => 'json']);
	}

	public function setMediaTweet($content,$media)
	{
		$uploaded_media = \Twitter::uploadMedia(['media' => File::get($media)]);
    	return \Twitter::postTweet(['status' => 'test', 'media_ids' => $uploaded_media->media_id_string]);
	}


}