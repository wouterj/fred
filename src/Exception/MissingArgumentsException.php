<?php

namespace WouterJ\Fred\Exception;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class MissingArgumentsException extends \InvalidArgumentException
{
    public function __construct($taskName, $taskSynopsis)
    {
        parent::__construct(sprintf(
            "Fred is missing some required arguments for task \"%s\":\n\n  %s",
            $taskName,
            $taskSynopsis
        ));
    }
}
