<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219182326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conexiones (idConexion INT AUTO_INCREMENT NOT NULL, inicio DATETIME NOT NULL, fin DATETIME DEFAULT NULL, status TINYINT(1) NOT NULL, idUser INT NOT NULL, idIp INT NOT NULL, INDEX IDX_C5B66C30FE6E88D7 (idUser), INDEX IDX_C5B66C30590A8119 (idIp), PRIMARY KEY(idConexion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ips (id INT AUTO_INCREMENT NOT NULL, direccion VARCHAR(15) NOT NULL, status TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_5E7470CDF384BE95 (direccion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (idRol INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, status TINYINT(1) DEFAULT 0 NOT NULL, admin TINYINT(1) DEFAULT 0 NOT NULL, usuario TINYINT(1) DEFAULT 0 NOT NULL, invitado TINYINT(1) DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_B63E2EC73A909126 (nombre), PRIMARY KEY(idRol)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (idUser INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, primerapellido VARCHAR(100) NOT NULL, segundoapellido VARCHAR(100) DEFAULT NULL, username VARCHAR(50) NOT NULL, sexo TINYINT(1) NOT NULL, altura INT DEFAULT NULL, peso NUMERIC(6, 2) DEFAULT NULL, fecha_nacimiento DATETIME DEFAULT NULL, alta DATETIME NOT NULL, idRol INT NOT NULL, UNIQUE INDEX UNIQ_2265B05DF85E0677 (username), INDEX IDX_2265B05D2F1D22B0 (idRol), PRIMARY KEY(idUser)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conexiones ADD CONSTRAINT FK_C5B66C30FE6E88D7 FOREIGN KEY (idUser) REFERENCES usuario (idUser)');
        $this->addSql('ALTER TABLE conexiones ADD CONSTRAINT FK_C5B66C30590A8119 FOREIGN KEY (idIp) REFERENCES ips (id)');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D2F1D22B0 FOREIGN KEY (idRol) REFERENCES roles (idRol)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conexiones DROP FOREIGN KEY FK_C5B66C30FE6E88D7');
        $this->addSql('ALTER TABLE conexiones DROP FOREIGN KEY FK_C5B66C30590A8119');
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D2F1D22B0');
        $this->addSql('DROP TABLE conexiones');
        $this->addSql('DROP TABLE ips');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE usuario');
    }
}
