<?php

namespace Mygento\Antiseptic\Sanitizer\Faker;

class PhoneNumberProvider extends \Faker\Provider\PhoneNumber
{
    // @phpstan-ignore-next-line
    protected static $formats = [
        '+7 (###) ###-##-##',
    ];
}
