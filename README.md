# Antiseptic
Tool to create database dump and anonymize its data.

# Database Personal Data Anonymizer description

CLI tool for securely anonymizing personal data from databases according to specified settings.

## 📦 Installation

### Requirements
- PHP 8.1 or higher
- MySQL database access
- PHP `pdo` extension for your DBMS

### Phar Archive Installation
1. Download the latest `antiseptic.phar` from [Releases](https://github.com/mygento/antiseptic/releases)
2. Make the file executable:
   ```bash
   chmod +x antiseptic.phar
   ```
3. If you want to use the command system wide you can copy it to /usr/local/bin.
   ```bash
   sudo mv antiseptic.phar /usr/local/bin/antiseptic
   ```

## 🚀 Usage

```bash
php antiseptic.phar sanitize [OPTIONS] OUTPUT_FILENAME
```

### Core Options
| Option               | Description                                                      |
|----------------------|------------------------------------------------------------------|
| `-c, --config=FILE`  | Path to configuration file `[ default: .antiseptic_config.yml ]` |
| `-v, --verbose`      | Verbose output                                                   |
| `--help`             | Show help message                                                |

### Examples
```bash
# Standard cleanup with config
php antiseptic.phar sanitize -c config_magento.yaml sanitized_backup.sql

# With default config run
php antiseptic.phar sanitize sanitized_backup.sql
```

## ⚙️ Configuration
Create a YAML configuration file (see `config.yml.dist`, `config_magento.yml.dist`):

```yaml
locale: 'ru_RU' #default value en_US
source_db:
   dsn: 'mysql:host=<host>;port=<port>;dbname=<dbname>'
   user: 'dbusername'
   pass: 'dbpassword'
   table_wheres:
      admin_user: "`username` = 'admin'" # leave only one user with name admin
   table_limits:
      cache: 0 # create empty table
   dump_settings:
      exclude-tables:
         - '/_tmp$/'
tables: #list tables and fields for anonymize data
   customer:
      email:
         formatter: 'email'
         unique: true
      firstname:
         formatter: 'firstName'
      lastname:
         formatter: 'lastName'
```

### section config `source_db`
This section of the config is compatible with [settings](https://github.com/ifsnop/mysqldump-php#dump-settings)

### section config `tables`
This section of the config describes which table and fields from the table should be replaced with fake data.   
Formatter can be set any formatter from [list formatters](https://fakerphp.org/formatters/)

## 📝 Note
 - If you set a limit or condition to select some records from a table,    
   it's not involved in limiting for related records by a foreign key in another table. Be attending with it.

## 📜 License
MIT License. See [LICENSE](LICENSE) file.

