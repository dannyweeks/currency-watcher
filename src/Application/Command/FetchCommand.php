<?php

namespace Weeks\CurrencyWatcher\Application\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Message;
use Weeks\CurrencyWatcher\Domain\Mailer\MailerInterface;
use Weeks\CurrencyWatcher\Domain\Manager\CurrencyManager;
use Weeks\CurrencyWatcher\Domain\Manager\RateManager;

class FetchCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fetch')
            ->setDescription('Fetch the latest');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencyManager = $this->getContainer()->get(CurrencyManager::class);

        $base = $currencyManager->getByCode(Currency::CODE_GBP);
        $target = $currencyManager->getByCode(Currency::CODE_ISK);

        $rate = $this->getContainer()
            ->get(RateManager::class)
            ->fetchNewRate(
                $base,
                $target
            );

        $text = sprintf(
            'Current rate for %s to %s is: %s',
            $base->getCode(),
            $target->getCode(),
            $rate->getValue()
        );
        $output->writeln(
            $text
        );

        $message = new Message(
            $this->getContainer()->get('notification')['emailRecipients'],
            'Rate Update',
            $text
        );

        $sent = $this->getContainer()->get(MailerInterface::class)->send($message);

        $output->writeln($sent ? 'Email sent' : 'Email failed');

        return 0;
    }
}