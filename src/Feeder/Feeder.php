<?php

namespace Tonik\Feeder;

use Abraham\TwitterOAuth\TwitterOAuth;
use Facebook\Facebook;
use Tonik\Feeder\Feed\FacebookFeed;
use Tonik\Feeder\Feed\InstagramFeed;
use Tonik\Feeder\Feed\SocialFeed;
use Tonik\Feeder\Feed\TwitterFeed;
use Vinkla\Instagram\Instagram;

class Feeder
{
    /**
     * Creates Twitter feed.
     *
     * @param  string $profile
     * @param  array  $arguments
     *
     * @return \Tonik\Feeder\Feed\TwitterFeed
     */
    public static function twitter($profile, array $arguments = [])
    {
        $api = new TwitterOAuth(
            $arguments['api_key'],
            $arguments['api_secret_key'],
            $arguments['access_token'],
            $arguments['access_secret']
        );

        return new TwitterFeed($api, ['profile_slug' => $profile]);
    }

    /**
     * Creates Facebook feed.
     *
     * @param  string $profile
     * @param  array  $arguments
     *
     * @return \Tonik\Feeder\Feed\FacebookFeed
     */
    public static function facebook($profile, array $arguments = [])
    {
        $appId = $arguments['app_id'];
        $appSecret = $arguments['app_secret'];

        $api = new Facebook([
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_access_token' => "{$appId}|{$appSecret}",
        ]);

        return new FacebookFeed($api, ['profile_slug' => $profile]);
    }

    /**
     * Creates Instagram feed.
     *
     * @param  string $profile
     * @param  array  $arguments
     *
     * @return \Tonik\Feeder\Feed\InstagramFeed
     */
    public static function instagram($profile, array $arguments = [])
    {
        $api = new Instagram;

        return new InstagramFeed($api, ['profile_slug' => $profile]);
    }

    /**
     * Creates feeds stream.
     *
     * @param  array  $feeds
     *
     * @return \Tonik\Feeder\Feed\SocialFeed
     */
    public static function feed(array $feeds)
    {
        return new SocialFeed($feeds);
    }
}
