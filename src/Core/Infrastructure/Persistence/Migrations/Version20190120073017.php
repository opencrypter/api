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


        $this->addSql('CREATE TABLE "order" (
              id UUID NOT NULL, PRIMARY KEY(id)
        )');

        $this->addSql('COMMENT ON COLUMN "order".id IS \'(DC2Type:order_id)\'');
        $this->addSql('CREATE TABLE order_step (
              id UUID NOT NULL, 
              order_id UUID NOT NULL, 
              type VARCHAR(255) NOT NULL, 
              symbol VARCHAR(255) NOT NULL, 
              value DOUBLE PRECISION NOT NULL, 
              created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
              executed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
              PRIMARY KEY(id)
        )');

        $this->addSql('CREATE INDEX IDX_E48C42B8D9F6D38 ON order_step (order_id)');
        $this->addSql('COMMENT ON COLUMN order_step.id IS \'(DC2Type:order_step_id)\'');
        $this->addSql('COMMENT ON COLUMN order_step.order_id IS \'(DC2Type:order_id)\'');
        $this->addSql('COMMENT ON COLUMN order_step.type IS \'(DC2Type:order_step_type)\'');
        $this->addSql('COMMENT ON COLUMN order_step.symbol IS \'(DC2Type:symbol)\'');
        $this->addSql('COMMENT ON COLUMN order_step.value IS \'(DC2Type:order_value)\'');
        $this->addSql('COMMENT ON COLUMN order_step.created_at IS \'(DC2Type:created_at)\'');
        $this->addSql('COMMENT ON COLUMN order_step.executed_at IS \'(DC2Type:executed_at)\'');

        $this->addSql('ALTER TABLE order_step
              ADD CONSTRAINT FK_E48C42B8D9F6D38 
              FOREIGN KEY (order_id) 
              REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP TABLE exchange');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE order_step');
    }
}
