Feature: Argument Parsing
  To make tasks more dynamic
  As a developer
  I need to have access to console arguments

  Scenario: Listing tasks with arguments
    Given there is a file named "fred.php" with:
      """
      <?php

      $fred->task('create_post', function ($title) {
      });
      
      $fred->task('create_license', function ($project, $year = 2015) {
      });
      """
    When I run "fred --list"
    Then I should see:
      """
      Fred knows 2 tasks:

      * create_post title=...
      * create_license project=... [year=2015]
      """

  Scenario: Running task with a required argument
    Given there is a file named "fred.php" with:
      """
      <?php

      $fred->task('create_post', function ($title) {
          file_put_contents(strtolower(trim(preg_replace('/\W+/', '-', $title), '-')).'.md', '# '.$title);
      });
      """
    When I run "fred create_post title='Hello World'"
    Then "hello-world.md" file should contain:
      """
      # Hello World
      """
    
  Scenario: Running task without passing a required argument
    Given there is a file named "fred.php" with:
      """
      <?php
      
      $fred->task('create_post', function ($title) {
      });
      """
    When I run "fred create_post"
    Then I should see:
      """
       +- Executing task "create_post"
       |
       |    [WouterJ\Fred\Exception\MissingArgumentsException]
       |    Fred is missing some required arguments for task "create_post":
       |
       |      create_post title=...
       |
       \  An error occurred while executing task "create_post"
      """

  Scenario: Running a task with an optional argument without value
    Given there is a file named "fred.php" with:
      """
      <?php

      $fred->task('create_readme', function ($projectName = 'PLACEHOLDER') {
          file_put_contents('README.md', '# '.$projectName);
      });
      """
    When I run "fred create_readme"
    Then "README.md" file should contain:
      """
      # PLACEHOLDER
      """

  Scenario: Running a task with an optional argument with value
    Given there is a file named "fred.php" with:
      """
      <?php

      $fred->task('create_readme', function ($projectName = 'PLACEHOLDER') {
          file_put_contents('README.md', '# '.$projectName);
      });
      """
    When I run "fred create_readme projectName=Freddy"
    Then "README.md" file should contain:
      """
      # Freddy
      """
