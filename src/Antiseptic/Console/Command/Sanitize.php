<?php

namespace Mygento\Antiseptic\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Sanitize extends Command
{
    private const ARG_CONFIG = 'config';
    private const ARG_OUTPUT_DUMP = 'output-dump';

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('sanitize')
            ->setDefinition([
                new InputArgument(self::ARG_CONFIG, InputArgument::REQUIRED, 'YAML Configuration file'),
                new InputArgument(self::ARG_OUTPUT_DUMP, InputArgument::REQUIRED, 'Path to output dump file'),
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
        //todo: remove with right logic
        $output->writeln('<info>You are great!</info>');

        $config = $input->getArgument(self::ARG_CONFIG);
        $outputDump = $input->getArgument(self::ARG_OUTPUT_DUMP);

        $output->writeln(sprintf("You entered:\n%s - for config argument.\n%s - for output-dump argument", $config, $outputDump));

        return self::SUCCESS;
    }
}