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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WouterJ\Fred\Fred;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Application extends BaseApplication
{
    const FRED_VERSION = '0.2-dev';

    private $output;

    public function __construct()
    {
        parent::__construct('Fred', self::FRED_VERSION);
    }

    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        return parent::doRun($input, $output);
    }


    public function find($name)
    {
        if ('list' === $name) {
            $command = new Command\TaskList();
            $command->setApplication($this);

            return $command;
        }

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
