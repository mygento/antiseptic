<?php

namespace Mygento\Antiseptic\Sanitizer\Faker;

class ChecksumGenerator
{
    public static function generate(string ...$values): int
    {
        return crc32(implode($values));
    }
}
