<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328173212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE housing ADD provider_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL, ADD quarter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE housing ADD CONSTRAINT FK_FB8142C3A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE housing ADD CONSTRAINT FK_FB8142C312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE housing ADD CONSTRAINT FK_FB8142C3BED4A2B2 FOREIGN KEY (quarter_id) REFERENCES quarter (id)');
        $this->addSql('CREATE INDEX IDX_FB8142C3A53A8AA ON housing (provider_id)');
        $this->addSql('CREATE INDEX IDX_FB8142C312469DE2 ON housing (category_id)');
        $this->addSql('CREATE INDEX IDX_FB8142C3BED4A2B2 ON housing (quarter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE housing DROP FOREIGN KEY FK_FB8142C3A53A8AA');
        $this->addSql('ALTER TABLE housing DROP FOREIGN KEY FK_FB8142C312469DE2');
        $this->addSql('ALTER TABLE housing DROP FOREIGN KEY FK_FB8142C3BED4A2B2');
        $this->addSql('DROP INDEX IDX_FB8142C3A53A8AA ON housing');
        $this->addSql('DROP INDEX IDX_FB8142C312469DE2 ON housing');
        $this->addSql('DROP INDEX IDX_FB8142C3BED4A2B2 ON housing');
        $this->addSql('ALTER TABLE housing DROP provider_id, DROP category_id, DROP quarter_id');
    }
}
