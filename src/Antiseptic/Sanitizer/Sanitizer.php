<?php

namespace Mygento\Antiseptic\Sanitizer;

use Mygento\Antiseptic\Config\ConfigProcessor;
use Mygento\Antiseptic\Dumper\DumperBuilder;
use Mygento\Antiseptic\Dumper\DumperInterface;
use Mygento\Antiseptic\Sanitizer\DumperConfigurator\DumperConfiguratorComposite;
use Mygento\Antiseptic\Sanitizer\DumperConfigurator\DumperConfiguratorInterface;
use Mygento\Antiseptic\Sanitizer\DumperConfigurator\GeneralSettings;
use Mygento\Antiseptic\Sanitizer\DumperConfigurator\TransformTableRowHook;
use Mygento\Antiseptic\Sanitizer\Faker\FakerInitializer;
use Symfony\Component\Console\Output\OutputInterface;

class Sanitizer
{
    public function sanitize(string $configFile, string $dumpFile, OutputInterface $output)
    {
        $configProcessor = new ConfigProcessor($configFile);
        $dumperBuilder = new DumperBuilder();
        $dumperConfigurator = new DumperConfiguratorComposite($this->getDumperConfigurators());

        $dumper = $this->getDumper($dumperBuilder, $configProcessor, $dumperConfigurator);
        $dumper->start($dumpFile);
    }

    private function getDumper(
        DumperBuilder $dumperBuilder,
        ConfigProcessor $configProcessor,
        DumperConfiguratorInterface $dumperConfigurator
    ): DumperInterface {
        $dumperConfigurator->configure($dumperBuilder, $configProcessor);

        return $dumperBuilder->create();
    }

    private function getDumperConfigurators(): array
    {
        return [
            new GeneralSettings(),
            new TransformTableRowHook(FakerInitializer::initialize()),
        ];
    }
}
