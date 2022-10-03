<?php

namespace Mygento\Antiseptic\Config;

use Symfony\Component\Yaml\Yaml;

class ConfigProcessor
{
    public const FORMATTER_KEY = 'formatter';

    private const SOURCE_DB_KEY = 'source_db';
    private const DSN_KEY = 'dsn';
    private const USER_KEY = 'user';
    private const PASS_KEY = 'pass';
    private const DUMP_SETTINGS_KEY = 'dump_settings';
    private const PDO_SETTINGS_KEY = 'pdo_settings';

    private const TABLES_KEY = 'tables';

    private $config;

    public function __construct(
        string $fileName
    ) {
        $this->config = Yaml::parseFile($fileName);
    }

    public function getDsn(): string
    {
        return (string) ($this->config[self::SOURCE_DB_KEY][self::DSN_KEY] ?? '');
    }

    public function getUser(): string
    {
        return (string) ($this->config[self::SOURCE_DB_KEY][self::USER_KEY] ?? '');
    }

    public function getPass(): string
    {
        return (string) ($this->config[self::SOURCE_DB_KEY][self::PASS_KEY] ?? '');
    }

    public function getDumpSettings(): array
    {
        return (array) ($this->config[self::SOURCE_DB_KEY][self::DUMP_SETTINGS_KEY] ?? []);
    }

    public function getPdoSettings(): array
    {
        return (array) ($this->config[self::SOURCE_DB_KEY][self::PDO_SETTINGS_KEY] ?? []);
    }

    public function getProcessedTables(): array
    {
        return array_keys($this->config[self::TABLES_KEY] ?? []);
    }

    public function getFieldsConfigByTableName(string $tableName): array
    {
        $processedTables = $this->config[self::TABLES_KEY];

        return (array) ($processedTables[$tableName] ?? []);
    }
}
