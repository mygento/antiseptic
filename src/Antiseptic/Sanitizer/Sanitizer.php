<?php

namespace Mygento\Antiseptic\Sanitizer;

use Faker\Generator;
use Mygento\Antiseptic\Config\ConfigProcessor;
use Mygento\Antiseptic\Dumper\DumperBuilder;
use Mygento\Antiseptic\Dumper\DumperInterface;
use Mygento\Antiseptic\Sanitizer\DumperConfigurator\DumperConfiguratorComposite;
use Mygento\Antiseptic\Sanitizer\DumperConfigurator\DumperConfiguratorInterface;
use Mygento\Antiseptic\Sanitizer\DumperConfigurator\GeneralSettings;
use Mygento\Antiseptic\Sanitizer\DumperConfigurator\TransformTableRowHook;
use Mygento\Antiseptic\Sanitizer\Faker\FakerInitializer;
use Mygento\Antiseptic\Sanitizer\Faker\UniqueValueProcessor;

class Sanitizer
{
    public function sanitize(string $configFile, string $dumpFile = ''): void
    {
        $configProcessor = new ConfigProcessor($configFile);
        $faker = FakerInitializer::initialize($configProcessor->getLocale());
        $dumperBuilder = new DumperBuilder();
        $dumperConfigurator = new DumperConfiguratorComposite($this->getDumperConfigurators($faker));

        $dumper = $this->getDumper($dumperBuilder, $configProcessor, $dumperConfigurator);
        $dumper->start($dumpFile);
    }

    private function getDumper(
        DumperBuilder $dumperBuilder,
        ConfigProcessor $configProcessor,
        DumperConfiguratorInterface $dumperConfigurator,
    ): DumperInterface {
        $dumperConfigurator->configure($dumperBuilder, $configProcessor);

        return $dumperBuilder->create();
    }

    /**
     * @return DumperConfiguratorInterface[]
     */
    private function getDumperConfigurators(Generator $faker): array
    {
        return [
            new GeneralSettings(),
            new TransformTableRowHook($faker, new UniqueValueProcessor($faker)),
        ];
    }
}
