<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->notPath('tests/');

$config = new PhpCsFixer\Config();
$config->setFinder($finder);

return $config;
