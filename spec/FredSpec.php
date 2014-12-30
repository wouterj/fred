<?php

namespace spec\WouterJ\Fred;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WouterJ\Fred\Task;
use WouterJ\Fred\TaskStack;

class FredSpec extends ObjectBehavior
{
    function let(TaskStack $stack)
    {
        $this->beConstructedWith($stack);
    }

    function it_accepts_simple_tasks(TaskStack $stack)
    {
        $stack->push(Argument::that(function ($task) {
            return $task->getName() === 'minify'
                && $task->getDependencies() === array();
        }));

        $this->task('minify', function () { });
    }

    function it_accepts_tasks_with_dependencies(TaskStack $stack)
    {
        $stack->push(Argument::that(function ($task) {
            return $task->getName() === 'publish'
                && $task->getDependencies() === array('build');
        }));

        $this->task('publish', array('build'), function () { });
    }

    function it_accepts_nested_tasks(TaskStack $stack)
    {
        $stack->push(Argument::that(function ($task) {
            return $task->getName() === 'build'
            && $task->getDependencies() === array('test', 'minify', 'cleanup');
        }));

        $this->task('build', array('test', 'minify', 'cleanup'));
    }

    function it_rejects_everything_else()
    {
        $this->shouldThrow('InvalidArgumentException')->duringTask('build');
        $this->shouldThrow('InvalidArgumentException')->duringTask('build', function () { }, array());
        $this->shouldThrow('InvalidArgumentException')->duringTask(function () { });
    }
}
