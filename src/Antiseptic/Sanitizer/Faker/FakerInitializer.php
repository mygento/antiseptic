<?php

namespace Mygento\Antiseptic\Sanitizer\Faker;

use Faker\Factory;
use Faker\Generator;

class FakerInitializer
{
    public static function initialize(string $locale = Factory::DEFAULT_LOCALE): Generator
    {
        $faker = Factory::create($locale);
        $faker->addProvider(new PhoneNumberProvider($faker));

        return $faker;
    }
}
