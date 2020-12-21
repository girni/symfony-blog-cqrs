<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201221155007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
               CREATE TABLE `posts` (
                `id` VARCHAR(36),
                `title` VARCHAR(80),
                `content` TEXT,
                `image` VARCHAR(255),
                PRIMARY KEY (`id`)
            );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE posts');
    }
}
