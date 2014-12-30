<?php

namespace WouterJ\Fred;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
interface Step
{
    public function constructIterator(\Traversable $previous);
}
