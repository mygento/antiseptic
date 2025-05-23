<?php

namespace Mygento\Antiseptic\Console\Command;

use Mygento\Antiseptic\Sanitizer\Sanitizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Sanitize extends Command
{
    private const OPTION_NAME_CONFIG_FILE = 'config';
    private const ARG_DUMP_FILE = 'dump-file';

    protected function configure()
    {
        $this
            ->setName('sanitize')
            ->setDefinition([
                new InputArgument(
                    self::ARG_DUMP_FILE,
                    InputArgument::OPTIONAL,
                    'Path to output dump file, if not set will be used stdout',
                    '',
                ),
            ])
            ->addOption(
                self::OPTION_NAME_CONFIG_FILE,
                'c',
                InputOption::VALUE_OPTIONAL,
                'Path to configuration file',
                '.antiseptic_config.yml',
            )
            ->setDescription('Creates dump and anonymize data')
            ->setHelp(
                <<<EOT
<info>php antiseptic.phar sanitize  anonymized-dump.sql</info>
EOT,
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $input->getOption(self::OPTION_NAME_CONFIG_FILE);
        $dumpFile = $input->getArgument(self::ARG_DUMP_FILE);

        $sanitizer = new Sanitizer();
        $sanitizer->sanitize($config, $dumpFile);

        $output->writeln('<info>Dump created successfully</info>');

        return self::SUCCESS;
    }
}
