<?php

namespace WouterJ\Fred\Extension;

use WouterJ\Fred\File;
use WouterJ\Fred\Iterator\MapIterator;
use WouterJ\Fred\Step;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class PhpSpec implements Step
{
    public function constructIterator(\Traversable $traversable)
    {
        return new MapIterator($traversable, function (File $file) {
            $file->setContent('passed');

            return $file;
        });
    }
}
