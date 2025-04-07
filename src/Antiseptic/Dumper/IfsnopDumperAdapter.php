<?php

namespace Mygento\Antiseptic\Dumper;

use Ifsnop\Mysqldump\Mysqldump;

class IfsnopDumperAdapter implements DumperInterface
{
    private Mysqldump $dumper;

    /**
     * @param mixed[] $dumpSettings
     * @param mixed[] $pdoSettings
     *
     * @throws \Exception
     */
    public function __construct(
        string $dsn = '',
        string $user = '',
        string $pass = '',
        array $dumpSettings = [],
        array $pdoSettings = [],
    ) {
        $this->dumper = new Mysqldump(
            $dsn,
            $user,
            $pass,
            $dumpSettings,
            $pdoSettings,
        );
    }

    /**
     * @throws \Exception
     */
    public function start(string $fileName = ''): void
    {
        $this->dumper->start($fileName);
    }

    public function setTransformTableRowHook($callable): void
    {
        $this->dumper->setTransformTableRowHook($callable);
    }

    public function setInfoHook($callable): void
    {
        $this->dumper->setInfoHook($callable);
    }

    /**
     * @param mixed[] $tableWheres
     */
    public function setTableWheres(array $tableWheres): void
    {
        $this->dumper->setTableWheres($tableWheres);
    }

    /**
     * @param mixed[] $tableLimits
     */
    public function setTableLimits(array $tableLimits): void
    {
        $this->dumper->setTableLimits($tableLimits);
    }
}
