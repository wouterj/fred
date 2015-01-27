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
 * A simple helper to decorate iterators with other iterators.
 *
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

    /**
     * Add a step to the sequence.
     */
    public function then(Step $step)
    {
        $this->files = $step->constructIterator($this->files);

        return $this;
    }

    public function dist($glob)
    {
        trigger_error(__CLASS__.'::dist() is deprecated since 0.3, use '.__CLASS__.'::save() instead.', E_USER_DEPRECATED);

        return $this->save($glob);
    }

    /**
     * Save the result tree to $glob.
     *
     * @param string $glob STDOUT, a directory or a file
     */
    public function save($glob = null)
    {
        if (STDOUT === $glob) {
            foreach ($this->files as $file) {
                fwrite(STDOUT, $file->content());
            }
        } elseif (is_dir($glob)) {
            /** @var File $file */
            foreach ($this->files as $file) {
                file_put_contents($glob.DIRECTORY_SEPARATOR.$file->name(), $file->content());
            }
        } elseif (1 === count($this->files)) {
            $file = current(iterator_to_array($this->files));

            if (null === $glob) {
                $glob = $file->name();
            }

            file_put_contents(getcwd().DIRECTORY_SEPARATOR.$glob, $file->content());
        } else {
            throw new \InvalidArgumentException(sprintf('Unable to handle destination "%s".', $glob));
        }
    }
}
