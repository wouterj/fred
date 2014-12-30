<?php

namespace WouterJ\Fred\Extension\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Run extends Command
{
    public function configure()
    {
        $this->setName('run')
            ->setDescription('Executes the task')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $taskName = $input->getArgument('command');

        $chef = require_once getcwd().'/fred.php';

        $chef->execute($taskName);
    }
}
