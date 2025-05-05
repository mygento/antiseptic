<?php

namespace Mygento\Antiseptic\Sanitizer\Faker;

use Faker\Generator;

class UniqueValueProcessor
{
    /**
     * @var mixed[]
     */
    private array $checksumsWithNonUniqueValue = [];

    /**
     * @var mixed[]
     */
    private array $uniqueValues = [];

    public function __construct(
        private Generator $faker,
    ) {}

    /**
     * @param mixed[] $formatterArgs
     */
    public function getUniqueValue(string $originalValue, string $formatter, array $formatterArgs = []): string
    {
        $checkSum = ChecksumGenerator::generate($originalValue, $formatter);

        if (isset($this->checksumsWithNonUniqueValue[$formatter][$checkSum])) {
            return $this->processChecksumWithNonUniqueValue($checkSum, $originalValue, $formatter, $formatterArgs);
        }

        $this->faker->seed($checkSum);
        // @phpstan-ignore-next-line
        $sanitizedValue = call_user_func([$this->faker, $formatter], ...$formatterArgs);

        if (!$this->isValueUnique($sanitizedValue, $originalValue, $formatter)) {
            return $this->processNonUniqueValue($checkSum, $originalValue, $formatter);
        }

        $this->uniqueValues[$formatter][$sanitizedValue] = $originalValue;

        return $sanitizedValue;
    }

    /**
     * @param mixed[] $formatterArgs
     */
    private function processChecksumWithNonUniqueValue(
        int $checkSum,
        string $originalValue,
        string $formatter,
        array $formatterArgs,
    ): string {
        $this->faker->seed($checkSum + $this->checksumsWithNonUniqueValue[$formatter][$checkSum]);
        // @phpstan-ignore-next-line
        $value = call_user_func([$this->faker, $formatter], ...$formatterArgs);
        $this->uniqueValues[$formatter][$value] = $originalValue;

        return $value;
    }

    private function processNonUniqueValue(int $originalChecksum, string $originalValue, string $formatter): string
    {
        $checksSumSalt = strlen($originalValue) + rand(1, 1000);
        $increment = -1;

        do {
            ++$increment;
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
