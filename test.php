<?php

include_once 'vendor/autoload.php';
use Simtabi\Symlink;

$symlinkInit = new Symlink();
$obj = $symlinkInit->setBatchJobs([
        [
            'destination' => __DIR__.'/assets',
            'source'      => __DIR__.'/core/public/assets',
        ],
        /*[
            'destination' => __DIR__.'/misati',
            'source'      => __DIR__.'/core/app',
        ]*/
    ])

    // ->setSource( __DIR__.'/core/app')->setDestination(__DIR__.'/app')
    ->generate();