<?php

namespace WouterJ\Fred;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class StepStack
{
    /** @var \Traversable */
    private $files;

    public function __construct(\Traversable $files)
    {
        $this->files = $files;
    }

    public function then(Step $step)
    {
        $this->files = $step->constructIterator($this->files);

        return $this;
    }

    public function dest($glob)
    {
        var_dump('Iterator chain ended with dest to '.$glob);

        foreach ($this->files as $file) {
            echo PHP_EOL, $file->info()->getRelativePathname();
            echo ': ', $file->content();
        }
    }
}
