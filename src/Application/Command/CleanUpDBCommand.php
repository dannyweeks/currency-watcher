<?php

namespace Weeks\CurrencyWatcher\Application\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Manager\CurrencyManager;
use Weeks\CurrencyWatcher\Domain\Manager\RateManager;

class CleanUpDBCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('clean-db')
            ->setDescription('Purge old records');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // @todo write this command?

        return 0;
    }
}