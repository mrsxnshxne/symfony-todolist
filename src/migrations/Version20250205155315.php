<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250205155315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON task_user');
        $this->addSql('ALTER TABLE task_user ADD PRIMARY KEY (task_id, user_id)');
        $this->addSql('ALTER TABLE task_user RENAME INDEX idx_28ff97ec8db60186 TO IDX_FE2042328DB60186');
        $this->addSql('ALTER TABLE task_user RENAME INDEX idx_28ff97eca76ed395 TO IDX_FE204232A76ED395');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON task_user');
        $this->addSql('ALTER TABLE task_user ADD PRIMARY KEY (user_id, task_id)');
        $this->addSql('ALTER TABLE task_user RENAME INDEX idx_fe204232a76ed395 TO IDX_28FF97ECA76ED395');
        $this->addSql('ALTER TABLE task_user RENAME INDEX idx_fe2042328db60186 TO IDX_28FF97EC8DB60186');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
