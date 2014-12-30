<?php

namespace WouterJ\Fred;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class TaskStack implements \IteratorAggregate
{
    /** @var Task[] */
    private $tasks = array();

    public function getStackForTask($name)
    {
        if (!$this->has($name)) {
            throw new \InvalidArgumentException(sprintf('No task with name "%s" found, did you mean %s.', $name, implode(', ', array_keys($this->tasks))));
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
