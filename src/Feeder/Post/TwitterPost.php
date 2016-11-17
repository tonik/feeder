<?php

namespace Tonik\Feeder\Post;

class TwitterPost extends Post
{
    /**
     * The type of post.
     *
     * @var string
     */
    public $post_type = 'twitter';

    /**
     * Gets post link.
     *
     * @return string
     */
    public function link()
    {
        return "https://twitter.com/{$this->object->user->name}/status/{$this->object->id}";
    }

    /**
     * Gets post thumbnail image.
     *
     * @return string
     */
    public function image()
    {
        if (isset($this->object->entities->media) && ! empty($this->object->entities->media)) {
            return $this->object->entities->media[0]->media_url;
        }
    }

    /**
     * Gets post content.
     *
     * @return string
     */
    public function content()
    {
        return preg_replace(
            ['/(?<mention>@[^ ]*)/', '/(?<tag>#[^ ]*)/'],
            ["<span class='mention'>$1</span>", "<span class='tag'>$1</span>"],
            $this->object->text
        );
    }

    /**
     * Gets post creation time.
     *
     * @return string
     */
    public function created_at()
    {
        return $this->object->created_at;
    }
}
