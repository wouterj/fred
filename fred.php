<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Finder\Finder;
use WouterJ\Fred\File;

class Phpspec implements \WouterJ\Fred\Step
{
    public function constructIterator(\Traversable $traversable)
    {
        return new \WouterJ\Fred\Iterator\MapIterator($traversable, function (File $file) {
            $file->setContent('passed');

            return $file;
        });
    }
}

$fred = new \WouterJ\Fred\Fred();

$fred->task('test', function () use ($fred) {
    $fred->load(Finder::create()->files()->name('*Spec.php')->in(__DIR__.'/spec'))
        ->then(new Phpspec())
        ->dest(STDOUT)
    ;
});

return $fred;
