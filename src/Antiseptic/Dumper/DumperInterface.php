<?php

namespace Mygento\Antiseptic\Dumper;

interface DumperInterface
{
    public function start(string $fileName = ''): void;

    /**
     * @param callable $callable
     */
    public function setTransformTableRowHook($callable): void;

    /**
     * @param callable $callable
     */
    public function setInfoHook($callable): void;

    /**
     * @param mixed[] $tableWheres
     */
    public function setTableWheres(array $tableWheres): void;

    /**
     * @param mixed[] $tableLimits
     */
    public function setTableLimits(array $tableLimits): void;
}
