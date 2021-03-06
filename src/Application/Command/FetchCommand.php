<?php

namespace Weeks\CurrencyWatcher\Application\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Message;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;
use Weeks\CurrencyWatcher\Domain\Mailer\MailerInterface;
use Weeks\CurrencyWatcher\Domain\Manager\CurrencyManager;
use Weeks\CurrencyWatcher\Domain\Manager\RateManager;
use Weeks\CurrencyWatcher\Domain\Repository\CurrencyRepositoryInterface;

class FetchCommand extends ContainerAwareCommand
{
    const INPUT_BASE = 'base';
    const INPUT_TARGET = 'target';

    protected function configure()
    {
        $this->setDescription('Fetch the latest')
            ->addArgument(self::INPUT_BASE, InputOption::VALUE_REQUIRED)
            ->addArgument(self::INPUT_TARGET, InputOption::VALUE_REQUIRED)
            ->addOption(
                'notify',
                null,
                InputOption::VALUE_NONE
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $today = new \DateTime();

        // Dont run at the weekend.
        if (in_array($today->format('N'), [6,7])) {
             //return 0;
        }

        $currencyManager = $this->getContainer()->get(CurrencyManager::class);

        $base = $currencyManager->getByCode($input->getArgument(self::INPUT_BASE));
        $target = $currencyManager->getByCode($input->getArgument(self::INPUT_TARGET));

        $rateManager = $this->getContainer()->get(RateManager::class);

        $previousRate = $rateManager->getLastRate($base, $target);

        $rate = $rateManager->fetchNewRate(
            $base,
            $target
        );

        $text = sprintf(
            'Current rate for %s to %s is: %s',
            $base->getCode(),
            $target->getCode(),
            $rate->getValue()
        );

        if (!$previousRate instanceof Rate) {
            $previousRate = $rate;
        }

        $comparison = $rateManager->compare($previousRate, $rate);

        $text .= '. ' . (string) $comparison;

        $output->writeln($text);

        if ($input->getOption('notify')) {
            $sent = $this->sendEmail(
                $rate->getValue() . ' - Rate Update',
                $text
            );

            $output->writeln($sent ? 'Email sent' : 'Email failed');
        }

        return 0;
    }

    private function sendEmail($subject, $message)
    {
        $message = new Message(
            $this->getContainer()->get('notification')['emailRecipients'],
            $subject,
            $message
        );

        return $this->getContainer()->get(MailerInterface::class)->send($message);
    }
}