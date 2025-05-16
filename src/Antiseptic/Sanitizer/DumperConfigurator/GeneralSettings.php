<?php

namespace Mygento\Antiseptic\Sanitizer\DumperConfigurator;

use Mygento\Antiseptic\Config\ConfigProcessor;
use Mygento\Antiseptic\Dumper\DumperBuilder;

class GeneralSettings implements DumperConfiguratorInterface
{
    public function configure(DumperBuilder $dumperBuilder, ConfigProcessor $configProcessor): void
    {
        $dumperBuilder
            ->setDsn($configProcessor->getDsn())
            ->setUser($configProcessor->getUser())
            ->setPass($configProcessor->getPass())
            ->addDumpSettings($configProcessor->getDumpSettings())
            ->addPdoSettings($configProcessor->getPdoSettings())
            ->addTableWheres($configProcessor->getTableWheres())
            ->addTableLimits($configProcessor->getTableLimits());
    }
}
