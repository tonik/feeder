<?php

namespace Tonik\Feeder\Feed;

use Facebook\Facebook;
use Tonik\Feeder\Post\FacebookPost;

class FacebookFeed extends Feed
{
    /**
     * Construct feed.
     *
     * @param \Facebook\Facebook $api
     * @param array $arguments
     */
    public function __construct(Facebook $api, $arguments = [])
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
        try {
            $response = $this->api->get("/{$this->arguments['profile_slug']}/posts?fields=full_picture,message,created_time,story,permalink_url");
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // Fail silently.
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // Fail silently.
        }

        if (isset($response)) {
            $post = $response->getDecodedBody();

            return $this->decorate($post['data'], FacebookPost::class);
        }
    }
}
