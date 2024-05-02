<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240308122948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT "like_pkey"');
        $this->addSql('ALTER TABLE "like" DROP id');
        $this->addSql('ALTER TABLE "like" ALTER author_id SET NOT NULL');
        $this->addSql('ALTER TABLE "like" ADD PRIMARY KEY (post_id, author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX like_pkey');
        $this->addSql('ALTER TABLE "like" ADD id UUID NOT NULL');
        $this->addSql('ALTER TABLE "like" ALTER author_id DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN "like".id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE "like" ADD PRIMARY KEY (id)');
    }
}
