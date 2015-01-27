<?php

namespace WouterJ\Fred\Extension;

use WouterJ\Fred\File;
use WouterJ\Fred\Iterator\MapIterator;
use WouterJ\Fred\Step;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Contents implements Step
{
    private $contents;

    public function __construct($contents)
    {
        $this->contents = $contents;
    }

    public function constructIterator(\Traversable $previous)
    {
        $contents = $this->contents;

        return new MapIterator($previous, function (File $item) use ($contents) {
            $item->setContent($contents);

            return $item;
        });
    }
}
