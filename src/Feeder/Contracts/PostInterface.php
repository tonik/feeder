<?php

namespace Tonik\Feeder\Contracts;

interface PostInterface
{
    /**
     * Gets create time of post.
     *
     * @return string
     */
    public function created_at();
}
