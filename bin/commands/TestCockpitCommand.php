<?php

namespace Cockpit\Php\Commands;

use Cockpit\Php\Exceptions\CockpitErrorHandler;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

class TestCockpitCommand extends Command
{
    public function __construct()
    {
        parent::__construct('test');
        parent::setDescription('Send fake data to webhook');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = new ConsoleLogger($output);

        if (!$link = getenv('COCKPIT_DOMAIN')) {
            $logger->error('You must fill COCKPIT_DOMAIN env with a valid cockpit endpoint');

            return Command::FAILURE;
        }

        /** @var CockpitErrorHandler $errorHandler */
        $errorHandler = new CockpitErrorHandler();
        $errorHandler->write([
            'context' => [
                'exception' => new Exception('Test generated by the cockpit:test command'),
            ],
        ]);

        if ($errorHandler->failed) {
            $logger->error('We couldn\'t reach Cockpit Server at ' . $link);

            if ($reason = $errorHandler->reason()) {
                $logger->error($reason);
            }

            return Command::FAILURE;
        }

        $output->writeln("<info>Cockpit reached successfully. We sent a test Exception that has been registered.</info>");

        return Command::SUCCESS;
    }
}
