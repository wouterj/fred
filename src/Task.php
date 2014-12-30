<?php

/*
 * This file is part of Fred, a simple PHP task runner.
 *
 * (c) Wouter de Jong <wouter@wouterj.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WouterJ\Fred;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Task
{
    /** @var string */
    private $name;
    private $dependencies = array();
    /** @var callable */
    private $task;

    public function __construct($name, array $dependencies, $task)
    {
        if (!is_callable($task)) {
            throw new \InvalidArgumentException(sprintf('Expected a valid callable, got "%s".', is_object($task) ? get_class($task) : gettype($task)));
        }
        $this->name = $name;
        $this->dependencies = $dependencies;
        $this->task = $task;
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getTask()
    {
        return $this->task;
    }
}
