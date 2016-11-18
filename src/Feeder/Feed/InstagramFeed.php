<?php

namespace Tonik\Feeder\Feed;

use GuzzleHttp\Client;
use Tonik\Feeder\Contracts\FetchableInterface;
use Tonik\Feeder\Feed\Exceptions\NotFetchedException;
use Tonik\Feeder\Post\InstagramPost;

class InstagramFeed extends Feed implements FetchableInterface
{
    /**
     * API host url.
     *
     * @var string
     */
    const API_HOST = 'https://www.instagram.com';

    /**
     * Http client.
     *
     * @var \GuzzleHttp\Client $client
     */
    protected $client;

    /**
     * List of requested fields.
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * Construct feed.
     *
     * @param \GuzzleHttp\Client $client
     * @param array $arguments
     */
    public function __construct(Client $client, $arguments = [])
    {
        $this->client = $client;
        $this->arguments = array_merge($this->arguments, $arguments);
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
        $response = $this->client->request('GET', $this->getPath());

        if (200 === $response->getStatusCode()) {
            $posts = json_decode($response->getBody()->getContents());

            return $this->decoratePosts($posts->items, InstagramPost::class);
        }

        throw new NotFetchedException('Could not fetch items from Instagram feed.');
    }

    /**
     * Gets API query part.
     *
     * @return string
     */
    public function getQuery()
    {
        return "{$this->getName()}/media";
    }
}
