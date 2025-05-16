<?php

namespace Mygento\Antiseptic\Dumper;

class DumperBuilder
{
    private string $dsn = '';
    private string $user = '';
    private string $pass = '';

    /**
     * @var mixed[]
     */
    private array $dumpSettings = [];

    /**
     * @var mixed[]
     */
    private array $pdoSettings = [];

    /**
     * @var mixed[]
     */
    private array $tableWheres = [];

    /**
     * @var mixed[]
     */
    private array $tableLimits = [];

    /**
     * @var callable
     */
    private mixed $transformTableRowHook = null;

    /**
     * @var callable
     */
    private mixed $infoHook = null;

    public function setDsn(string $dsn): DumperBuilder
    {
        $this->dsn = $dsn;

        return $this;
    }

    public function setUser(string $user): DumperBuilder
    {
        $this->user = $user;

        return $this;
    }

    public function setPass(string $pass): DumperBuilder
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * @param mixed[] $dumpSettings
     *
     * @return $this
     */
    public function addDumpSettings(array $dumpSettings): DumperBuilder
    {
        $this->dumpSettings = array_replace_recursive($this->dumpSettings, $dumpSettings);

        return $this;
    }

    /**
     * @param mixed[] $pdoSettings
     *
     * @return $this
     */
    public function addPdoSettings(array $pdoSettings): DumperBuilder
    {
        $this->pdoSettings = array_replace_recursive($this->pdoSettings, $pdoSettings);

        return $this;
    }

    /**
     * @param mixed[] $tableWheres
     *
     * @return $this
     */
    public function addTableWheres(array $tableWheres): DumperBuilder
    {
        $this->tableWheres = array_replace_recursive($this->tableWheres, $tableWheres);

        return $this;
    }

    /**
     * @param mixed[] $tableLimits
     *
     * @return $this
     */
    public function addTableLimits(array $tableLimits): DumperBuilder
    {
        $this->tableLimits = array_replace_recursive($this->tableLimits, $tableLimits);

        return $this;
    }

    /**
     * @param callable $transformTableRowHook
     */
    public function setTransformTableRowHook($transformTableRowHook): DumperBuilder
    {
        $this->transformTableRowHook = $transformTableRowHook;

        return $this;
    }

    /**
     * @param callable $infoHook
     */
    public function setInfoHook($infoHook): DumperBuilder
    {
        $this->infoHook = $infoHook;

        return $this;
    }

    public function create(): DumperInterface
    {
        $dumper = $this->createDumper();

        if (count($this->tableWheres)) {
            $dumper->setTableWheres($this->tableWheres);
        }

        if (count($this->tableLimits)) {
            $dumper->setTableLimits($this->tableLimits);
        }

        if (is_callable($this->transformTableRowHook)) {
            $dumper->setTransformTableRowHook($this->transformTableRowHook);
        }

        if (is_callable($this->infoHook)) {
            $dumper->setInfoHook($this->infoHook);
        }

        return $dumper;
    }

    private function createDumper(): DumperInterface
    {
        return new IfsnopDumperAdapter(
            $this->dsn,
            $this->user,
            $this->pass,
            $this->dumpSettings,
            $this->pdoSettings,
        );
    }
}
