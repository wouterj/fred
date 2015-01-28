<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\Process\Process;

class FeatureContext implements Context, SnippetAcceptingContext
{
    /** @var null|Process */
    private $process;

    /**
     * @BeforeScenario
     */
    public function setUpTestEnv()
    {
        $path = sys_get_temp_dir().'/'.uniqid('fred-');

        mkdir($path, 0777, true);

        chdir($path);
    }

    /**
     * @Given there is a file named :name with:
     */
    public function createFile($name, PystringNode $contents)
    {
        file_put_contents($name, $contents->getRaw());
    }

    /**
     * @Given there is no file named :name
     */
    public function unsureFileMissing($name)
    {
        if (file_exists($name)) {
            unlink($name);
        }
    }

    /**
     * @Given /^I run "fred(?P<options>[^"]+)"$/
     */
    public function runFred($options)
    {
        $this->process = new Process('php "'.__DIR__.'/../../bin/fred" --no-ansi '.str_replace('\'', '"', $options));
        $this->process->run();
    }

    /**
     * @Then I should see:
     */
    public function assertOutput(PystringNode $output)
    {
        PHPUnit_Framework_Assert::assertContains(
            $this->normalizeString($output->getRaw()),
            $this->normalizeString($this->process->getOutput())
        );
    }

    /**
     * @Then :name file should contain:
     */
    public function assertFileContents($name, PyStringNode $contents)
    {
        PHPUnit_Framework_Assert::assertFileExists($name);

        PHPUnit_Framework_Assert::assertContains($contents->getRaw(), file_get_contents($name));
    }

    protected function normalizeString($string)
    {
        return preg_replace('/\R/', "\n", $string);
    }
}
