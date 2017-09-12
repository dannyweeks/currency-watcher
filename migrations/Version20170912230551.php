<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170912230551 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE currencies (id INTEGER NOT NULL, code VARCHAR(255) NOT NULL, symbol VARCHAR(255) NOT NULL, countryName VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37C4469377153098 ON currencies (code)');
        $this->addSql('CREATE TABLE rates (id INTEGER NOT NULL, base_currency_id INTEGER DEFAULT NULL, target_currency_id INTEGER DEFAULT NULL, quoted_at DATETIME NOT NULL, value NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_44D4AB3C3101778E ON rates (base_currency_id)');
        $this->addSql('CREATE INDEX IDX_44D4AB3CBF1ECE7C ON rates (target_currency_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE currencies');
        $this->addSql('DROP TABLE rates');
    }
}
