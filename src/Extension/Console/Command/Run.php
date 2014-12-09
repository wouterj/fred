<?php

namespace WouterJ\Chef\Extension\Console\Command;

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
            ->addArgument('task', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The task to run')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // execute tasks
    }
}
