Feature: Importing tasks
  In order to keep tasks ordered
  As a developer
  I need to be able to split tasks in multiple files

  Scenario: Using PHP functions
    Given there is a file named "fred_dev.php" with:
      """
      <?php

      $fred->task('test', function () {
      });
      """
    And there is a file named "fred.php" with:
      """
      <?php

      require_once __DIR__.'/fred_dev.php';

      $fred->task('release', function () {
      });
      """
    When I run "fred --list"
    Then I should see:
      """
      * test
      * release
      """
