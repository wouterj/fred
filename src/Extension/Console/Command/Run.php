<?php

namespace WouterJ\Fred\Extension\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WouterJ\Fred\Fred;

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
        $fred = $this->configureFred();

        $fred->execute($taskName);
    }

    /**
     * @return Fred
     */
    public function configureFred()
    {
        $fred = new Fred();

        require_once getcwd().DIRECTORY_SEPARATOR.'fred.php';

        return $fred;
    }
}
