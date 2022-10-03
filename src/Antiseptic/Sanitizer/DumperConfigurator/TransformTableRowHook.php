<?php

namespace Mygento\Antiseptic\Sanitizer\DumperConfigurator;

use Faker\Generator as FakerGenerator;
use Mygento\Antiseptic\Config\ConfigProcessor;
use Mygento\Antiseptic\Dumper\DumperBuilder;
use Mygento\Antiseptic\Sanitizer\Faker\ChecksumGenerator;

class TransformTableRowHook implements DumperConfiguratorInterface
{
    /**
     * @var FakerGenerator
     */
    private $faker;

    public function __construct(
        FakerGenerator $faker
    ) {
        $this->faker = $faker;
    }

    public function configure(DumperBuilder $dumperBuilder, ConfigProcessor $configProcessor): void
    {
        $processedTables = $configProcessor->getProcessedTables();
        $dumperBuilder->setTransformTableRowHook($this->getCallback($processedTables, $configProcessor, $this->faker));
    }

    /**
     * @return callable
     */
    private function getCallback(array $processedTables, ConfigProcessor $configProcessor, FakerGenerator $faker)
    {
        return static function ($tableName, array $row) use ($processedTables, $configProcessor, $faker) {
            if (!in_array($tableName, $processedTables)) {
                return $row;
            }

            foreach ($configProcessor->getFieldsConfigByTableName($tableName) as $fieldName => $settings) {
                if (!isset($row[$fieldName], $settings[ConfigProcessor::FORMATTER_KEY])) {
                    continue;
                }

                $fieldChecksum = ChecksumGenerator::generate(
                    (string) $row[$fieldName],
                    (string) $settings[ConfigProcessor::FORMATTER_KEY]
                );

                $faker->seed($fieldChecksum);
                $row[$fieldName] = $faker->{$settings[ConfigProcessor::FORMATTER_KEY]};
            }

            return $row;
        };
    }
}
