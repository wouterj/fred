<?php

/*
 * This file is part of Fred, a simple PHP task runner.
 *
 * (c) Wouter de Jong <wouter@wouterj.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\WouterJ\Fred;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WouterJ\Fred\Task;
use WouterJ\Fred\TaskStack;

class TaskStackSpec extends ObjectBehavior
{
    function let(Task $task1, Task $task2, Task $task3)
    {
        $task1->getName()->willReturn('publish');
        $task1->getDependencies()->willReturn(array('build'));

        $this->push($task1);

        $task2->getName()->willReturn('build');
        $task2->getDependencies()->willReturn(array());

        $this->push($task2);

        $task3->getName()->willReturn('minify');
        $task3->getDependencies()->willReturn(array());

        $this->push($task3);
    }

    function it_provides_task_stacks(Task $task1, Task $task2)
    {
        $stack = new TaskStack();
        $stack->push($task1->getWrappedObject());
        $stack->push($task2->getWrappedObject());

        $this->getStackForTask('publish')->shouldBeLike($stack);
    }

    function it_can_handle_nested_dependencies(Task $task1, Task $task2, Task $task3)
    {
        $task2->getDependencies()->willReturn(array('minify'));

        $stack = new TaskStack();
        $stack->push($task3->getWrappedObject());
        $stack->push($task2->getWrappedObject());
        $stack->push($task1->getWrappedObject());

        $this->getStackForTask('publish')->shouldBeLike($stack);
    }

    function it_skips_duplicated_tasks(Task $task1, Task $task2, Task $task3)
    {
        $task1->getDependencies()->willReturn(array('minify', 'build'));
        $task2->getDependencies()->willReturn(array('minify'));

        $stack = new TaskStack();
        $stack->push($task3->getWrappedObject());
        $stack->push($task2->getWrappedObject());
        $stack->push($task1->getWrappedObject());

        $this->getStackForTask('publish')->shouldBeLike($stack);
    }

    function it_merges_stacks(TaskStack $stack, Task $task4, Task $task5)
    {
        $task4->getDependencies()->willReturn(array());
        $task5->getDependencies()->willReturn(array());
        $task4->getName()->willReturn('task4');
        $task5->getName()->willReturn('task5');

        $stack->getIterator()->willReturn(new \ArrayIterator(array($task4->getWrappedObject(), $task5->getWrappedObject())));

        $this->merge($stack);

        $this->has('task4')->shouldReturn(true);
        $this->has('task5')->shouldReturn(true);
    }

    function it_fails_when_adding_a_duplicate_task(Task $task6)
    {
        $task6->getName()->willReturn('minify');

        $this->shouldThrow('InvalidArgumentException')->duringPush($task6);
    }

    function it_fails_when_retrieving_undefined_task()
    {
        $this->shouldThrow('InvalidArgumentException')->duringGetStackForTask('undefined');
    }
}
