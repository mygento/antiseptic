<?php
$header = <<<EOF
@author Mygento Team
@copyright 2024 Mygento (https://www.mygento.com)
@package Mygento_Antiseptic
EOF;

$finder = PhpCsFixer\Finder::create()
    ->in('.')
    ->ignoreVCSIgnored(true);

$config = new \Mygento\CS\Config\Module($header);
$config->setFinder($finder);
return $config;
