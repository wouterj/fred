<?php

/*
 * This file is part of Fred, a simple PHP task runner.
 *
 * (c) Wouter de Jong <wouter@wouterj.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WouterJ\Fred\Console;

use Symfony\Component\Console\Application as BaseApplication;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Application extends BaseApplication
{
    const FRED_VERSION = '0.1.0';

    public function __construct()
    {
        parent::__construct('Fred', self::FRED_VERSION);
    }

    public function find($name)
    {
        try {
            return parent::find($name);
        } catch (\InvalidArgumentException $e) {
            if (false !== strpos('ambiguous', $e->getMessage())) {
                throw $e;
            }

            $runCommand = new Command\Run();
            $runCommand->setApplication($this);

            return $runCommand;
        }
    }
}
