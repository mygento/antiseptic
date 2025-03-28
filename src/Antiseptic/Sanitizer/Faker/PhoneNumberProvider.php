<?php

/**
 * @author Mygento Team
 * @copyright 2024 Mygento (https://www.mygento.com)
 * @package Mygento_Antiseptic
 */

namespace Mygento\Antiseptic\Sanitizer\Faker;

class PhoneNumberProvider extends \Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '+7 (###) ###-##-##',
    ];
}
