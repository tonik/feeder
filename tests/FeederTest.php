<?php

use GuzzleHttp\Client;
use Tonik\Feeder\Feed\TwitterFeed;
use Tonik\Feeder\Feeder;

class FeederTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_throw_on_missing_twitter_api_keys()
    {
        $client = $this->getClient();
        $feeder = $this->getFeeder($client);
    }

    public function getClient()
    {
        return Mockery::mock(Client::class);
    }

    public function getFeeder($client)
    {
        return new Feeder($client);
    }
}