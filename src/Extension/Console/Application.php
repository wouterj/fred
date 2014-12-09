<?php

namespace WouterJ\Chef\Extension\Console;

use Symfony\Component\Console\Application as BaseApplication;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Application extends BaseApplication
{
    const CHEF_VERSION = '1.0-dev';

    public function __construct()
    {
        parent::__construct('Chef', self::CHEF_VERSION);
    }

    public function find($name)
    {
        try {
            return parent::find($name);
        } catch (\InvalidArgumentException $e) {
            if (false !== strpos('ambiguous', $e->getMessage())) {
                throw $e;
            }

            return new Command\Run();
        }
    }
}
