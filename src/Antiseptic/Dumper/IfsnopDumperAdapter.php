<?php

namespace Mygento\Antiseptic\Dumper;

use Ifsnop\Mysqldump\Mysqldump;

class IfsnopDumperAdapter implements DumperInterface
{
    private $dumper;

    public function __construct(
        $dsn = '',
        $user = '',
        $pass = '',
        $dumpSettings = [],
        $pdoSettings = [],
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
    public function start(string $fileName = '')
    {
        return $this->dumper->start($fileName);
    }

    public function setTransformTableRowHook($callable): void
    {
        $this->dumper->setTransformTableRowHook($callable);
    }

    public function setInfoHook($callable): void
    {
        $this->dumper->setInfoHook($callable);
    }

    public function setTableWheres(array $tableWheres): void
    {
        $this->dumper->setTableWheres($tableWheres);
    }

    public function setTableLimits(array $tableLimits): void
    {
        $this->dumper->setTableLimits($tableLimits);
    }
}
