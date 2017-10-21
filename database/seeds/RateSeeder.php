<?php

namespace CurrencyWatcher\Seeder;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;

class RateSeeder implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
      // @todo implement rate seeder
    }
}