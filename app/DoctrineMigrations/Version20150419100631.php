<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150419100631 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE supplier_item CHANGE supplier_id supplier_id INT DEFAULT NULL, CHANGE item_id item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE supplier_item ADD CONSTRAINT FK_D243D3F72ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE supplier_item ADD CONSTRAINT FK_D243D3F7126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_D243D3F72ADD6D8C ON supplier_item (supplier_id)');
        $this->addSql('CREATE INDEX IDX_D243D3F7126F525E ON supplier_item (item_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE supplier_item DROP FOREIGN KEY FK_D243D3F72ADD6D8C');
        $this->addSql('ALTER TABLE supplier_item DROP FOREIGN KEY FK_D243D3F7126F525E');
        $this->addSql('DROP INDEX IDX_D243D3F72ADD6D8C ON supplier_item');
        $this->addSql('DROP INDEX IDX_D243D3F7126F525E ON supplier_item');
        $this->addSql('ALTER TABLE supplier_item CHANGE supplier_id supplier_id INT NOT NULL, CHANGE item_id item_id INT NOT NULL');
    }
}
