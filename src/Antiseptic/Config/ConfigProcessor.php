<?php

namespace Mygento\Antiseptic\Config;

use Symfony\Component\Yaml\Yaml;

class ConfigProcessor
{
    public const FORMATTER_KEY = 'formatter';
    public const FORMATTER_NAME = 'name';
    public const FORMATTER_ARGS = 'args';
    public const UNIQUE_KEY = 'unique';
    public const DEFAULT_LOCALE = 'en_US';
    private const LOCALE_KEY = 'locale';
    private const SOURCE_DB_KEY = 'source_db';
    private const DSN_KEY = 'dsn';
    private const USER_KEY = 'user';
    private const PASS_KEY = 'pass';
    private const DUMP_SETTINGS_KEY = 'dump_settings';
    private const PDO_SETTINGS_KEY = 'pdo_settings';
    private const TABLE_WHERES_KEY = 'table_wheres';
    private const TABLE_LIMITS_KEY = 'table_limits';
    private const TABLES_KEY = 'tables';

    /**
     * @var mixed[]|null
     */
    private ?array $config;

    public function __construct(
        string $fileName,
    ) {
        $this->config = Yaml::parseFile($fileName);
    }

    public function getLocale(): string
    {
        return (string) ($this->config[self::LOCALE_KEY] ?? self::DEFAULT_LOCALE);
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

    /**
     * @return mixed[]
     */
    public function getDumpSettings(): array
    {
        return (array) ($this->config[self::SOURCE_DB_KEY][self::DUMP_SETTINGS_KEY] ?? []);
    }

    /**
     * @return mixed[]
     */
    public function getPdoSettings(): array
    {
        return (array) ($this->config[self::SOURCE_DB_KEY][self::PDO_SETTINGS_KEY] ?? []);
    }

    /**
     * @return mixed[]
     */
    public function getTableWheres(): array
    {
        return (array) ($this->config[self::SOURCE_DB_KEY][self::TABLE_WHERES_KEY] ?? []);
    }

    /**
     * @return mixed[]
     */
    public function getTableLimits(): array
    {
        return (array) ($this->config[self::SOURCE_DB_KEY][self::TABLE_LIMITS_KEY] ?? []);
    }

    /**
     * @return mixed[]
     */
    public function getProcessedTables(): array
    {
        return array_keys($this->config[self::TABLES_KEY] ?? []);
    }

    /**
     * @return mixed[]
     */
    public function getFieldsConfigByTableName(string $tableName): array
    {
        $processedTables = $this->config[self::TABLES_KEY] ?? [];

        return (array) ($processedTables[$tableName] ?? []);
    }

    /**
     * @param mixed[] $fieldSettings
     */
    public function getFormatter(array $fieldSettings): string
    {
        return is_array($fieldSettings[ConfigProcessor::FORMATTER_KEY]) ?
            $fieldSettings[ConfigProcessor::FORMATTER_KEY][ConfigProcessor::FORMATTER_NAME]
            : $fieldSettings[ConfigProcessor::FORMATTER_KEY];
    }

    /**
     * @param mixed[] $fieldSettings
     *
     * @return mixed[]
     */
    public function getFormatterArgs(array $fieldSettings): array
    {
        if (
            is_array($fieldSettings[ConfigProcessor::FORMATTER_KEY])
            && array_key_exists(ConfigProcessor::FORMATTER_ARGS, $fieldSettings[ConfigProcessor::FORMATTER_KEY])
        ) {
            $formatterArgs = $fieldSettings[ConfigProcessor::FORMATTER_KEY][ConfigProcessor::FORMATTER_ARGS];
        } else {
            $formatterArgs = [];
        }

        return $formatterArgs;
    }
}
