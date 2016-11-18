<?php

namespace Tonik\Feeder\Contracts;

interface FetchableInterface
{
    /**
     * Gets query part of API url.
     *
     * @return string
     */
    public function getQuery();
}
