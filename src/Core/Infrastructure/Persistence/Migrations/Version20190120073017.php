<?php

declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190120073017 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates the exchange table.';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE TABLE exchange (
              id UUID NOT NULL, 
              name VARCHAR(255) NOT NULL, 
              symbols JSONB NOT NULL,
              created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
              updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
              PRIMARY KEY(id)
        )');

        $this->addSql('COMMENT ON COLUMN exchange.id IS \'(DC2Type:exchange_id)\'');
        $this->addSql('COMMENT ON COLUMN exchange.name IS \'(DC2Type:name)\'');
        $this->addSql('COMMENT ON COLUMN exchange.symbols IS \'(DC2Type:symbols)\'');
        $this->addSql('COMMENT ON COLUMN exchange.created_at IS \'(DC2Type:created_at)\'');
        $this->addSql('COMMENT ON COLUMN exchange.updated_at IS \'(DC2Type:updated_at)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP TABLE exchange');
    }
}
