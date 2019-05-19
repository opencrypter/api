<?php
declare(strict_types=1);

namespace Core\Ui\Command;

use Core\Application\Ticker\SyncTickers;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBus;

class SyncTickersCommand extends Command
{
    private $logger;

    /**
     * @var MessageBus
     */
    private $commandBus;

    public function __construct(LoggerInterface $consoleLogger, MessageBus $commandBus)
    {
        parent::__construct(null);
        $this->logger = $consoleLogger;
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setName('opencrypter:tickers:sync')
            ->setDescription('It syncs tickers from external exchanges')
            ->addArgument('exchange', InputArgument::REQUIRED, 'Name of the exchange to be synced');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exchange = $input->getArgument('exchange');

        $this->logger->info("Syncing tickers from {$exchange}");

        $this->commandBus->dispatch(new SyncTickers($exchange));

        $this->logger->info('All synced');
    }
}
