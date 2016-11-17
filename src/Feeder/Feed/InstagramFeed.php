<?php

namespace Tonik\Feeder\Feed;

use Tonik\Feeder\Post\InstagramPost;
use Vinkla\Instagram\Instagram;

class InstagramFeed extends Feed
{
    /**
     * Construct feed.
     *
     * @param \Vinkla\Instagram\Instagram $api
     * @param array $arguments
     */
    public function __construct(Instagram $api, $arguments = [])
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
        $posts = $this->api->get($this->arguments['profile_slug']);

        return $this->decorate($posts, InstagramPost::class);
    }
}
