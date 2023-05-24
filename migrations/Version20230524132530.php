<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524132530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rule_ride (rule_id INT NOT NULL, ride_id INT NOT NULL, INDEX IDX_C8F923A7744E0351 (rule_id), INDEX IDX_C8F923A7302A8A70 (ride_id), PRIMARY KEY(rule_id, ride_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rule_ride ADD CONSTRAINT FK_C8F923A7744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rule_ride ADD CONSTRAINT FK_C8F923A7302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rule_ride DROP FOREIGN KEY FK_C8F923A7744E0351');
        $this->addSql('ALTER TABLE rule_ride DROP FOREIGN KEY FK_C8F923A7302A8A70');
        $this->addSql('DROP TABLE rule_ride');
    }
}
