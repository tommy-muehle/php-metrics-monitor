<?php

namespace MetricsMonitor\Command;

use MetricsMonitor\Exception\ParserException;
use MetricsMonitor\Exception\UnsupportedException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @package MetricsMonitor\Command
 */
class AddCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('add')
            ->addArgument('file', InputArgument::REQUIRED, 'File with metrics data.')
            ->addOption('slug', null, InputOption::VALUE_REQUIRED, 'Optional slug. Needed for visualization.', 'GENERAL')
            ->setDescription('Adds data from the metrics file to the database.')
            ->setHelp(<<<EOT
The <info>add</info> command adds data from the metrics file to the database for further visualization.

A sample call can look like this:
<info>php memo.phar add [file] --slug=PROJ1</info>
EOT
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = new \SplFileInfo($input->getArgument('file'));

        try {
            $this->app['broker']->execute($file, $input->getOption('slug'));
            $output->writeln(sprintf('<info>File "%s" added and data are saved!</info>', $file));
        } catch (UnsupportedException $exception) {
            $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));

            return 1;
        } catch (ParserException $exception) {
            $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));

            return 1;
        }

        return 0;
    }
}
