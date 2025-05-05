<?php

namespace Mygento\Antiseptic\Sanitizer\Faker;

class ChecksumGenerator
{
    public static function generate(string ...$values): int
    {
        return (int) hash('crc32', implode($values));
    }
}
