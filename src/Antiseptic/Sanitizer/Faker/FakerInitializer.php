<?php

namespace Mygento\Antiseptic\Sanitizer\Faker;

use Faker\Factory;
use Faker\Generator;

class FakerInitializer
{
    public static function initialize(string $locale = Factory::DEFAULT_LOCALE): Generator
    {
        return Factory::create($locale);
    }
}
