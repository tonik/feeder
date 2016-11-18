<?php

namespace Tonik\Feeder\Feed;

use Tonik\Feeder\Contracts\FeedInterface;

class SocialFeed implements FeedInterface
{
    /**
     * Collection of items from configured feeds.
     *
     * @var array
     */
    public $items = [];

    /**
     * Collection of social feeds.
     *
     * @var array
     */
    protected $feeds;

    /**
     * List of requested fields.
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * Construct feed.
     *
     * @param array $feeds
     * @param array $arguments
     */
    public function __construct(array $feeds, $argument = [])
    {
        $this->feeds = $feeds;
        $this->argument = array_merge($this->arguments, $argument);

        $this->fetch();
    }

    /**
     * Fetch items from configured feeds.
     *
     * @return array
     */
    public function fetch()
    {
        foreach ($this->feeds as $feed) {
            $this->mergeItems($feed->getItems());
        }

        return $this->sortItems();
    }

    /**
     * Gets the value of items.
     *
     * @return mixed
     */
    public function getItems($limit = 5)
    {
        return array_slice($this->items, 0, $limit);
    }

    /**
     * Sets the value of items.
     *
     * @param mixed $items the items
     *
     * @return self
     */
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Merges the value of items.
     *
     * @param mixed $items the items
     *
     * @return self
     */
    public function mergeItems(array $items)
    {
        $this->items = array_merge($this->items, $items);

        return $this;
    }

    /**
     * Sorts the items by date.
     *
     * @return void
     */
    public function sortItems()
    {
        return usort($this->items, function ($a, $b) {
            $ad = strtotime($a->created_at);
            $bd = strtotime($b->created_at);

            return ($bd - $ad);
        });
    }
}
