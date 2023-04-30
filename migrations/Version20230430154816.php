<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430154816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD727ACA70 FOREIGN KEY (parent_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD727ACA70 ON product (parent_id)');
        $this->addSql('ALTER TABLE question ADD position INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD727ACA70');
        $this->addSql('DROP INDEX IDX_D34A04AD727ACA70 ON product');
        $this->addSql('ALTER TABLE product DROP parent_id');
        $this->addSql('ALTER TABLE question DROP position');
    }
}
