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
                $dependencies = array();
            } elseif (is_array($dependencies)) {
                // ->task('default', ['minify', 'build'])
                $closure = function () { };
            }
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

    /**
     * @param \IteratorAggregate|\Traversable $files
     */
    public function load($files)
    {
        if ($files instanceof \IteratorAggregate) {
            $files = $files->getIterator();
        }

        $files = new Iterator\MapIterator($files, function ($file) {
            return new File($file);
        });

        return new StepStack($files);
    }
}
