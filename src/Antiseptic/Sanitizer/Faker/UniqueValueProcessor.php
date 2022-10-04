<?php

namespace Mygento\Antiseptic\Sanitizer\Faker;

use Faker\Generator;
use Mygento\Antiseptic\Config\ConfigProcessor;

class UniqueValueProcessor
{
    /**
     * @var array
     */
    private $checksumsWithNonUniqueValue = [];

    /**
     * @var array
     */
    private $uniqueValues = [];

    /**
     * @var Generator
     */
    private $faker;

    public function __construct(
        Generator $faker
    ) {
        $this->faker = $faker;
    }

    public function getUniqueValue(string $originalValue, array $fieldConfig): string
    {
        $formatter = (string) $fieldConfig[ConfigProcessor::FORMATTER_KEY];
        $checkSum = ChecksumGenerator::generate($originalValue, $formatter);

        if (isset($this->checksumsWithNonUniqueValue[$formatter][$checkSum])) {
            return $this->processChecksumWithNonUniqueValue($checkSum, $originalValue, $formatter);
        }

        $this->faker->seed($checkSum);
        $sanitizedValue = $this->faker->{$formatter};

        if (!$this->isValueUnique($sanitizedValue, $originalValue, $formatter)) {
            return $this->processNonUniqueValue($checkSum, $originalValue, $formatter);
        }

        $this->uniqueValues[$formatter][$sanitizedValue] = $originalValue;

        return $sanitizedValue;
    }

    private function processChecksumWithNonUniqueValue(int $checkSum, string $originalValue, string $formatter): string
    {
        $this->faker->seed($checkSum + $this->checksumsWithNonUniqueValue[$formatter][$checkSum]);

        $value = $this->faker->{$formatter};
        $this->uniqueValues[$formatter][$value] = $originalValue;

        return $value;
    }

    private function processNonUniqueValue(int $originalChecksum, string $originalValue, string $formatter): string
    {
        $checksSumSalt = strlen($originalValue) + rand(1, 1000);
        $increment = -1;

        do {
            $increment++;
            $checksSumSalt += $increment;

            $this->checksumsWithNonUniqueValue[$formatter][$originalChecksum] = $checksSumSalt;

            $this->faker->seed($originalChecksum + $checksSumSalt);
            $newValue = $this->faker->{$formatter};
        } while (!$this->isValueUnique($newValue, $originalValue, $formatter));

        $this->uniqueValues[$formatter][$newValue] = $originalValue;

        return $newValue;
    }

    private function isValueUnique(string $value, string $originalValue, string $formatter): bool
    {
        if (!isset($this->uniqueValues[$formatter])) {
            $this->uniqueValues[$formatter] = [];
        }

        return !array_key_exists($value, $this->uniqueValues[$formatter])
            || $originalValue === $this->uniqueValues[$formatter][$value];
    }
}
