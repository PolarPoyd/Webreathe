<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829000621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module_data ADD module_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module_data ADD CONSTRAINT FK_17CFB66FAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_17CFB66FAFC2B591 ON module_data (module_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module_data DROP FOREIGN KEY FK_17CFB66FAFC2B591');
        $this->addSql('DROP INDEX IDX_17CFB66FAFC2B591 ON module_data');
        $this->addSql('ALTER TABLE module_data DROP module_id');
    }
}
