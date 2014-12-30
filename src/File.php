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

use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class File
{
    /** @var SplFileInfo */
    private $info;
    private $content;

    public function __construct(SplFileInfo $info)
    {
        $this->info = $info;
        $this->content = $info->getContents();
    }

    public function info()
    {
        return $this->info;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function content()
    {
        return $this->content;
    }
}
