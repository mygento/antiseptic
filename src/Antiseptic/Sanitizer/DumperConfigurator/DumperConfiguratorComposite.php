<?php

namespace Mygento\Antiseptic\Sanitizer\DumperConfigurator;

use Mygento\Antiseptic\Config\ConfigProcessor;
use Mygento\Antiseptic\Dumper\DumperBuilder;

class DumperConfiguratorComposite implements DumperConfiguratorInterface
{
    /**
     * @var DumperConfiguratorInterface[]
     */
    private $configurators;

    /**
     * @param DumperConfiguratorInterface[] $configurators
     */
    public function __construct(
        array $configurators = []
    ) {
        $this->configurators = $configurators;
    }

    public function configure(DumperBuilder $dumperBuilder, ConfigProcessor $configProcessor): void
    {
        foreach ($this->configurators as $configurator) {
            $configurator->configure($dumperBuilder, $configProcessor);
        }
    }
}
