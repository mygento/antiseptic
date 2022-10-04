<?php

namespace Mygento\Antiseptic\Sanitizer\Faker;

class PhoneNumberProvider extends \Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '+7 (###) ###-##-##',
    ];
}
