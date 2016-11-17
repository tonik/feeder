<?php

namespace Tonik\Feeder\Post;

class InstagramPost extends Post
{
    /**
     * The type of post.
     *
     * @var string
     */
    public $post_type = 'instagram';

    /**
     * Gets post link.
     *
     * @return string
     */
    public function link()
    {
        return $this->object['link'];
    }

    /**
     * Gets post thumbnail image.
     *
     * @return string
     */
    public function image()
    {
        return $this->object['images']['low_resolution']['url'];
    }

    /**
     * Gets post content.
     *
     * @return string
     */
    public function content()
    {
        return $this->object['caption']['text'];
    }

    /**
     * Gets post creation time.
     *
     * @return string
     */
    public function created_at()
    {
        return date('c', $this->object['created_time']);
    }
}
