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

use WouterJ\Fred\Exception\TaskNotFoundException;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class TaskStack implements \IteratorAggregate
{
    /** @var Task[] */
    private $tasks = array();

    /**
     * @return TaskStack
     */
    public function getStackForTask($name)
    {
        if (!$this->has($name)) {
            throw new TaskNotFoundException($name);
        }

        $stack = new TaskStack();
        $task = $this->tasks[$name];

        foreach ($task->getDependencies() as $dep) {
            $stack->merge($this->getStackForTask($dep), true);
        }

        $stack->push($task);

        return $stack;
    }

    public function push(Task $task)
    {
        if ($this->has($name = $task->getName())) {
            throw new \InvalidArgumentException(sprintf('A task with name "%s" is already defined.', $name));
        }

        $this->tasks[$name] = $task;
    }

    public function merge(TaskStack $stack, $skipIfExists = false)
    {
        foreach ($stack as $task) {
            try {
                $this->push($task);
            } catch (\InvalidArgumentException $e) {
                if (!$skipIfExists) {
                    throw $e;
                }
            }
        }
    }

    public function has($name)
    {
        return isset($this->tasks[$name]);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->tasks);
    }
}
