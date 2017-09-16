<?php

namespace Weeks\CurrencyWatcher\Application\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class DbSeedCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setDescription('Seed the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you wish to seed the database?', false);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('exiting.');
            return;
        }

        $loader = $this->getContainer()->get(Loader::class);

        $loader->loadFromDirectory(
            $this->getContainer()->get('appRoot') . '/seeds'
        );

        $this->getContainer()
            ->get(ORMExecutor::class)
            ->execute($loader->getFixtures());
    }
}