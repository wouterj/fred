<?php

namespace WouterJ\Fred\Exception;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class TaskNotFoundException extends \InvalidArgumentException
{
    public function __construct($name)
    {
        parent::__construct(sprintf('No task with name "%s" can be found', $name));
    }
}