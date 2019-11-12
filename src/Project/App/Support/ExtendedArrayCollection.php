<?php


namespace App\Project\App\Support;

use Doctrine\Common\Collections\ArrayCollection;
use Tightenco\Collect\Support\Arr;
use Closure;

class ExtendedArrayCollection extends ArrayCollection
{
    /**
     * Reduce the collection into a single value.
     *
     * @param \Closure $func
     * @param null $initialValue
     * @return mixed
     */
    public function reduce(Closure $func, $initialValue = null)
    {
        return array_reduce($this->toArray(), $func, $initialValue);
    }


    /**
     * Get the first item from the collection passing the given truth test.
     *
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    public function firstWhen(callable $callback = null, $default = null)
    {
        return Arr::first($this->toArray(), $callback, $default);
    }


    /**
     * Create a new collection instance if the value isn't one already.
     *
     * @param  mixed  $items
     * @return static
     */
    public static function make($items = [])
    {
        return new static($items);
    }

}
