<?php

/**
 * @author Mygento Team
 * @copyright 2024 Mygento (https://www.mygento.com)
 * @package Mygento_Antiseptic
 */

namespace Mygento\Antiseptic\Dumper;

interface DumperInterface
{
    /**
     * @return null
     */
    public function start(string $fileName = '');

    /**
     * @param callable $callable
     */
    public function setTransformTableRowHook($callable): void;

    /**
     * @param callable $callable
     */
    public function setInfoHook($callable): void;

    public function setTableWheres(array $tableWheres): void;

    public function setTableLimits(array $tableLimits): void;
}
