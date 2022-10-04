<?php

namespace Mygento\Antiseptic\Sanitizer\DumperConfigurator;

use Mygento\Antiseptic\Config\ConfigProcessor;
use Mygento\Antiseptic\Dumper\DumperBuilder;

interface DumperConfiguratorInterface
{
    public function configure(DumperBuilder $dumperBuilder, ConfigProcessor $configProcessor): void;
}
