<?php

namespace WouterJ\Fred;

use Symfony\Component\Finder\Finder;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Fred
{
    /** @var TaskStack */
    private $taskStack;

    public function __construct(TaskStack $taskStack = null)
    {
        if (null === $taskStack) {
            $taskStack = new TaskStack();
        }

        $this->taskStack = $taskStack;
    }

    public function task($name, $dependencies = null, $closure = null)
    {
        if (null === $closure) {
            if (is_callable($dependencies)) {
                // ->task('default', function () { ... });
                $closure = $dependencies;
            } elseif (is_array($dependencies)) {
                // ->task('default', ['minify', 'build'])
                $closure = function () { };
            }
            $dependencies = array();
        } elseif (is_array($dependencies) && is_callable($closure)) {
            // ->task('default', ['minify'], function () { ... });
            // do nothing, it's valid now
        } else {
            throw new \InvalidArgumentException(sprintf(
                "Invalid argument given to Chef#task(). It accepts one of:\n%s",
                implode("* \n", array(
                    'task(string name, callable task)',
                    'task(string name, array taskNames)',
                    'task(string name, array dependencies, callable task)',
                ))
            ));
        }

        $this->taskStack->push(new Task($name, (array) $dependencies, $closure));
    }

    public function execute($name)
    {
        $stack = $this->taskStack->getStackForTask($name);

        foreach ($stack as $task) {
            call_user_func($task->getTask());
        }
    }

    public function src(Finder $files)
    {

    }

    public function dest($outPath)
    {
    }
}
