<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328173531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quarter ADD city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quarter ADD CONSTRAINT FK_1C81E1078BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_1C81E1078BAC62AF ON quarter (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quarter DROP FOREIGN KEY FK_1C81E1078BAC62AF');
        $this->addSql('DROP INDEX IDX_1C81E1078BAC62AF ON quarter');
        $this->addSql('ALTER TABLE quarter DROP city_id');
    }
}
