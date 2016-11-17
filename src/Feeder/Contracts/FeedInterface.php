<?php

namespace Tonik\Feeder\Contracts;

interface FeedInterface
{
    /**
     * Gets collection of feed items.
     *
     * @param  integer $limit
     *
     * @return array
     */
    public function getItems($limit);
}
