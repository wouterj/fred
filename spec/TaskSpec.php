<?php

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
