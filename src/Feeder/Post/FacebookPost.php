<?php

namespace Tonik\Feeder\Post;

class FacebookPost extends Post
{
    /**
     * The type of post.
     *
     * @var string
     */
    public $post_type = 'facebook';

    /**
     * Gets post link.
     *
     * @return string
     */
    public function link()
    {
        return $this->object['permalink_url'];
    }

    /**
     * Gets post description.
     *
     * @return string
     */
    public function description()
    {
        if (isset($this->object['story'])) {
            return $this->object['story'];
        }
    }

    /**
     * Gets post content.
     *
     * @return string
     */
    public function content()
    {
        return $this->object['message'];
    }

    /**
     * Gets post creation time.
     *
     * @return string
     */
    public function created_at()
    {
        return $this->object['created_time'];
    }

    /**
     * Gets post thumbnail image.
     *
     * @return string
     */
    public function image()
    {
        return $this->object['full_picture'];
    }
}
