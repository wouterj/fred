<?php

namespace WouterJ\Fred;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class VirtualFile extends File
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }

    public function info()
    {
        throw new \LogicException('A virtual file does not have file info');
    }
}
