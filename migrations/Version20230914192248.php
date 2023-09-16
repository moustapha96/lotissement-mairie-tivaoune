<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914192248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `lotissements_activity_notifications` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, date_operation DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_2A6B9499A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_configurations` (id INT AUTO_INCREMENT NOT NULL, valeur LONGTEXT DEFAULT NULL, cle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_demandes` (id INT AUTO_INCREMENT NOT NULL, demandeur_id INT DEFAULT NULL, lotissement_id INT DEFAULT NULL, statut_id INT DEFAULT NULL, numero VARCHAR(255) NOT NULL, date_demande DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', demande_adresse_maire LONGTEXT DEFAULT NULL, cni LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_B7AA5EF8F55AE19E (numero), INDEX IDX_B7AA5EF895A6EE59 (demandeur_id), INDEX IDX_B7AA5EF8F79944C3 (lotissement_id), INDEX IDX_B7AA5EF8F6203804 (statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_demandeurs` (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, statut_id INT DEFAULT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(13) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, nin VARCHAR(13) NOT NULL, adresse_residentielle VARCHAR(255) NOT NULL, civilite VARCHAR(255) NOT NULL, situation_matrimoniale VARCHAR(255) NOT NULL, nationalite VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C1E7F553E7927C74 (email), UNIQUE INDEX UNIQ_C1E7F553F2C56620 (compte_id), INDEX IDX_C1E7F553F6203804 (statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_departements` (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, zone_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_88FD76DC98260155 (region_id), INDEX IDX_88FD76DC9F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_dimensions` (id INT AUTO_INCREMENT NOT NULL, longueur DOUBLE PRECISION NOT NULL, largeur DOUBLE PRECISION NOT NULL, superficie DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_localites` (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, denomination VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_5B2E2DDB15AEA10C (denomination), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_lotissements` (id INT AUTO_INCREMENT NOT NULL, localite_id INT DEFAULT NULL, denomination VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, numero VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D76064D4F55AE19E (numero), INDEX IDX_D76064D4924DD2B5 (localite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lotissements_lotissement_plans (lotissement_id INT NOT NULL, plan_id INT NOT NULL, INDEX IDX_B967CA9F79944C3 (lotissement_id), INDEX IDX_B967CA9E899029B (plan_id), PRIMARY KEY(lotissement_id, plan_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_operations` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, demande_id INT DEFAULT NULL, operation VARCHAR(255) NOT NULL, date_operation DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_76257568A76ED395 (user_id), INDEX IDX_7625756880E95E18 (demande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_parametrages` (id INT AUTO_INCREMENT NOT NULL, logo LONGTEXT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_parcelles` (id INT AUTO_INCREMENT NOT NULL, lotissement_id INT DEFAULT NULL, dimension_id INT DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A0CAD876F55AE19E (numero), INDEX IDX_A0CAD876F79944C3 (lotissement_id), INDEX IDX_A0CAD876277428AD (dimension_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_pays` (id INT AUTO_INCREMENT NOT NULL, nom_pays VARCHAR(255) NOT NULL, indicatif VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_plans` (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, statut TINYINT(1) DEFAULT NULL, fichier LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_regions` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_sms` (id INT AUTO_INCREMENT NOT NULL, receiver VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_statuts_demandeurs` (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) NOT NULL, status TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_statuts_lotissements` (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) DEFAULT NULL, status TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_table_counters` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_users` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT NULL, phone VARCHAR(10) NOT NULL, status VARCHAR(255) NOT NULL, last_activity_at DATETIME DEFAULT NULL, is_active_now TINYINT(1) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, avatar LONGTEXT DEFAULT NULL, pass VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D558D925E7927C74 (email), UNIQUE INDEX UNIQ_D558D925444F97DD (phone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `lotissements_zones` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `men_colleges` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `men_rapports` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, college_id INT DEFAULT NULL, activite LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, resultat LONGTEXT DEFAULT NULL, activite_fichier LONGTEXT DEFAULT NULL, description_fichier LONGTEXT DEFAULT NULL, resultat_fichier LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_945D03AA76ED395 (user_id), INDEX IDX_945D03A770124B2 (college_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `simlait_models_sms` (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, parametre LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `lotissements_activity_notifications` ADD CONSTRAINT FK_2A6B9499A76ED395 FOREIGN KEY (user_id) REFERENCES `lotissements_users` (id)');
        $this->addSql('ALTER TABLE `lotissements_demandes` ADD CONSTRAINT FK_B7AA5EF895A6EE59 FOREIGN KEY (demandeur_id) REFERENCES `lotissements_demandeurs` (id)');
        $this->addSql('ALTER TABLE `lotissements_demandes` ADD CONSTRAINT FK_B7AA5EF8F79944C3 FOREIGN KEY (lotissement_id) REFERENCES `lotissements_lotissements` (id)');
        $this->addSql('ALTER TABLE `lotissements_demandes` ADD CONSTRAINT FK_B7AA5EF8F6203804 FOREIGN KEY (statut_id) REFERENCES `lotissements_statuts_lotissements` (id)');
        $this->addSql('ALTER TABLE `lotissements_demandeurs` ADD CONSTRAINT FK_C1E7F553F2C56620 FOREIGN KEY (compte_id) REFERENCES `lotissements_users` (id)');
        $this->addSql('ALTER TABLE `lotissements_demandeurs` ADD CONSTRAINT FK_C1E7F553F6203804 FOREIGN KEY (statut_id) REFERENCES `lotissements_statuts_demandeurs` (id)');
        $this->addSql('ALTER TABLE `lotissements_departements` ADD CONSTRAINT FK_88FD76DC98260155 FOREIGN KEY (region_id) REFERENCES `lotissements_regions` (id)');
        $this->addSql('ALTER TABLE `lotissements_departements` ADD CONSTRAINT FK_88FD76DC9F2C3FAB FOREIGN KEY (zone_id) REFERENCES `lotissements_zones` (id)');
        $this->addSql('ALTER TABLE `lotissements_lotissements` ADD CONSTRAINT FK_D76064D4924DD2B5 FOREIGN KEY (localite_id) REFERENCES `lotissements_localites` (id)');
        $this->addSql('ALTER TABLE lotissements_lotissement_plans ADD CONSTRAINT FK_B967CA9F79944C3 FOREIGN KEY (lotissement_id) REFERENCES `lotissements_lotissements` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lotissements_lotissement_plans ADD CONSTRAINT FK_B967CA9E899029B FOREIGN KEY (plan_id) REFERENCES `lotissements_plans` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `lotissements_operations` ADD CONSTRAINT FK_76257568A76ED395 FOREIGN KEY (user_id) REFERENCES `lotissements_users` (id)');
        $this->addSql('ALTER TABLE `lotissements_operations` ADD CONSTRAINT FK_7625756880E95E18 FOREIGN KEY (demande_id) REFERENCES `lotissements_demandes` (id)');
        $this->addSql('ALTER TABLE `lotissements_parcelles` ADD CONSTRAINT FK_A0CAD876F79944C3 FOREIGN KEY (lotissement_id) REFERENCES `lotissements_lotissements` (id)');
        $this->addSql('ALTER TABLE `lotissements_parcelles` ADD CONSTRAINT FK_A0CAD876277428AD FOREIGN KEY (dimension_id) REFERENCES `lotissements_dimensions` (id)');
        $this->addSql('ALTER TABLE `men_rapports` ADD CONSTRAINT FK_945D03AA76ED395 FOREIGN KEY (user_id) REFERENCES `lotissements_users` (id)');
        $this->addSql('ALTER TABLE `men_rapports` ADD CONSTRAINT FK_945D03A770124B2 FOREIGN KEY (college_id) REFERENCES `men_colleges` (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `lotissements_users` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `lotissements_activity_notifications` DROP FOREIGN KEY FK_2A6B9499A76ED395');
        $this->addSql('ALTER TABLE `lotissements_demandes` DROP FOREIGN KEY FK_B7AA5EF895A6EE59');
        $this->addSql('ALTER TABLE `lotissements_demandes` DROP FOREIGN KEY FK_B7AA5EF8F79944C3');
        $this->addSql('ALTER TABLE `lotissements_demandes` DROP FOREIGN KEY FK_B7AA5EF8F6203804');
        $this->addSql('ALTER TABLE `lotissements_demandeurs` DROP FOREIGN KEY FK_C1E7F553F2C56620');
        $this->addSql('ALTER TABLE `lotissements_demandeurs` DROP FOREIGN KEY FK_C1E7F553F6203804');
        $this->addSql('ALTER TABLE `lotissements_departements` DROP FOREIGN KEY FK_88FD76DC98260155');
        $this->addSql('ALTER TABLE `lotissements_departements` DROP FOREIGN KEY FK_88FD76DC9F2C3FAB');
        $this->addSql('ALTER TABLE `lotissements_lotissements` DROP FOREIGN KEY FK_D76064D4924DD2B5');
        $this->addSql('ALTER TABLE lotissements_lotissement_plans DROP FOREIGN KEY FK_B967CA9F79944C3');
        $this->addSql('ALTER TABLE lotissements_lotissement_plans DROP FOREIGN KEY FK_B967CA9E899029B');
        $this->addSql('ALTER TABLE `lotissements_operations` DROP FOREIGN KEY FK_76257568A76ED395');
        $this->addSql('ALTER TABLE `lotissements_operations` DROP FOREIGN KEY FK_7625756880E95E18');
        $this->addSql('ALTER TABLE `lotissements_parcelles` DROP FOREIGN KEY FK_A0CAD876F79944C3');
        $this->addSql('ALTER TABLE `lotissements_parcelles` DROP FOREIGN KEY FK_A0CAD876277428AD');
        $this->addSql('ALTER TABLE `men_rapports` DROP FOREIGN KEY FK_945D03AA76ED395');
        $this->addSql('ALTER TABLE `men_rapports` DROP FOREIGN KEY FK_945D03A770124B2');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE `lotissements_activity_notifications`');
        $this->addSql('DROP TABLE `lotissements_configurations`');
        $this->addSql('DROP TABLE `lotissements_demandes`');
        $this->addSql('DROP TABLE `lotissements_demandeurs`');
        $this->addSql('DROP TABLE `lotissements_departements`');
        $this->addSql('DROP TABLE `lotissements_dimensions`');
        $this->addSql('DROP TABLE `lotissements_localites`');
        $this->addSql('DROP TABLE `lotissements_lotissements`');
        $this->addSql('DROP TABLE lotissements_lotissement_plans');
        $this->addSql('DROP TABLE `lotissements_operations`');
        $this->addSql('DROP TABLE `lotissements_parametrages`');
        $this->addSql('DROP TABLE `lotissements_parcelles`');
        $this->addSql('DROP TABLE `lotissements_pays`');
        $this->addSql('DROP TABLE `lotissements_plans`');
        $this->addSql('DROP TABLE `lotissements_regions`');
        $this->addSql('DROP TABLE `lotissements_sms`');
        $this->addSql('DROP TABLE `lotissements_statuts_demandeurs`');
        $this->addSql('DROP TABLE `lotissements_statuts_lotissements`');
        $this->addSql('DROP TABLE `lotissements_table_counters`');
        $this->addSql('DROP TABLE `lotissements_users`');
        $this->addSql('DROP TABLE `lotissements_zones`');
        $this->addSql('DROP TABLE `men_colleges`');
        $this->addSql('DROP TABLE `men_rapports`');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE `simlait_models_sms`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
