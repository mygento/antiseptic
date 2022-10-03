<?php

namespace Mygento\Antiseptic\Sanitizer\Faker;

use Faker\Factory;
use Faker\Generator;

class FakerInitializer
{
    public static function initialize(): Generator
    {
        $faker = Factory::create();
        $faker->addProvider(new PhoneNumberProvider($faker));

        return $faker;
    }
}
