<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310094001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role_user_team (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_team ADD role_user_team_id INT NOT NULL, DROP user_role');
        $this->addSql('ALTER TABLE user_team ADD CONSTRAINT FK_BE61EAD6E537AA78 FOREIGN KEY (role_user_team_id) REFERENCES role_user_team (id)');
        $this->addSql('CREATE INDEX IDX_BE61EAD6E537AA78 ON user_team (role_user_team_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_team DROP FOREIGN KEY FK_BE61EAD6E537AA78');
        $this->addSql('DROP TABLE role_user_team');
        $this->addSql('DROP INDEX IDX_BE61EAD6E537AA78 ON user_team');
        $this->addSql('ALTER TABLE user_team ADD user_role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP role_user_team_id');
    }
}
