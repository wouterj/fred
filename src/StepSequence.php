<?php

/*
 * This file is part of Fred, a simple PHP task runner.
 *
 * (c) Wouter de Jong <wouter@wouterj.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WouterJ\Fred;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class StepSequence
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
