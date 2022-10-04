<?php

namespace Mygento\Antiseptic\Sanitizer\DumperConfigurator;

use Faker\Generator as FakerGenerator;
use Mygento\Antiseptic\Config\ConfigProcessor;
use Mygento\Antiseptic\Dumper\DumperBuilder;
use Mygento\Antiseptic\Sanitizer\Faker\ChecksumGenerator;
use Mygento\Antiseptic\Sanitizer\Faker\UniqueValueProcessor;

class TransformTableRowHook implements DumperConfiguratorInterface
{
    /**
     * @var FakerGenerator
     */
    private $faker;

    /**
     * @var UniqueValueProcessor
     */
    private $uniqueValueProcessor;

    public function __construct(
        FakerGenerator $faker,
        UniqueValueProcessor $uniqueValueProcessor
    ) {
        $this->faker = $faker;
        $this->uniqueValueProcessor = $uniqueValueProcessor;
    }

    public function configure(DumperBuilder $dumperBuilder, ConfigProcessor $configProcessor): void
    {
        $processedTables = $configProcessor->getProcessedTables();
        $dumperBuilder->setTransformTableRowHook($this->getCallback(
            $processedTables,
            $configProcessor,
            $this->faker,
            $this->uniqueValueProcessor
        ));
    }

    /**
     * @return callable
     */
    private function getCallback(
        array $processedTables,
        ConfigProcessor $configProcessor,
        FakerGenerator $faker,
        UniqueValueProcessor $uniqueValueProcessor
    ) {
        return function ($tableName, array $row) use ($processedTables, $configProcessor, $faker, $uniqueValueProcessor) {
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

                if (isset($settings[ConfigProcessor::UNIQUE_KEY]) && $settings[ConfigProcessor::UNIQUE_KEY] === true) {
                    $row[$fieldName] = $uniqueValueProcessor->getUniqueValue((string) $row[$fieldName], $settings);

                    continue;
                }

                $faker->seed($fieldChecksum);
                $row[$fieldName] = $faker->{$settings[ConfigProcessor::FORMATTER_KEY]};
            }

            return $row;
        };
    }
}
