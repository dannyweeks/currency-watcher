<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170912230648 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        foreach ($this->getFixturesArray() as $line) {
            $this->addSql($line);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DELETE FROM rates');
        $this->addSql('DELETE FROM currencies');
    }

    /**
     * @return array
     */
    private function getFixturesArray()
    {
        $contents = file_get_contents(__DIR__ . '/files/initial.sql');

        $lines = explode("\n", $contents);

        return $lines;
    }
}
