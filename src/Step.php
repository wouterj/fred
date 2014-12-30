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
interface Step
{
    public function constructIterator(\Traversable $previous);
}
