<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526122303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ride_rule (ride_id INT NOT NULL, rule_id INT NOT NULL, INDEX IDX_DE799B8302A8A70 (ride_id), INDEX IDX_DE799B8744E0351 (rule_id), PRIMARY KEY(ride_id, rule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ride_rule ADD CONSTRAINT FK_DE799B8302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ride_rule ADD CONSTRAINT FK_DE799B8744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ride DROP FOREIGN KEY FK_9B3D7CD057BF31F5');
        $this->addSql('DROP INDEX IDX_9B3D7CD057BF31F5 ON ride');
        $this->addSql('ALTER TABLE ride DROP reservation_ride_id, CHANGE departure departure VARCHAR(255) NOT NULL, CHANGE destination destination VARCHAR(255) NOT NULL, CHANGE date date DATETIME NOT NULL, CHANGE created created DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ride_rule DROP FOREIGN KEY FK_DE799B8302A8A70');
        $this->addSql('ALTER TABLE ride_rule DROP FOREIGN KEY FK_DE799B8744E0351');
        $this->addSql('DROP TABLE ride_rule');
        $this->addSql('ALTER TABLE ride ADD reservation_ride_id INT DEFAULT NULL, CHANGE departure departure VARCHAR(100) NOT NULL, CHANGE destination destination VARCHAR(100) NOT NULL, CHANGE date date DATE NOT NULL, CHANGE created created DATE NOT NULL');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD057BF31F5 FOREIGN KEY (reservation_ride_id) REFERENCES reservation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9B3D7CD057BF31F5 ON ride (reservation_ride_id)');
    }
}
