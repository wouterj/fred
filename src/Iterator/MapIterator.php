<?php

namespace WouterJ\Fred\Iterator;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class MapIterator extends \IteratorIterator
{
    /** @var callable */
    private $callback;

    public function __construct(\Traversable $iterator, $callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException(sprintf('Callback should be callable, "%s" given.', gettype($callback)));
        }

        parent::__construct($iterator);

        $this->callback = $callback;
    }

    public function current()
    {
        return call_user_func($this->callback, parent::current());
    }
}
