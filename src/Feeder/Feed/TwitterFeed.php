<?php

namespace Tonik\Feeder\Feed;

use GuzzleHttp\Client;
use Tonik\Feeder\Contracts\FetchableInterface;
use Tonik\Feeder\Feed\Exceptions\CredentialsException;
use Tonik\Feeder\Feed\Exceptions\NotFetchedException;
use Tonik\Feeder\Post\TwitterPost;

class TwitterFeed extends Feed implements FetchableInterface
{
    /**
     * API version.
     *
     * @var string
     */
    const API_VERSION = '1.1';

    /**
     * API host url.
     *
     * @var string
     */
    const API_HOST = 'https://api.twitter.com';

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
        $response = $this->client->request('GET', $this->getPath(), [
            'headers' => [
                'Authorization' => "Bearer {$this->getAccessToken()}",
            ],
        ]);

        if (200 === $response->getStatusCode()) {
            $posts = json_decode($response->getBody()->getContents());

            return $this->decoratePosts($posts, TwitterPost::class);
        }

        throw new NotFetchedException('Could not fetch items from Twitter feed.');
    }

    /**
     * Gets access token for API calls.
     *
     * @return string
     */
    public function getAccessToken()
    {
        $response = $this->client->request('POST', "{$this->getUri()}/oauth2/token", [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
                'Authorization' => "Basic {$this->getBearerTokenCredentials()}",
            ],
            'body' => 'grant_type=client_credentials',
        ]);

        $data = json_decode($response->getBody()->getContents());

        return $data->access_token;
    }

    /**
     * Gets API query part.
     *
     * @return string
     */
    public function getQuery()
    {
        return "statuses/user_timeline.json?screen_name={$this->getName()}";
    }

    /**
     * Gets encoded for url customer key.
     *
     * @return string
     */
    protected function getRawCustomerKey()
    {
        return rawurlencode($this->arguments['keys']['customer_key']);
    }

    /**
     * Gets encoded for url customer secret.
     *
     * @return string
     */
    protected function getRawCustomerSecret()
    {
        return rawurlencode($this->arguments['keys']['customer_secret']);
    }

    /**
     * Gets combined and encoded bearer token.
     *
     * @return string
     */
    protected function getBearerTokenCredentials()
    {
        if ( ! (
            isset($this->arguments['keys']['customer_key'])
            && isset($this->arguments['keys']['customer_secret'])
        )) {
            throw new CredentialsException('You have to provide Customer Key and Customer Secret.');
        }

        return base64_encode("{$this->getRawCustomerKey()}:{$this->getRawCustomerSecret()}");
    }
}
