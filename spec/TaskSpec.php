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

class TaskSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('publish', array('build'), function () { });
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('publish');
    }

    function it_has_dependencies()
    {
        $this->getDependencies()->shouldReturn(array('build'));
    }

    function it_has_a_task_function()
    {
        $this->getTask()->shouldReturnAnInstanceOf('Closure');
    }

    function it_requires_a_callable_as_task()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct', array('publish', array(), 'error!'));
    }
}
