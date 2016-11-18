<?php

namespace Tonik\Feeder\Feed;

use Tonik\Feeder\Contracts\FeedInterface;

abstract class Feed implements FeedInterface
{
    /**
     * API version.
     *
     * @var string
     */
    const API_VERSION = null;

    /**
     * Decorates raw feed items with adapter.
     *
     * @param  array  $items
     * @param  string $decorator
     *
     * @return array
     */
    public function decoratePosts(array $items, $decorator)
    {
        return array_map(function ($item) use ($decorator) {
            return new $decorator($item);
        }, $items);
    }

    /**
     * Gets API uri host part.
     *
     * @return string
     */
    public function getUri()
    {
        return static::API_HOST;
    }

    /**
     * Gets API uri version part.
     *
     * @return string
     */
    public function getVersion()
    {
        return static::API_VERSION;
    }

    /**
     * Gets full API url.
     *
     * @return string
     */
    public function getPath()
    {
        if (null === static::API_VERSION) {
            return "{$this->getUri()}/{$this->getQuery()}";
        }

        return "{$this->getUri()}/{$this->getVersion()}/{$this->getQuery()}";
    }

    /**
     * Gets feed profile name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->arguments['name'];
    }
}
