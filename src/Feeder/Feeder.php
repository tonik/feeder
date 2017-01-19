<?php

namespace Tonik\Feeder;

use GuzzleHttp\ClientInterface;
use Tonik\Feeder\Feed\FacebookFeed;
use Tonik\Feeder\Feed\InstagramFeed;
use Tonik\Feeder\Feed\SocialFeed;
use Tonik\Feeder\Feed\TwitterFeed;
use Vinkla\Instagram\Instagram;

class Feeder
{
    /**
     * Construct feeder.
     *
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Creates Twitter feed.
     *
     * @param  string $profile
     * @param  array  $arguments
     *
     * @return \Tonik\Feeder\Feed\TwitterFeed
     */
    public function twitter($profile, array $arguments = [])
    {
        return new TwitterFeed($this->client, [
            'name' => $profile,
            'keys' => [
                'customer_key' => $arguments['customer_key'],
                'customer_secret' => $arguments['customer_secret'],
            ],
        ]);
    }

    /**
     * Creates Facebook feed.
     *
     * @param  string $profile
     * @param  array  $arguments
     *
     * @return \Tonik\Feeder\Feed\FacebookFeed
     */
    public function facebook($profile, array $arguments = [])
    {
        return new FacebookFeed($this->client, [
            'name' => $profile,
            'keys' => [
                'app_id' => $arguments['app_id'],
                'app_secret' => $arguments['app_secret'],
            ],
        ]);
    }

    /**
     * Creates Instagram feed.
     *
     * @param  string $profile
     * @param  array  $arguments
     *
     * @return \Tonik\Feeder\Feed\InstagramFeed
     */
    public function instagram($profile, array $arguments = [])
    {
        return new InstagramFeed($this->client, ['name' => $profile]);
    }

    /**
     * Creates feeds stream.
     *
     * @param  array  $feeds
     *
     * @return \Tonik\Feeder\Feed\SocialFeed
     */
    public function feed(array $feeds)
    {
        return new SocialFeed($feeds);
    }
}
