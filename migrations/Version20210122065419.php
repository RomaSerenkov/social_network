<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122065419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add user table fields first_name, last_name, birthday, image';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) NULL, ADD last_name VARCHAR(255) NULL, ADD birthday DATE NULL, ADD image VARCHAR(255) NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name, DROP birthday, DROP image');
    }
}
