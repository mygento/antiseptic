<?php

$finder = PhpCsFixer\Finder::create()
    ->in('.')
    ->ignoreVCSIgnored(true);

$config = new \Mygento\Symfony\Config\Symfony();
$config->setFinder($finder);
return $config;
