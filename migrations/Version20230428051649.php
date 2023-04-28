<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428051649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('SET FOREIGN_KEY_CHECKS=0');
        $this->addSql('ALTER TABLE option_excluded_product DROP INDEX UNIQ_19F8D2574584665A, ADD INDEX IDX_19F8D2574584665A (product_id)');
        $this->addSql('ALTER TABLE option_excluded_product DROP FOREIGN KEY FK_19F8D2574584665A');
        $this->addSql('ALTER TABLE option_excluded_product CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE option_excluded_product ADD CONSTRAINT FK_19F8D257A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id)');
        $this->addSql('ALTER TABLE option_excluded_product ADD CONSTRAINT FK_19F8D2574584665A FOREIGN KEY (product_id) REFERENCES `option` (id)');
        $this->addSql('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_excluded_product DROP INDEX IDX_19F8D2574584665A, ADD UNIQUE INDEX UNIQ_19F8D2574584665A (product_id)');
        $this->addSql('ALTER TABLE option_excluded_product DROP FOREIGN KEY FK_19F8D257A7C41D6F');
        $this->addSql('ALTER TABLE option_excluded_product DROP FOREIGN KEY FK_19F8D2574584665A');
        $this->addSql('ALTER TABLE option_excluded_product CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE option_excluded_product ADD CONSTRAINT FK_19F8D2574584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }
}
