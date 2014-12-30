<?php

/*
 * This file is part of Fred, a simple PHP task runner.
 *
 * (c) Wouter de Jong <wouter@wouterj.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
