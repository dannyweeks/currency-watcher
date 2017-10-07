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
    protected function configure()
    {
        $this->setDescription('Fetch the latest')
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
            return 0;
        }

        // Remind me to stop this running after the wedding!
        if ($today > \DateTime::createFromFormat('Y-m-d', '2017-10-20')) {

            if ($today > \DateTime::createFromFormat('Y-m-d', '2017-11-25')) {
                $this->sendEmail('Watcher...', 'You should probably cancel this cron job...');
            }
            return 0;
        }

        $currencyManager = $this->getContainer()->get(CurrencyManager::class);

        $base = $currencyManager->getByCode(Currency::CODE_GBP);
        $target = $currencyManager->getByCode(Currency::CODE_ISK);

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