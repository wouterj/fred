<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Finder\Finder;

$fred = new \WouterJ\Fred\Fred();

$fred->task('test', function () use ($fred) {
    $fred->src(Finder::create()->files()->name('*Spec.php')->in(__DIR__.'/spec'))
        ->pipe(phpspec())
        ->dest(STDOUT)
    ;
});

return $fred;
