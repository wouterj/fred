<?php

/*
 * This file is part of Fred, a simple PHP task runner.
 *
 * (c) Wouter de Jong <wouter@wouterj.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WouterJ\Fred\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WouterJ\Fred\Fred;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Run extends Base
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
        $fred = $this->createFred();

        return $this->executeTask($output, $taskName, $fred);
    }

    private function executeTask(OutputInterface $output, $taskName, Fred $fred)
    {
        $output->write(' +- Executing task "'.$taskName.'"');

        $failed = false;
        $taskOutput = '';
        try {
            $taskOutput .= $this->executeAndBufferOutput($taskName, $fred);
        } catch (\InvalidArgumentException $e) {
            $output->writeln('Oh no! Fred couldn\'t find the task "'.$taskName.'" in the fred file (fred.php)');

            return self::FRED_ERROR;
        } catch (\Exception $e) {
            $failed = true;

            $taskOutput .= ob_get_clean(); // an exception occurred before flushing the output buffer
            $taskOutput .= ($taskOutput ? "\n\n" : '').$this->formatException($e);
        }

        if ($taskOutput) {
            $this->printTaskOutput($output, $taskOutput, $failed);

            if (!$failed) {
                $this->printResult($output, ' \  Task "'.$taskName.'" was executed successfully', false);
            } else {
                $this->printResult($output, ' \  An error occurred while executing task "'.$taskName.'"', true);

                return self::TASK_ERROR;
            }
        } else {
            $this->printResult($output, "\r +- Executed task \"".$taskName.'" ', true);
        }

        return self::SUCCESS;
    }

    private function printResult(OutputInterface $output, $message, $failed)
    {
        $output->writeln($this->colorize($message, $failed));
    }

    private function printTaskOutput(OutputInterface $output, $taskOutput, $failed)
    {
        $taskOutputLines = preg_split('/\R/', $taskOutput);

        $output->writeln(array(
            '',
            $this->colorize(' |', $failed),
        ));

        $colorize = array($this, 'colorize');
        $prefix = function ($line) use ($failed, $colorize) {
            return call_user_func($colorize, '' === trim($line) ? ' |' : ' |    ', $failed).$line;
        };

        $output->writeln(array_map($prefix, $taskOutputLines));

        $output->writeln($this->colorize(' |', $failed));
    }

    private function executeAndBufferOutput($taskName, Fred $fred)
    {
        ob_start();
        $fred->execute($taskName);
        $taskOutput = ob_get_clean();

        return $taskOutput;
    }

    private function colorize($string, $failed = false)
    {
        $color = $failed ? 'red' : 'green';

        return sprintf('<fg=%1$s>%2$s</fg=%1$s>', $color, $string);
    }

    private function formatException(\Exception $e)
    {
        return '['.get_class($e)."]\n".$e->getMessage();
    }
}
