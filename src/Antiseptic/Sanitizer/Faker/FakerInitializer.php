<?php

/**
 * @author Mygento Team
 * @copyright 2024 Mygento (https://www.mygento.com)
 * @package Mygento_Antiseptic
 */

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
