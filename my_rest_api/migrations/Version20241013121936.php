<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241013121936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD price DOUBLE PRECISION NOT NULL, ADD quantity INT NOT NULL, ADD internal_reference VARCHAR(255) NOT NULL, ADD shell_id INT NOT NULL, ADD inventory_status VARCHAR(255) NOT NULL, ADD rating VARCHAR(255) NOT NULL, ADD created_at DATE NOT NULL, ADD updated_at DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP price, DROP quantity, DROP internal_reference, DROP shell_id, DROP inventory_status, DROP rating, DROP created_at, DROP updated_at');
    }
}
