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
        if (STDOUT === $glob) {
            foreach ($this->files as $file) {
                fwrite(STDOUT, $file->content());
            }
        } elseif (is_dir($glob)) {
            /** @var File $file */
            foreach ($this->files as $file) {
                file_put_contents($glob.DIRECTORY_SEPARATOR.$file->info()->getFilename(), $file->content());
            }
        } elseif (1 === count($this->files)) {
            $file = current(iterator_to_array($this->files));

            file_put_contents(getcwd().DIRECTORY_SEPARATOR.$glob, $file->content());
        } else {
            throw new \InvalidArgumentException(sprintf('Unable to handle destination "%s".', $glob));
        }
    }
}
