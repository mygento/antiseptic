<?php

namespace Mygento\Antiseptic\Console;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public const VERSION = '0.1.0';
    public const NAME = 'Antiseptic';

    public function __construct()
    {
        parent::__construct(self::NAME, self::VERSION);
    }

    /**
     * Initializes all commands.
     */
    protected function getDefaultCommands()
    {

        return array_merge(parent::getDefaultCommands(), [
            new Command\Sanitize(),
        ]);
    }
}
