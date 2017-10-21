<?php

namespace Weeks\CurrencyWatcher\Application\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class DbSeedCommand extends Command
{
    /**
     * @var Loader
     */
    private $loader;

    /**
     * @var ORMExecutor
     */
    private $executor;

    /**
     * @var
     */
    private $pathToSeeds;

    public function __construct(Loader $loader, ORMExecutor $executor, $pathToSeeds)
    {
        parent::__construct('db:seed');
        $this->loader = $loader;
        $this->executor = $executor;
        $this->pathToSeeds = $pathToSeeds;
    }

    protected function configure()
    {
        $this->setDescription('Seed the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you wish to seed the database? ', false);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('exiting.');
            return;
        }

        $this->loader->loadFromDirectory($this->pathToSeeds);

        $this->executor->execute($this->loader->getFixtures());
    }
}