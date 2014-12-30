<?php

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
