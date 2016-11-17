<?php

namespace Tonik\Feeder\Feed;

use Abraham\TwitterOAuth\TwitterOAuth;
use Tonik\Feeder\Post\TwitterPost;

class TwitterFeed extends Feed
{
    /**
     * Construct feed.
     *
     * @param \Abraham\TwitterOAuth\TwitterOAuth $api
     * @param array $arguments
     */
    public function __construct(TwitterOAuth $api, $arguments = [])
    {
        $this->api = $api;
        $this->arguments = $arguments;
    }

    /**
     * Gets collection of feed items.
     *
     * @param integer $limit
     *
     * @return array
     */
    public function getItems($limit = 5)
    {
        $posts = $this->api->get('statuses/user_timeline', [
            'screen_name' => $this->arguments['profile_slug'],
            'exclude_replies' => true,
            'include_rts' => false,
            'count' => $limit,
        ]);

        return $this->decorate($posts, TwitterPost::class);
    }
}
