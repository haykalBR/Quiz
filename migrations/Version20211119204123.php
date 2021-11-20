<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119204123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, public TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, path LONGTEXT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_3AF34668989D9B62 (slug), INDEX IDX_3AF34668727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exam (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, duration INT NOT NULL, passing_percentage INT NOT NULL, nb_questions INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE login_attempt (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8C11C1BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permissions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, guard_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permissions_roles (permissions_id INT NOT NULL, roles_id INT NOT NULL, INDEX IDX_FDC136589C3E4F87 (permissions_id), INDEX IDX_FDC1365838C751C4 (roles_id), PRIMARY KEY(permissions_id, roles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permissions_user (permissions_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_765F0E6C9C3E4F87 (permissions_id), INDEX IDX_765F0E6CA76ED395 (user_id), PRIMARY KEY(permissions_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, path LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ref_question_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, enabled TINYINT(1) DEFAULT \'1\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, is_correct TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, guard_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score (id INT AUTO_INCREMENT NOT NULL, correct_count INT NOT NULL, wrong_count INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, the_key VARCHAR(100) NOT NULL, the_value LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, auth_code VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE login_attempt ADD CONSTRAINT FK_8C11C1BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE permissions_roles ADD CONSTRAINT FK_FDC136589C3E4F87 FOREIGN KEY (permissions_id) REFERENCES permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permissions_roles ADD CONSTRAINT FK_FDC1365838C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permissions_user ADD CONSTRAINT FK_765F0E6C9C3E4F87 FOREIGN KEY (permissions_id) REFERENCES permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permissions_user ADD CONSTRAINT FK_765F0E6CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668727ACA70');
        $this->addSql('ALTER TABLE permissions_roles DROP FOREIGN KEY FK_FDC136589C3E4F87');
        $this->addSql('ALTER TABLE permissions_user DROP FOREIGN KEY FK_765F0E6C9C3E4F87');
        $this->addSql('ALTER TABLE permissions_roles DROP FOREIGN KEY FK_FDC1365838C751C4');
        $this->addSql('ALTER TABLE login_attempt DROP FOREIGN KEY FK_8C11C1BA76ED395');
        $this->addSql('ALTER TABLE permissions_user DROP FOREIGN KEY FK_765F0E6CA76ED395');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE exam');
        $this->addSql('DROP TABLE login_attempt');
        $this->addSql('DROP TABLE permissions');
        $this->addSql('DROP TABLE permissions_roles');
        $this->addSql('DROP TABLE permissions_user');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE ref_question_type');
        $this->addSql('DROP TABLE reponses');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE user');
    }
}
