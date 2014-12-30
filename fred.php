<?php

use WouterJ\Fred\Extension as Ext;
use Symfony\Component\Finder\Finder;

$fred->task('test', function () use ($fred) {
    $fred->load(Finder::create()->files()->name('*Spec.php')->in(__DIR__.'/spec'))
        ->then(new Ext\PhpSpec())
        ->dest(STDOUT);
});

return $fred;
