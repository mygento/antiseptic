<?php

namespace Mygento\Antiseptic\Console\Command;

use Mygento\Antiseptic\Sanitizer\Sanitizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Sanitize extends Command
{
    private const ARG_CONFIG_FILE = 'config-file';
    private const ARG_DUMP_FILE = 'dump-file';

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('sanitize')
            ->setDefinition([
                new InputArgument(self::ARG_CONFIG_FILE, InputArgument::REQUIRED, 'YAML Configuration file'),
                new InputArgument(self::ARG_DUMP_FILE, InputArgument::REQUIRED, 'Path to output dump file'),
            ])
            ->setDescription('Creates dump and anonymize data')
            ->setHelp(
                <<<EOT
<info>php antiseptic.phar sanitize ./config.yaml ./anonymized-dump.sql</info>
EOT
            );
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $input->getArgument(self::ARG_CONFIG_FILE);
        $dumpFile = $input->getArgument(self::ARG_DUMP_FILE);

        $sanitizer = new Sanitizer();
        $sanitizer->sanitize($config, $dumpFile, $output);

        $output->writeln('<info>Dump created successfully</info>');

        return self::SUCCESS;
    }
}
