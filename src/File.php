<?php

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
