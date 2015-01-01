Feature: The Fred File
  In order to define tasks
  As a developer
  I need to have a Fred file

  Scenario: Fred file exists
    Given there is a file named "fred.php" with:
      """
      <?php

      $fred->task('some_task', function () {
        // ...
      });

      $fred->task('other_task', function () {
        // ...
      });
      """
    When I run "fred --list"
    Then I should see:
      """
      Fred knows 2 tasks:

      * some_task
      * other_task

      """

  Scenario: Fred file is empty
    Given there is a file named "fred.php" with:
      """
      <?php
      """
    When I run "fred --list"
    Then I should see:
      """
      Bummer! Fred didn't learn anything yet.

      Edit the fred.php file and add some tasks in it, like:

          $fred->task("fill_fred_file", function () use ($fred) {
              // ...
          });
      """

  Scenario: No fred file found
    Given there is no file named "fred.php"
    When I run "fred --list"
    Then I should see:
      """
      Fred can't do his work: He can't find the fred file (fred.php).
      """
