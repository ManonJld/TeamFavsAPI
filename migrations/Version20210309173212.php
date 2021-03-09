<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309173212 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bookmark DROP FOREIGN KEY FK_DA62921DB03A8386');
        $this->addSql('DROP INDEX IDX_DA62921DB03A8386 ON bookmark');
        $this->addSql('ALTER TABLE bookmark CHANGE created_by_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE bookmark ADD CONSTRAINT FK_DA62921DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DA62921DA76ED395 ON bookmark (user_id)');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1B03A8386');
        $this->addSql('DROP INDEX IDX_64C19C1B03A8386 ON category');
        $this->addSql('ALTER TABLE category CHANGE created_by_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1A76ED395 ON category (user_id)');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FB03A8386');
        $this->addSql('DROP INDEX IDX_C4E0A61FB03A8386 ON team');
        $this->addSql('ALTER TABLE team CHANGE created_by_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61FA76ED395 ON team (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bookmark DROP FOREIGN KEY FK_DA62921DA76ED395');
        $this->addSql('DROP INDEX IDX_DA62921DA76ED395 ON bookmark');
        $this->addSql('ALTER TABLE bookmark CHANGE user_id created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE bookmark ADD CONSTRAINT FK_DA62921DB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DA62921DB03A8386 ON bookmark (created_by_id)');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1A76ED395');
        $this->addSql('DROP INDEX IDX_64C19C1A76ED395 ON category');
        $this->addSql('ALTER TABLE category CHANGE user_id created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1B03A8386 ON category (created_by_id)');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FA76ED395');
        $this->addSql('DROP INDEX IDX_C4E0A61FA76ED395 ON team');
        $this->addSql('ALTER TABLE team CHANGE user_id created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61FB03A8386 ON team (created_by_id)');
    }
}
