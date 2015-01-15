Feature: File creation tasks
  In order to bootstrap a project
  As a developer
  I need to create files

  Scenario: Creating a blog post
    Given there is a file named "fred.php" with:
      """
      <?php

      use WouterJ\Fred\Extension\Contents;

      $fred->task('create_readme', function () use ($fred) {

          $fred->create('README.md')
            ->then(new Contents('Yes, you tried to read me!'))
            ->save();

      });
      """
    When I run "fred create_readme"
    Then "README.md" file should contain:
      """
      Yes, you tried to read me!
      """
