<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607125103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD ride_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id)');
        $this->addSql('CREATE INDEX IDX_42C84955302A8A70 ON reservation (ride_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955302A8A70');
        $this->addSql('DROP INDEX IDX_42C84955302A8A70 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP ride_id');
    }
}
