<?php

namespace MetricsMonitor\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * @package MetricsMonitor\Command
 */
class RunCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('run')
            ->setDefinition([
                new InputArgument('address', InputArgument::OPTIONAL, 'Address:port', 'localhost:8000'),
                new InputOption('docroot', 'd', InputOption::VALUE_OPTIONAL, 'Document root', __DIR__ . '/../../public'),
                new InputOption('router', 'r', InputOption::VALUE_OPTIONAL, 'Path to custom router script', 'app.php'),
            ])
            ->setDescription('Provides the GUI for metrics monitor.')
            ->setHelp(<<<EOT
The <info>run</info> command provides the GUI for metrics monitor.

A sample call can look like this:
<info>php memo.phar run</info>
EOT
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $address = $input->getArgument('address');
        $docRoot = $input->getOption('docroot');
        $router = $input->getOption('router');

        $processBuilder = new ProcessBuilder([PHP_BINARY, '-S', $address, $docRoot . '/' . $router]);
        $processBuilder
            ->setWorkingDirectory($docRoot)
            ->setTimeout(null);

        $output->writeln(sprintf("Server running on <info>http://%s</info>\n", $address));
        $output->writeln('Quit the server with CONTROL-C.');

        $process = $processBuilder->getProcess();

        $process->run(function ($type, $buffer) use ($output) {
            if (OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                $output->write($buffer);
            }
        });

        return $process->getExitCode();
    }
}
