<?php

namespace Tonik\Feeder\Feed;

use Tonik\Feeder\Contracts\FeedInterface;

abstract class Feed implements FeedInterface
{
    /**
     * Decorates raw feed items with adapter.
     *
     * @param  array  $items
     * @param  \Tonik\Feeder\Contracts\PostInterface $decorator
     *
     * @return array
     */
    public function decorate(array $items, $decorator)
    {
        return array_map(function ($item) use ($decorator) {
            return new $decorator($item);
        }, $items);
    }
}
