<?php

namespace WouterJ\Fred\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use WouterJ\Fred\Fred;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
abstract class Base extends Command
{
    const SUCCESS    = 0;
    const FRED_ERROR = 1;
    const TASK_ERROR = 2;

    /**
     * @return Fred
     */
    protected function createFred()
    {
        $fred = new Fred();

        $file = getcwd().DIRECTORY_SEPARATOR.'fred.php';

        if (!file_exists($file)) {
            return false;
        }

        ob_start();
        require_once $file;
        ob_end_clean(); // make sure files that are not parsed as PHP code aren't outputted in the console

        return $fred;
    }

    protected function outputFredFileIsEmpty(OutputInterface $output)
    {
        $output->writeln(array(
            'Bummer! Fred didn\'t learn anything yet.',
            '',
            'Edit the fred.php file and add some tasks in it, like:',
            '',
            '    $fred->task("fill_fred_file", function () use ($fred) {',
            '        // ...',
            '    });',
        ));
    }

    protected function outputFredFileDoesNotExists(OutputInterface $output)
    {
        $output->writeln('Fred can\'t do his work: He can\'t find the fred file (fred.php).');
    }
}
