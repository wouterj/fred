# Fred

Welcome to Fred. Fred will execute tasks that you have described in a fred file.

 > Fred is not a grown up man at the moment. The steps used in this docs are not
 > yet implemented. Do you help me teach him how to do developer tasks?

[![Build Status](https://travis-ci.org/WouterJ/fred.svg?branch=master)](https://travis-ci.org/WouterJ/fred)

## Why should I use Fred?

* You don't have to spent time installing NodeJS, NPM on your server just to run tasks;
* You can work with a syntax you're familiar with;
* Fred's codebase is very small (just 9 classes) and as flexible as task runners can be.

## Installation

The best way to install Fred is using [Composer](http://getcomposer.og/):

```bash
$ composer global require wouterj/fred:0.*
```

If you set-up composer's global binary directory correctly, this will give you a new command:
`fred`

## Usage

You start by creating a `fred.php` file (the fred file). In this file, you specify the
tasks. You do this by calling the `task()` method of the `$fred` variable that's available
in the file:

```php
$fred->task('build', function () use ($fred) {
    // ... specify the tasks
});
```

All tasks begin by opening a file or multiple files and passing a Traversable of these files
to `load()`. The best way to do this is by using the
[Symfony Finder Component](http://symfony.com/doc/current/components/finder.html):

```php
use Symfony\Component\Finder\Finder;

$fred->task('build', function () use ($fred) {
    $fred->load(Finder::create()->files()->name('*.js')->in('/web/assets/raw'));
});
```

You've now opened a Fred step sequence for all files with a `.js` extension in `/web/assets/raw`.

Now you can assign as many steps to this sequence as you want:

```php
use Symfony\Component\Finder\Finder;
use WouterJ\Fred\Extension as Ext;

$fred->task('build', function () use ($fred) {
    $fred->load(Finder::create()->files()->name('*.js')->in('/web/assets/raw'))
        ->then(new Ext\JsHint())   // Lint the JS code using JsHint...
        ->then(new Ext\Uglify())   // ...minify the JS files using UglifyJS...
        ->then(new Ext\Compact())  // ...and combine all JS files into one file
    ;
});
```

At last, you have to output the generated code somewhere. This is done with the `dist()`
function:

```php
$fred->load(Finder::create()->files()->name('*.js')->in('/web/assets/raw'))
    ->then(new Ext\JsHint())
    ->then(new Ext\Uglify())
    ->then(new Ext\Compact())
    ->dist('/web/assets/script.min.js')
;
```

Now, the generated code is dumped in the `/web/assets/script.min.js` file.

You can run this task by using `fred build` (where `build` is the name of the task).

## License

The project is released under the BSD license. See the LICENSE file included in this package for
more information.

## Roadmap

Of course, all kind of changes are welcome (as long as it doesn't make the Fred more
complex), but Fred should have learn the following things before reaching a stable version:

* Have more tests (that actually test the console app)
* Have a complete documentation
* Have more extensions and steps
