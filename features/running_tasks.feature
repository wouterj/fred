Feature: Running tasks using CLI
  In order to execute the tasks
  As a developer
  I need an easy to use console tool

  Scenario: Running a normal task
    Given there is a file named "fred.php" with:
      """
      <?php

      use Symfony\Component\Finder\Finder;

      $fred->task('build', function () {
          file_put_contents('result.txt', 'Build has run');
      });
      """
    When I run "fred build"
    Then I should see:
      """
       +- Executed task "build"
      """
    And "result.txt" file should contain:
      """
      Build has run
      """

  Scenario: Running a task with output
    Given there is a file named "fred.php" with:
      """
      <?php

      $fred->task('build', function () {
          echo 'Inside build task!';
      });
      """
    When I run "fred build"
    Then I should see:
      """
       +- Executing task "build"
       |
       |    Inside build task!
       |
       \  Task "build" was executed successfully
      """

  Scenario: Running an undefined task
    Given there is a file named "fred.php" with:
      """
      <?php
      """
    When I run "fred build"
    Then I should see:
      """
      Oh no! Fred couldn't find the task "build" in the fred file (fred.php)
      """

  Scenario: Running a task that errors
    Given there is a file named "fred.php" with:
      """
      <?php

      $fred->task('build', function () {
          throw new \Exception('Ghnenene...');
      });
      """
    When I run "fred build"
    Then I should see:
      """
       +- Executing task "build"
       |
       |    [Exception]
       |    Ghnenene...
       |
       \  An error occurred while executing task "build"
      """
