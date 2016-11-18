<?php

namespace Tonik\Feeder\Feed;

use GuzzleHttp\Client;
use Tonik\Feeder\Contracts\FetchableInterface;
use Tonik\Feeder\Feed\Exceptions\CredentialsException;
use Tonik\Feeder\Feed\Exceptions\NotFetchedException;
use Tonik\Feeder\Post\FacebookPost;

class FacebookFeed extends Feed implements FetchableInterface
{
    /**
     * API version.
     *
     * @var string
     */
    const API_VERSION = 'v2.8';

    /**
     * API host url.
     *
     * @var string
     */
    const API_HOST = 'https://graph.facebook.com';

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
    protected $arguments = [
        'fields' => [
            'full_picture',
            'message',
            'created_time',
            'story',
            'permalink_url',
        ],
    ];

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
            $post = json_decode($response->getBody()->getContents());

            return $this->decoratePosts($post->data, FacebookPost::class);
        }

        throw new NotFetchedException('Could not fetch items from Facebook feed.');
    }

    /**
     * Gets API uri query part.
     *
     * @return string
     */
    public function getQuery()
    {
        return "{$this->getName()}/posts?access_token={$this->getAccessToken()}&fields={$this->getFields()}";
    }

    /**
     * Gets joined request fields.
     *
     * @return string
     */
    public function getFields()
    {
        return join(',', $this->arguments['fields']);
    }

    /**
     * Gets joined request fields.
     *
     * @return string
     */
    protected function getAccessToken()
    {
        if ( ! (
            isset($this->arguments['keys']['app_id'])
            && isset($this->arguments['keys']['app_secret'])
        )) {
            throw new CredentialsException('You have to provide Application ID and Application Secret Key.');
        }

        return "{$this->arguments['keys']['app_id']}|{$this->arguments['keys']['app_secret']}";
    }
}
