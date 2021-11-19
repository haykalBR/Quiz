<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119142612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE permissions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, guard_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permissions_roles (permissions_id INT NOT NULL, roles_id INT NOT NULL, INDEX IDX_FDC136589C3E4F87 (permissions_id), INDEX IDX_FDC1365838C751C4 (roles_id), PRIMARY KEY(permissions_id, roles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permissions_user (permissions_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_765F0E6C9C3E4F87 (permissions_id), INDEX IDX_765F0E6CA76ED395 (user_id), PRIMARY KEY(permissions_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, guard_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE permissions_roles ADD CONSTRAINT FK_FDC136589C3E4F87 FOREIGN KEY (permissions_id) REFERENCES permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permissions_roles ADD CONSTRAINT FK_FDC1365838C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permissions_user ADD CONSTRAINT FK_765F0E6C9C3E4F87 FOREIGN KEY (permissions_id) REFERENCES permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permissions_user ADD CONSTRAINT FK_765F0E6CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions_roles DROP FOREIGN KEY FK_FDC136589C3E4F87');
        $this->addSql('ALTER TABLE permissions_user DROP FOREIGN KEY FK_765F0E6C9C3E4F87');
        $this->addSql('ALTER TABLE permissions_roles DROP FOREIGN KEY FK_FDC1365838C751C4');
        $this->addSql('DROP TABLE permissions');
        $this->addSql('DROP TABLE permissions_roles');
        $this->addSql('DROP TABLE permissions_user');
        $this->addSql('DROP TABLE roles');
    }
}
