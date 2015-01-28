<?php

namespace WouterJ\Fred\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class TaskList extends Base
{
    public function configure()
    {
        $this->setName('task:list')
            ->setDescription('Lists all available tasks');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $fred = $this->createFred();
        if (false === $fred) {
            $this->outputFredFileDoesNotExists($output);

            return self::FRED_ERROR;
        }
        $tasks = iterator_to_array($fred->getTaskStack());

        if (count($tasks)) {
            $output->writeln(array(
                'Fred knows '.count($tasks).' task'.(1 === count($tasks) ? '' : 's').':',
                '',
            ));
        } else {
            $this->outputFredFileIsEmpty($output);

            return self::FRED_ERROR;
        }

        foreach ($tasks as $task) {
            $output->writeln('* '.$task->getSynopsis());
        }
    }
}
