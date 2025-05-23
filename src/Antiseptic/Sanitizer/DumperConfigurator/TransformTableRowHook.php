<?php

namespace Mygento\Antiseptic\Sanitizer\DumperConfigurator;

use Faker\Generator as FakerGenerator;
use Mygento\Antiseptic\Config\ConfigProcessor;
use Mygento\Antiseptic\Dumper\DumperBuilder;
use Mygento\Antiseptic\Sanitizer\Faker\ChecksumGenerator;
use Mygento\Antiseptic\Sanitizer\Faker\UniqueValueProcessor;

class TransformTableRowHook implements DumperConfiguratorInterface
{
    public function __construct(
        private FakerGenerator $faker,
        private UniqueValueProcessor $uniqueValueProcessor,
    ) {}

    public function configure(DumperBuilder $dumperBuilder, ConfigProcessor $configProcessor): void
    {
        $processedTables = $configProcessor->getProcessedTables();
        $dumperBuilder->setTransformTableRowHook($this->getCallback(
            $processedTables,
            $configProcessor,
            $this->faker,
            $this->uniqueValueProcessor,
        ));
    }

    /**
     * @param mixed[] $processedTables
     *
     * @return \Closure
     */
    private function getCallback(
        array $processedTables,
        ConfigProcessor $configProcessor,
        FakerGenerator $faker,
        UniqueValueProcessor $uniqueValueProcessor,
    ) {
        return function ($tableName, array $row) use ($processedTables, $configProcessor, $faker, $uniqueValueProcessor) {
            if (!in_array($tableName, $processedTables)) {
                return $row;
            }

            foreach ($configProcessor->getFieldsConfigByTableName($tableName) as $fieldName => $settings) {
                if (!isset($row[$fieldName], $settings[ConfigProcessor::FORMATTER_KEY])) {
                    continue;
                }

                $formatter = $configProcessor->getFormatter($settings);
                $formatterArgs = $configProcessor->getFormatterArgs($settings);

                $fieldChecksum = ChecksumGenerator::generate(
                    (string) $row[$fieldName],
                    $formatter,
                );

                if (isset($settings[ConfigProcessor::UNIQUE_KEY]) && true === $settings[ConfigProcessor::UNIQUE_KEY]) {
                    $row[$fieldName] = $uniqueValueProcessor->getUniqueValue(
                        (string) $row[$fieldName],
                        $formatter,
                        $formatterArgs,
                    );

                    continue;
                }

                $faker->seed($fieldChecksum);

                $row[$fieldName] = call_user_func([$faker, $formatter], ...$formatterArgs); // @phpstan-ignore-line
            }

            return $row;
        };
    }
}
