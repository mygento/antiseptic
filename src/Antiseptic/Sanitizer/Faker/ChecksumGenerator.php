<?php

/**
 * @author Mygento Team
 * @copyright 2024 Mygento (https://www.mygento.com)
 * @package Mygento_Antiseptic
 */

namespace Mygento\Antiseptic\Sanitizer\Faker;

class ChecksumGenerator
{
    public static function generate(string ...$values): int
    {
        return crc32(implode($values));
    }
}
