<?php

namespace Tonik\Feeder\Post;

use JsonSerializable;
use Tonik\Feeder\Contracts\PostInterface;

abstract class Post implements PostInterface, JsonSerializable
{
    /**
     * The type of post.
     *
     * @var string
     */
    public $post_type;

    /**
     * Decorated object.
     *
     * @var object|array
     */
    public $object;

    /**
     * Construct post.
     *
     * @param object|array $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * Return post type name when converting to sting.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->post_type;
    }

    /**
     * Proxes property accessing.
     *
     * @param  string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        // While this post have defined method with
        // accessed name. Call it and return result.
        if (method_exists($this, $name)) {
            return $this->{$name}();
        }

        // Try to find accessed property on original
        // object. Return it's value if exist.
        if (property_exists($this->object, $name)) {
            if (is_array($this->object)) {
                return $this->object[$name];
            }

            return $this->object->{$name};
        }
    }
}
