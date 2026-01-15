/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.1.2-MariaDB, for osx10.20 (arm64)
--
-- Host: localhost    Database: SAE_S3
-- ------------------------------------------------------
-- Server version	9.5.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `actualite`
--

DROP TABLE IF EXISTS `actualite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `actualite` (
  `idActu` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_publication` datetime DEFAULT NULL,
  `statut` enum('brouillon','publie','archive') NOT NULL DEFAULT 'brouillon',
  PRIMARY KEY (`idActu`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actualite`
--

LOCK TABLES `actualite` WRITE;
/*!40000 ALTER TABLE `actualite` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `actualite` VALUES
(1,'Lancement du site officiel','Nous sommes heureux d’annoncer le lancement officiel de notre site.','2024-01-05 10:00:00','2024-01-06 09:00:00','publie'),
(2,'Nouvelle mission solidaire','Une nouvelle mission solidaire démarre ce mois-ci.','2024-01-08 14:00:00','2024-01-09 08:30:00','publie'),
(3,'Appel aux bénévoles','Nous recherchons des bénévoles motivés pour nos actions.','2024-01-10 11:20:00','2024-01-11 09:00:00','publie'),
(4,'Compte rendu réunion janvier','Retour sur la réunion mensuelle de janvier.','2024-01-12 16:00:00',NULL,'brouillon'),
(5,'Nouvelle convention signée','Signature d’une nouvelle convention avec un partenaire.','2024-01-15 09:45:00','2024-01-16 10:00:00','publie'),
(6,'Formation des bénévoles','Une formation est organisée pour les nouveaux bénévoles.','2024-01-18 13:00:00','2024-01-19 09:00:00','publie'),
(7,'Galerie photos mise à jour','De nouvelles photos ont été ajoutées à la galerie.','2024-01-20 15:30:00','2024-01-21 10:00:00','publie'),
(8,'Rapport annuel en préparation','Le rapport annuel est en cours de rédaction.','2024-01-22 10:10:00',NULL,'brouillon'),
(9,'Événement caritatif à venir','Un événement caritatif aura lieu prochainement.','2024-01-25 14:00:00','2024-01-26 09:00:00','publie'),
(10,'Mise à jour des missions','Les missions ont été mises à jour dans le système.','2024-01-27 11:45:00','2024-01-28 08:00:00','publie'),
(11,'Newsletter février','La newsletter de février est prête.','2024-02-01 09:00:00','2024-02-01 12:00:00','publie'),
(12,'Retour événement janvier','Retour sur l’événement du mois dernier.','2024-02-03 10:30:00','2024-02-04 09:00:00','publie'),
(13,'Appel aux dons','Un appel aux dons est lancé pour soutenir nos actions.','2024-02-05 14:00:00','2024-02-06 08:30:00','publie'),
(14,'Planning mars','Le planning des activités de mars est disponible.','2024-02-07 16:00:00',NULL,'brouillon'),
(15,'Nouveau partenaire','Un nouveau partenaire rejoint l’association.','2024-02-10 11:00:00','2024-02-11 09:00:00','publie'),
(16,'Mise à jour sécurité','Amélioration de la sécurité du système.','2024-02-12 09:30:00','2024-02-13 10:00:00','publie'),
(17,'Réunion d’équipe','Une réunion d’équipe est prévue cette semaine.','2024-02-14 14:30:00',NULL,'brouillon'),
(18,'Résultats de la collecte','Résultats positifs de la collecte de fonds.','2024-02-15 10:15:00','2024-02-16 09:00:00','publie'),
(19,'Focus bénévole','Portrait d’un bénévole engagé.','2024-02-18 13:00:00','2024-02-19 08:30:00','publie'),
(20,'Archivage documents 2024','Les documents de 2023 ont été archivés.','2024-02-20 16:00:00','2024-02-28 00:00:00','archive');
/*!40000 ALTER TABLE `actualite` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `actualite_media`
--

DROP TABLE IF EXISTS `actualite_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `actualite_media` (
  `idActu` int NOT NULL,
  `idMedia` int NOT NULL,
  PRIMARY KEY (`idActu`,`idMedia`),
  KEY `fk_actu_media_media` (`idMedia`),
  CONSTRAINT `fk_actu_media_actu` FOREIGN KEY (`idActu`) REFERENCES `actualite` (`idActu`) ON DELETE CASCADE,
  CONSTRAINT `fk_actu_media_media` FOREIGN KEY (`idMedia`) REFERENCES `media` (`idMedia`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actualite_media`
--

LOCK TABLES `actualite_media` WRITE;
/*!40000 ALTER TABLE `actualite_media` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `actualite_media` VALUES
(1,1),
(11,1),
(1,2),
(12,2),
(1,3),
(13,3),
(1,4),
(14,4),
(1,5),
(15,5),
(2,6),
(11,6),
(2,7),
(12,7),
(2,8),
(13,8),
(2,9),
(14,9),
(2,10),
(15,10),
(3,11),
(11,11),
(3,12),
(12,12),
(3,13),
(13,13),
(3,14),
(14,14),
(3,15),
(15,15),
(4,16),
(11,16),
(4,17),
(12,17),
(4,18),
(13,18),
(4,19),
(14,19),
(4,20),
(15,20),
(5,21),
(11,21),
(5,22),
(12,22),
(5,23),
(13,23),
(5,24),
(14,24),
(5,25),
(15,25),
(6,26),
(16,26),
(6,27),
(17,27),
(6,28),
(18,28),
(6,29),
(19,29),
(6,30),
(20,30),
(7,31),
(16,31),
(7,32),
(17,32),
(7,33),
(18,33),
(7,34),
(19,34),
(7,35),
(20,35),
(8,36),
(16,36),
(8,37),
(17,37),
(8,38),
(18,38),
(8,39),
(19,39),
(8,40),
(20,40),
(9,41),
(16,41),
(9,42),
(17,42),
(9,43),
(18,43),
(9,44),
(19,44),
(9,45),
(20,45),
(10,46),
(16,46),
(10,47),
(17,47),
(10,48),
(18,48),
(10,49),
(19,49),
(10,50),
(20,50);
/*!40000 ALTER TABLE `actualite_media` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `AFFECTE_A_MISSION`
--

DROP TABLE IF EXISTS `AFFECTE_A_MISSION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `AFFECTE_A_MISSION` (
  `idPersonne` int NOT NULL,
  `idMission` int NOT NULL,
  `date_affectation` date NOT NULL,
  `statut` varchar(50) NOT NULL,
  PRIMARY KEY (`idPersonne`,`idMission`),
  KEY `idMission` (`idMission`),
  CONSTRAINT `affecte_a_mission_ibfk_2` FOREIGN KEY (`idMission`) REFERENCES `MISSION` (`idMission`),
  CONSTRAINT `fk_affecte_benevole` FOREIGN KEY (`idPersonne`) REFERENCES `BENEVOLE` (`idPersonne`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AFFECTE_A_MISSION`
--

LOCK TABLES `AFFECTE_A_MISSION` WRITE;
/*!40000 ALTER TABLE `AFFECTE_A_MISSION` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `AFFECTE_A_MISSION` VALUES
(1,32,'2025-01-05','en cours'),
(1,33,'2025-02-04','en cours'),
(2,33,'2025-01-06','terminé'),
(2,34,'2025-02-05','terminé'),
(3,34,'2025-01-07','en cours'),
(3,35,'2025-02-06','en cours'),
(4,35,'2025-01-08','annulé'),
(4,36,'2025-02-07','annulé'),
(5,36,'2025-01-09','en cours'),
(5,37,'2025-02-08','en cours'),
(6,37,'2025-01-10','terminé'),
(6,38,'2025-02-09','terminé'),
(7,38,'2025-01-11','en cours'),
(7,39,'2025-02-10','en cours'),
(8,39,'2025-01-12','annulé'),
(8,40,'2025-02-11','annulé'),
(9,40,'2025-01-13','en cours'),
(9,41,'2025-02-12','en cours'),
(10,41,'2025-01-14','terminé'),
(10,42,'2025-02-13','terminé'),
(11,42,'2025-01-15','en cours'),
(11,43,'2025-02-14','en cours'),
(12,43,'2025-01-16','annulé'),
(12,44,'2025-02-15','annulé'),
(13,44,'2025-01-17','terminé'),
(13,45,'2025-02-16','terminé'),
(14,45,'2025-01-18','en cours'),
(14,46,'2025-02-17','en cours'),
(15,46,'2025-01-19','terminé'),
(15,47,'2025-02-18','terminé'),
(16,47,'2025-01-20','en cours'),
(16,48,'2025-02-19','en cours'),
(17,48,'2025-01-21','annulé'),
(17,49,'2025-02-20','annulé'),
(18,49,'2025-01-22','en cours'),
(18,50,'2025-02-21','en cours'),
(19,50,'2025-01-23','terminé'),
(19,51,'2025-02-22','terminé'),
(20,51,'2025-01-24','en cours'),
(20,52,'2025-02-23','en cours'),
(22,53,'2025-01-26','en cours'),
(22,54,'2025-02-25','en cours'),
(23,54,'2025-01-27','terminé'),
(23,55,'2025-02-26','terminé'),
(24,55,'2025-01-28','en cours'),
(24,56,'2025-02-27','en cours'),
(25,56,'2025-01-29','annulé'),
(25,57,'2025-02-28','annulé'),
(26,57,'2025-01-30','terminé'),
(26,58,'2025-03-01','terminé'),
(27,58,'2025-01-31','en cours'),
(27,59,'2025-03-02','en cours'),
(28,59,'2025-02-01','terminé'),
(28,60,'2025-03-03','terminé'),
(29,60,'2025-02-02','en cours'),
(29,61,'2025-03-04','en cours'),
(30,32,'2025-03-05','annulé'),
(30,61,'2025-02-03','annulé');
/*!40000 ALTER TABLE `AFFECTE_A_MISSION` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `APPORTE_SOUTIEN`
--

DROP TABLE IF EXISTS `APPORTE_SOUTIEN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `APPORTE_SOUTIEN` (
  `idPart` int NOT NULL,
  `idSoutien` int NOT NULL,
  `montant_soutien` decimal(10,2) NOT NULL,
  `date_debut_soutien` date NOT NULL,
  `date_fin_soutien` date NOT NULL,
  PRIMARY KEY (`idPart`,`idSoutien`),
  KEY `idSoutien` (`idSoutien`),
  CONSTRAINT `apporte_soutien_ibfk_1` FOREIGN KEY (`idPart`) REFERENCES `PARTENAIRE` (`idPart`),
  CONSTRAINT `apporte_soutien_ibfk_2` FOREIGN KEY (`idSoutien`) REFERENCES `SOUTIEN` (`idSoutien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `APPORTE_SOUTIEN`
--

LOCK TABLES `APPORTE_SOUTIEN` WRITE;
/*!40000 ALTER TABLE `APPORTE_SOUTIEN` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `APPORTE_SOUTIEN` VALUES
(1,1,500.00,'2025-01-01','2025-01-31'),
(1,11,800.00,'2025-06-09','2025-07-09'),
(1,31,750.00,'2025-03-25','2025-04-24'),
(1,41,800.00,'2025-09-07','2025-10-06'),
(2,2,750.00,'2025-01-05','2025-02-04'),
(2,12,900.00,'2025-06-12','2025-07-12'),
(2,32,900.00,'2025-03-28','2025-04-27'),
(2,42,900.00,'2025-09-10','2025-10-09'),
(3,3,1200.50,'2025-01-10','2025-02-09'),
(3,13,1000.00,'2025-06-15','2025-07-15'),
(3,33,1100.00,'2025-03-30','2025-04-29'),
(3,43,1000.00,'2025-09-13','2025-10-12'),
(4,4,300.00,'2025-01-12','2025-02-11'),
(4,14,1100.00,'2025-06-18','2025-07-18'),
(4,34,500.00,'2025-04-01','2025-05-01'),
(4,44,1100.00,'2025-09-16','2025-10-15'),
(5,5,950.75,'2025-01-15','2025-02-14'),
(5,15,1200.00,'2025-06-21','2025-07-21'),
(5,35,800.00,'2025-04-03','2025-05-03'),
(5,45,1200.00,'2025-09-19','2025-10-18'),
(6,6,1500.00,'2025-01-18','2025-02-17'),
(6,16,1300.00,'2025-06-24','2025-07-24'),
(6,36,950.00,'2025-04-06','2025-05-06'),
(6,46,1300.00,'2025-09-22','2025-10-21'),
(7,7,2200.25,'2025-01-20','2025-02-19'),
(7,17,1400.00,'2025-06-27','2025-07-27'),
(7,37,1200.00,'2025-04-08','2025-05-08'),
(7,47,1400.00,'2025-09-25','2025-10-24'),
(8,8,800.00,'2025-01-22','2025-02-21'),
(8,18,500.00,'2025-06-30','2025-07-30'),
(8,38,1300.00,'2025-04-10','2025-05-10'),
(8,48,500.00,'2025-09-28','2025-10-27'),
(9,9,450.50,'2025-01-25','2025-02-24'),
(9,19,600.00,'2025-07-03','2025-08-02'),
(9,39,1400.00,'2025-04-12','2025-05-12'),
(9,49,600.00,'2025-10-01','2025-10-30'),
(10,10,1000.00,'2025-01-28','2025-02-27'),
(10,20,700.00,'2025-07-06','2025-08-05'),
(10,40,600.00,'2025-04-15','2025-05-15'),
(10,50,700.00,'2025-10-04','2025-11-02'),
(11,11,650.00,'2025-02-01','2025-03-03'),
(11,21,800.00,'2025-07-09','2025-08-08'),
(11,41,500.00,'2025-04-17','2025-05-17'),
(12,12,900.00,'2025-02-03','2025-03-05'),
(12,22,900.00,'2025-07-12','2025-08-11'),
(12,42,750.00,'2025-04-19','2025-05-19'),
(13,13,1100.00,'2025-02-06','2025-03-07'),
(13,23,1000.00,'2025-07-15','2025-08-14'),
(13,43,900.00,'2025-04-22','2025-05-22'),
(14,14,1300.00,'2025-02-08','2025-03-09'),
(14,24,1100.00,'2025-07-18','2025-08-17'),
(14,44,1100.00,'2025-04-25','2025-05-25'),
(15,15,700.00,'2025-02-11','2025-03-12'),
(15,25,1200.00,'2025-07-21','2025-08-20'),
(15,45,1200.00,'2025-04-27','2025-05-27'),
(16,16,1400.00,'2025-02-14','2025-03-15'),
(16,26,1300.00,'2025-07-24','2025-08-23'),
(16,46,1300.00,'2025-04-30','2025-05-30'),
(17,17,500.00,'2025-02-17','2025-03-18'),
(17,27,1400.00,'2025-07-27','2025-08-26'),
(17,47,1400.00,'2025-05-02','2025-06-01'),
(18,18,1200.00,'2025-02-20','2025-03-21'),
(18,28,500.00,'2025-07-30','2025-08-29'),
(18,48,500.00,'2025-05-05','2025-06-04'),
(19,19,600.00,'2025-02-22','2025-03-25'),
(19,29,600.00,'2025-08-02','2025-08-31'),
(19,49,600.00,'2025-05-07','2025-06-06'),
(20,20,950.00,'2025-02-25','2025-03-28'),
(20,30,700.00,'2025-08-05','2025-09-03'),
(20,50,700.00,'2025-05-10','2025-06-09'),
(21,1,800.00,'2025-05-12','2025-06-11'),
(21,21,1000.00,'2025-03-01','2025-03-31'),
(21,31,800.00,'2025-08-08','2025-09-06'),
(22,2,900.00,'2025-05-15','2025-06-14'),
(22,22,1100.00,'2025-03-03','2025-04-02'),
(22,32,900.00,'2025-08-11','2025-09-09'),
(23,3,1000.00,'2025-05-18','2025-06-17'),
(23,23,750.00,'2025-03-05','2025-04-04'),
(23,33,1000.00,'2025-08-14','2025-09-12'),
(24,4,1100.00,'2025-05-20','2025-06-19'),
(24,24,800.00,'2025-03-07','2025-04-06'),
(24,34,1100.00,'2025-08-17','2025-09-15'),
(25,5,1200.00,'2025-05-23','2025-06-22'),
(25,25,950.00,'2025-03-10','2025-04-09'),
(25,35,1200.00,'2025-08-20','2025-09-18'),
(26,6,1300.00,'2025-05-26','2025-06-25'),
(26,26,1200.00,'2025-03-12','2025-04-11'),
(26,36,1300.00,'2025-08-23','2025-09-21'),
(27,7,1400.00,'2025-05-29','2025-06-28'),
(27,27,1300.00,'2025-03-15','2025-04-14'),
(27,37,1400.00,'2025-08-26','2025-09-24'),
(28,8,500.00,'2025-06-01','2025-06-30'),
(28,28,600.00,'2025-03-18','2025-04-17'),
(28,38,500.00,'2025-08-29','2025-09-27'),
(29,9,600.00,'2025-06-03','2025-07-03'),
(29,29,500.00,'2025-03-20','2025-04-19'),
(29,39,600.00,'2025-09-01','2025-09-30'),
(30,10,700.00,'2025-06-06','2025-07-06'),
(30,30,1400.00,'2025-03-22','2025-04-21'),
(30,40,700.00,'2025-09-04','2025-10-03');
/*!40000 ALTER TABLE `APPORTE_SOUTIEN` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `benevole`
--

DROP TABLE IF EXISTS `benevole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `benevole` (
  `idPersonne` int NOT NULL,
  `regime_alimentaire` varchar(100) DEFAULT NULL,
  `limitation_physique` varchar(100) DEFAULT NULL,
  `date_adhesion` date NOT NULL,
  `statut_actif` tinyint(1) NOT NULL,
  `disponibilite` varchar(255) DEFAULT NULL,
  `Competence` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idPersonne`),
  CONSTRAINT `benevole_ibfk_1` FOREIGN KEY (`idPersonne`) REFERENCES `PERSONNE` (`idPersonne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `benevole`
--

LOCK TABLES `benevole` WRITE;
/*!40000 ALTER TABLE `benevole` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `benevole` VALUES
(1,'Végétarien','Aucune','2023-01-15',1,'mercredi_apres_midi','Informatique'),
(2,'Vegan','Aucune','2023-02-20',1,'mercredi_apres_midi','Organisation'),
(3,'Sans gluten','Aucune','2023-03-10',1,'tous_jours','Informatique'),
(4,'Omnivore','Aucune','2023-04-05',1,'mardi_matin','Gestion'),
(5,'Végétarien','Problème de dos','2023-05-12',1,'mercredi_apres_midi','Animation'),
(6,'Vegan','Aucune','2023-06-18',1,'lundi_matin','Organisation'),
(7,'Omnivore','Aucune','2023-07-22',1,'mardi_apres_midi','Informatique'),
(8,'Végétarien','Problème de genou','2023-08-30',1,'weekend','Organisation'),
(9,'Sans gluten','Aucune','2023-09-15',1,'lundi_matin','Informatique'),
(10,'Omnivore','Aucune','2023-10-05',1,'jeudi_apres_midi','Organisation'),
(11,'Vegan','Problème de bras','2023-11-11',1,'jeudi_apres_midi','Organisation'),
(12,'Végétarien','Aucune','2023-12-02',1,'mardi_apres_midi','Animation'),
(13,'Omnivore','Aucune','2024-01-08',1,'mercredi_apres_midi','Communication'),
(14,'Végétarien','Aucune','2024-02-14',1,'jeudi_matin','Animation'),
(15,'Sans gluten','Problème de dos','2024-03-20',1,'jeudi_apres_midi','Communication'),
(16,'Omnivore','Aucune','2024-04-25',1,'jeudi_apres_midi','Animation'),
(17,'Vegan','Problème de genou','2024-05-30',1,'mardi_matin','Gestion'),
(18,'Végétarien','Aucune','2024-06-12',1,'mardi_apres_midi','Gestion'),
(19,'Omnivore','Aucune','2024-07-19',1,'jeudi_apres_midi','Informatique'),
(20,'Sans gluten','Aucune','2024-08-25',1,'tous_jours','Animation'),
(22,'Végétarien','Problème de bras','2024-10-05',0,'mardi_matin','Communication'),
(23,'Omnivore','Aucune','2024-11-18',1,'jeudi_apres_midi','Communication'),
(24,'Vegan','Aucune','2024-12-22',0,'mardi_matin','Animation'),
(25,'Sans gluten','Problème de dos','2025-01-15',0,'tous_jours','Gestion'),
(26,'Végétarien','Aucune','2025-02-20',0,'lundi_apres_midi','Organisation'),
(27,'Omnivore','Aucune','2025-03-10',1,'jeudi_matin','Gestion'),
(28,'Vegan','Problème de genou','2025-04-05',1,'tous_jours','Informatique'),
(29,'Végétarien','Aucune','2025-05-12',1,'tous_jours','Informatique'),
(30,'Omnivore','Aucune','2025-06-18',1,'mercredi_apres_midi','Organisation'),
(44,'Omnivore','dddd','2026-01-08',1,'ddd','ddd');
/*!40000 ALTER TABLE `benevole` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `COMPTE`
--

DROP TABLE IF EXISTS `COMPTE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `COMPTE` (
  `idCompte` int NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `mot_de_passe_hash` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `actif` tinyint(1) NOT NULL,
  `idPersonne` int DEFAULT NULL,
  PRIMARY KEY (`idCompte`),
  KEY `idPersonne` (`idPersonne`),
  CONSTRAINT `fk_compte` FOREIGN KEY (`idPersonne`) REFERENCES `PERSONNE` (`idPersonne`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COMPTE`
--

LOCK TABLES `COMPTE` WRITE;
/*!40000 ALTER TABLE `COMPTE` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `COMPTE` VALUES
(1,'user1','$2y$12$VhW9jHRfa9wApNUazevxyuj0watR1.ec31RkwoZTj/qxtHvLZuKRm','admin',1,1),
(2,'user2','$2y$12$aLm0XzWmRmLG4b9NBWasc.8.vJVxlVBq44hEwfkvW1KwYR0kC4JrO','bureau',1,2),
(3,'user3','$2y$12$DNDvUSWzTq96bLLHwSZ5oOo5NBmHNpbVsJv2x9a0vQVN0KMs7dLk6','bureau',1,3),
(4,'user4','$2y$12$tywxtEDcZlOcLJTL57Oh6.KaatTYRknBOBZ4H3yEGQsiE6Q7L4CHC','bureau',1,4),
(5,'user5','$2y$12$vBET4BAbN4ReOh2liBVCEeJI2DNbD8oco02eDMZMpPWCoR2o/dHmC','bureau',1,5),
(6,'user6','$2y$12$SK/Jklx2CbjjRjY3qKz1QuMRzHSqFmkmNaGkXJoVictx6Hjr8FAxe','bureau',1,6),
(7,'user7','$2y$12$hAJVXeXiVoiKfDv443moKesofjLNR30g8FnkXx0RtSZ.N3YIUQw/m','bureau',1,7),
(8,'user8','$2y$12$RNpNSZwR7mZH2UoN1XqtJOA3ULaRQga96uQQlFK4cX0ZEH703.qJu','bureau',1,8),
(9,'user9','$2y$12$TojcWfJ5gFsE37HukyPcUe7dVtKqOLmI2oywFc.EwTrSMicBKzMnu','bénévole',1,9),
(10,'user10','$2y$12$GOlsSuwg/L1aJt1YXpo5v.C.KGkndoig48nc27SfkEmGpO07KbYta','bénévole',1,10),
(11,'user11','$2y$12$Wcf16H1RApjiu4ADjffZj.FRwaSBuYCusoHu7ASbEnmEZtWdP5awe','bénévole',1,11),
(12,'user12','$2y$12$FkMrpJpLwhUqWJvrS982.e0L0lnfjY/72XA1o6/Qppvj4Tc7oSTY.','bénévole',1,12),
(13,'user13','$2y$12$2RgFPaAgqa2sbIEPN5PNr.zPS4KXC5HE/yndm.GXm9aOVusJ7p.PC','bénévole',1,13),
(14,'user14','$2y$12$fMe4qImaEU7I/c2RtX7tYuU9N6G4Amm0WTif8qNumXTLVRvz8Z14u','bénévole',1,14),
(15,'user15','$2y$12$iAqu7WNA0y4vkc.eL19SDOkntKwPVEOFbaKQGyDeE.3Qt9eneWzmu','bénévole',1,15),
(16,'user16','$2y$12$rVqewAIkGUUWKC3xrWw4/uefR.8VQ2LPFswE5Bf/M2ED44UqLlv9e','bénévole',1,16),
(17,'user17','$2y$12$G5gtdxzBb72xU93eKP6QNuvr77Niqc75S8OkOXt3r9IZ7JuTP6Dne','bénévole',1,17),
(18,'user18','$2y$12$7WleaokusR5tubeo2y7Dau9V/Xx01XHTuOPfMn3YZF4M1RPcLxcP.','bénévole',1,18),
(19,'user19','$2y$12$asbMkUOvYe/cptuJeVfxk.JpDhbBcHKFUM4FBIW/q0mZXfe/ObGAy','bénévole',1,19),
(20,'user20','$2y$12$f.dYjcoudB3etWKKSDxF0eN4uSWqYZIUgEDC97VODe72wzdVyzXzW','bénévole',1,20),
(22,'user22','$2y$12$vU6P.MJ2jvfBTiA/bvovtenpNTvojj7ujrYCXp.WsY7nBEP3gSAya','bénévole',1,22),
(23,'user23','$2y$12$.Dtp3V1vUmFSmQlTOCe3MuypvuM.XKzFsx4M5l1CMVjKeQj/dUys.','bénévole',1,23),
(24,'user24','$2y$12$IjNQnmj/mq0KJW841oZYduABnfb7CBOLScXYwvmcSpn2jbbGDBvAu','bénévole',1,24),
(25,'user25','$2y$12$gUVER1O1hi7ZVij3hDxMMeWJbbe3ZzJYm788kJvmreOq2mUh6BBbi','bénévole',1,25),
(26,'user26','$2y$12$eGiHkoYTjys.rndECxRbQu3tYwugFvdMmL/ClRMHchcpBb9E4lRNa','bénévole',1,26),
(27,'user27','$2y$12$t5AzaAoHppSznxELijd/fu/XrkpWxEwyHGz1U76cPYiqUL58BI/yK','bénévole',1,27),
(28,'user28','$2y$12$dVkxLWPKdwyhIShUpJCtA.NZVfyYz7/6BHwTnyBSLqcVEzlBI1tT2','bénévole',1,28),
(29,'user29','$2y$12$8BeMS.1oijZMFLW9bmoJCuUBG2nzlVKRLks8RsGVFZtVqEtshKZw2','bénévole',1,29),
(30,'user30','$2y$12$FIvPyG3tzgWrb8xnHtYuae.9nxfrzF.EKAOhkqP0DU8OuZ0JjM7D.','bénévole',1,30),
(31,'user31','$2y$12$X4zvoX43HjjYUPs1a9CKc.p3rqR68OgtS2m6KLJhBbrctk5czCbuO','bénévole',1,1),
(32,'user32','$2y$12$pcKCwpbt9U1OSLsfcH0LeO.rDlzeXecnE4gXnrB2s2hEhExG6yzQC','bénévole',1,2),
(33,'user33','$2y$12$H1Lvuy77nsgZtZ4tQ/XdwO0Y34ebo8N6gYw5xm8Sr.zuWNvVGm0d.','bénévole',1,3),
(34,'user34','$2y$12$zVacGnAVRsAZR7KYsuGhJeVxpYQETzcwCSN0E6i0hxO/SKJFWmF.q','bénévole',1,4),
(35,'user35','$2y$12$iPRaexpYGML8Hg8goRmo/ufAL5we40cltGkvL8OJvJgLHxsHPpW6K','bénévole',1,5),
(36,'user36','$2y$12$UjlKTLj.lrwgHqA/kiHqSOarDIS/359VqRCgqY0xDe.plgjrK/vmK','bénévole',1,6),
(37,'user37','$2y$12$sl4FQjQg3j3kLJybFp8aOOxsP9QUWUX73bAsb2Hn8.xE/8FSxrt7y','bénévole',1,7),
(38,'user38','$2y$12$.g3oH07DXLFwHLWR3nzt2ubv5glpRVzFiNhbrGeIBcUeEskNaP686','bénévole',1,8),
(39,'user39','$2y$12$Gs1oAlzWCHbMVHVmfjI2a.DJBK4BPn.oGrvK8iu2sDqjpGDUponw2','bénévole',1,9),
(40,'user40','$2y$12$CSIjGa28Oq6ys0RFbdcYC.ml8VM9WxInbgL.iGf/YaDG4RNEwDxCG','bénévole',1,10),
(41,'user41','$2y$12$QYTQt028V.C9UM1ieFt7zuNGyG1P7ZVqYUdL5OLiivyWWf0YLzeam','bénévole',1,11),
(42,'user42','$2y$12$HzTYa8jhx4xfsZC9dulfsuZ9C21YukSBlUEZCJB0vg/McVhpSncBW','bénévole',1,12),
(43,'user43','$2y$12$ybKaGt0UT9HriQkcXNqlLOpivVchG6rsJHKJqX6kbQBLWKYMTjUHW','bénévole',1,13),
(44,'user44','$2y$12$ByknNaZednncSXeEbEgsTeGw4I3aauqhf.9q5t3b9C4y1b5BIQtoe','bénévole',1,14),
(45,'user45','$2y$12$YLnJfHqFslRDQ76tRCFUFe2M/wUxRJ5YXB9I3fZBY28lmcEU9n2pC','bénévole',1,15),
(46,'user46','$2y$12$h//xCfnmg6XLliE5J4C.E.AvWsAgCINxlk5FY73JdsqwhkaJCo0HG','bénévole',1,16),
(47,'user47','$2y$12$JhADOkvurarxFBgSOJyVmO8Jiv.PcYawNq4p5pH3vd2osBY73bxpK','bénévole',1,17),
(48,'user48','$2y$12$RnLWW2XFI8euR9VzBBpVoOjN./S0EJPTsAmMZpWX3BfGgFcqbySrm','bénévole',1,18),
(49,'user49','$2y$12$CNVhfvFBalZu0WWgqEf8PufhutMmG9BN/PFRss5Hg2FQPf86ihdDC','bénévole',1,19),
(50,'user50','$2y$12$LagWCCckRHYQnfG6iifQsO1UN.jTgJ3oCYxlaP.kijU/CxP5pKjsK','bénévole',1,20),
(52,'user52','$2y$12$TLFSBClIULASJYkzKoL3hObSpqWlXbJ8s3GnXKWenRWQtw8JAxp8C','bénévole',1,22),
(53,'user53','$2y$12$tCChf3jrnM0FSJlas8PoH.phIN1Mprc5v7LodiCZlx9Esl.9DqtJa','bénévole',1,23),
(54,'user54','$2y$12$FmfZ6OMors9QtkEd659n5e5OeiY7ghUSu3wYOV7x.J97yNIope2BW','bénévole',1,24),
(55,'user55','$2y$12$1SJb5cW2OceejttN9bBrqONlCCPerGzEAfdK8gv8QuomKwlJqICq6','bénévole',1,25),
(56,'user56','$2y$12$RPEUwUk.zbQa0QrH4BVRB.lTbNYwKlJXvVAgYODAv/ANL9Od1rA0O','bénévole',1,26),
(57,'user57','$2y$12$FTPCtOmVCd6EfynqzEs/3.FXg1qkhTrmRLm11SYuB4lsuTuvKn8wS','bénévole',1,27),
(58,'user58','$2y$12$uDmo4ewdJgGocYNHQfBUBe/uYjwafJEs.0qYgWRDjEbStAORWFldi','bénévole',1,28),
(59,'user59','$2y$12$Ng9g43f.EHuv4O9QwiOZDejhmlwxZjas3/8HCNzzJjSPiUW.Tyv2C','bénévole',1,29),
(60,'user60','$2y$12$QiQBCsyfXZt7Ex4CXWNGSuQWMmWjaZehk.MNMfkM3LCHhj2h9qLuK','bénévole',1,30),
(61,'user61','$2y$12$hP9wxGzBw1N.oBnVl4y6GOKFUr5JxL1ukXkrALcck4KHxGHJddz7a','bénévole',1,1),
(62,'user62','$2y$12$xqF4Q92Hw/4.7f2tKrJQeObZt1UbvCL1E8rcEm0.kpc6C7Ylsm1Km','bénévole',1,2),
(63,'user63','$2y$12$67MxqaAnzRt/F34KQGR6QuucZj4mqKQb.x8DPt1QvMwX6h0B/CD0O','bénévole',1,3),
(64,'user64','$2y$12$WQqYwjOghfDXdV/bTPHjV.bGUdhFpOsAYwzxSf6PkCcWmY/2RFq/W','bénévole',1,4),
(65,'user65','$2y$12$P5K2GkT2Ht5/aFopfBTI7OLVRDyFqM464aH4BXe1UuLGY92iziPV.','bénévole',1,5),
(66,'user66','$2y$12$O1BtKiUqgGefWTVVa53dfO8k51YRu/uM52T4luXCzWBOdh0DcNRnO','bénévole',1,6),
(67,'user67','$2y$12$.f28K/8mqV0XqFL/hlG8IOPvUSLLeYT.PJGFU010XPZXQQ3akleB6','bénévole',1,7),
(68,'user68','$2y$12$xYgFd5eU26Vfx0WM6MUPo.Fpnes61lh1mzGmWWr0NMGzx4koIzL4y','bénévole',1,8),
(69,'user69','$2y$12$Hb4ay73ZsBTxkWy768FiyuuqC2C4cE..TXjt/UI6u3f2XIq.HM/du','bénévole',1,9),
(70,'user70','$2y$12$DxeKPnCzBS0HlH0aveyF1uWXsEOMfpGV55x6ejoJEF834BdHTvyfa','bénévole',1,10),
(71,'user71','$2y$12$dzzh3WuMx8oTRDu.9b1SG.Iz2aZWvmTTXcstbG0xH.6DwHF17ZpN6','bénévole',1,11),
(72,'user72','$2y$12$xyyWsniYWkvCtzJLsgsceeyfjJb64CzyyZJGiIAJkCWSvXkRmWW5C','bénévole',1,12),
(73,'user73','$2y$12$ADhoD2EHwbxgYychMd9A6OTdGNVUgezeX9yN6Vo2FlWYUVgFVqUD6','bénévole',1,13),
(74,'user74','$2y$12$40xZvzeX1dpWouMZaxSLWOUkarffiBvsqakL2NWuQBCRdaQSRmBxW','bénévole',1,14),
(75,'user75','$2y$12$GcTWPTqv0CjOjFuerk/kkuH5vCqdIRou.ZQ5IlreEtigYbfxsw09W','bénévole',1,15),
(76,'user76','$2y$12$Sr2C1haO7quzU.DwAIa.8uGLPgkGi6nCoWRkdZlCP8DZYYVbXCFCW','bénévole',1,16),
(77,'user77','$2y$12$B8MOb01BktOmdhY4COvTC.ly19yufhps9rvXXRvGdjB/Ya2Hq2whW','bénévole',1,17),
(78,'user78','$2y$12$Gxc7UsRtaSKguc/NH8s6auqzNk1oyT22apazHTWIdtGjj0qEhOXCq','bénévole',1,18),
(79,'user79','$2y$12$APiPTB/VzQJV8R4vZR2vpO8fAd4IXTVPjViB2jRR4a1ytVtzKpWYm','bénévole',1,19),
(80,'user80','$2y$12$yBmhZ6mUzOQ1ta3OXiPM1.xV5MJn/vjQDQLosN8oi9KAnA3K2hZRK','bénévole',1,20),
(82,'user82','$2y$12$XZh7R2KipHqfrW7HaFQI/ut6XnqVO73oVeiUu2HBbEykJ75Ixp/Ke','bénévole',1,22),
(83,'user83','$2y$12$fxoK.THrkGU7GXE1hb4OS.2W9uyf/ZhfrYsK9/gpiAs2NTfc8d0mO','bénévole',1,23),
(84,'user84','$2y$12$N/sT6ZnVhw4UP3syAiFjWO97aJKLmDTZR9bjfYM9s3WsOlWe0DmEm','bénévole',1,24),
(85,'user85','$2y$12$sPzlHxFyLr70b/7Ujvg4cOhXchoiO1JDXvCxJRdchZAzHeGtv301i','bénévole',1,25),
(86,'user86','$2y$12$rcXw32VDQhTrXKipwEcAce2lSmosUA0LCaPuJEaL99Tk4CrIQgeiW','bénévole',1,26),
(87,'user87','$2y$12$ECu6QwzzMeVM.KCiccuSxOkOzyDv4IAevfXsvVNuta7W1qLAUptQe','bénévole',1,27),
(88,'user88','$2y$12$4CFNiJY.2oNn8KTA8xdaROuMRQl/fU9.glXCeWebRbX4Or8S8uh2C','bénévole',1,28),
(89,'user89','$2y$12$O/oOCvA0/JnWJiwddG5/MeQaBKITqHuJa.iRMoEpD8ZOmkRTMv.sS','bénévole',1,29),
(90,'user90','$2y$12$twDV5KoyAvaMQbpU5lZHiOs4LvkIinnZzAa54uHi/iCeAVLrPz2mu','bénévole',1,30),
(91,'user91','$2y$12$JrRWqDfvs4TWMOIWlm3X0.Lk2Pvt.OyFaq0hH.DyEnfd.TVjHXhRa','bénévole',1,1),
(92,'user92','$2y$12$QuAqcOpg7hxbqaDwDs7NRu/OmhO8aMFIqDcjwNeMPjYLD5/2WwBSy','bénévole',1,2),
(93,'user93','$2y$12$EP5n8ABgUTmCtnZ4FRIiUuAqJFeLkfkhJg57o11MiJ3suxpyj3kSK','bénévole',1,3),
(94,'user94','$2y$12$6xfgO1RY0uPJX9wLtEwmee9k95CMZBfD3z1M1cgSRMIHrc.dgi/Rq','bénévole',1,4),
(95,'user95','$2y$12$j99U7/zzNlb0XH/8TBddkuatRPq0FA1i44LPsQ3wvJmwTpj2SeAmC','bénévole',1,5),
(96,'user96','$2y$12$Mx/R7JNVRIUG1RvUInUNTOuiJHxd4X5Ts/dZAXu0ce9uGwIq7p2DG','bénévole',1,6),
(97,'user97','$2y$12$WQteyNXECZUgE0y37OLcCOi1gsAWkZi17rrp/ytQoNqjXujSqqFqi','bénévole',1,7),
(98,'user98','$2y$12$INTsgX88xr0J.OB/jnvY1Oj5t7UqMrebETHZl7A5KCl5eo9TJHaGK','bénévole',1,8),
(99,'user99','$2y$12$Qfn7DnM.wCwmP8lOzgmq7eOvqtGKKgZ/ENcxauga/1Og0Ff63ll4y','bénévole',1,9),
(100,'user100','$2y$12$i4mQFkYc8i/qaoE706o1MutDIBjlAqkncVpworsZ0B14ADQEzexwu','bénévole',1,10);
/*!40000 ALTER TABLE `COMPTE` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `CONTRIBUE_PARTENAIRE_MISSION`
--

DROP TABLE IF EXISTS `CONTRIBUE_PARTENAIRE_MISSION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `CONTRIBUE_PARTENAIRE_MISSION` (
  `idMission` int NOT NULL,
  `idPart` int NOT NULL,
  PRIMARY KEY (`idMission`,`idPart`),
  KEY `idPart` (`idPart`),
  CONSTRAINT `contribue_partenaire_mission_ibfk_1` FOREIGN KEY (`idMission`) REFERENCES `MISSION` (`idMission`),
  CONSTRAINT `contribue_partenaire_mission_ibfk_2` FOREIGN KEY (`idPart`) REFERENCES `PARTENAIRE` (`idPart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CONTRIBUE_PARTENAIRE_MISSION`
--

LOCK TABLES `CONTRIBUE_PARTENAIRE_MISSION` WRITE;
/*!40000 ALTER TABLE `CONTRIBUE_PARTENAIRE_MISSION` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `CONTRIBUE_PARTENAIRE_MISSION` VALUES
(32,1),
(59,1),
(60,1),
(61,1),
(32,2),
(33,2),
(60,2),
(61,2),
(32,3),
(33,3),
(34,3),
(61,3),
(32,4),
(33,4),
(34,4),
(35,4),
(33,5),
(34,5),
(35,5),
(36,5),
(34,6),
(35,6),
(36,6),
(37,6),
(35,7),
(36,7),
(37,7),
(38,7),
(36,8),
(37,8),
(38,8),
(39,8),
(37,9),
(38,9),
(39,9),
(40,9),
(38,10),
(39,10),
(40,10),
(41,10),
(39,11),
(40,11),
(41,11),
(42,11),
(40,12),
(41,12),
(42,12),
(43,12),
(41,13),
(42,13),
(43,13),
(44,13),
(42,14),
(43,14),
(44,14),
(45,14),
(43,15),
(44,15),
(45,15),
(46,15),
(44,16),
(45,16),
(46,16),
(47,16),
(45,17),
(46,17),
(47,17),
(48,17),
(46,18),
(47,18),
(48,18),
(49,18),
(47,19),
(48,19),
(49,19),
(50,19),
(48,20),
(49,20),
(50,20),
(51,20),
(49,21),
(50,21),
(51,21),
(52,21),
(50,22),
(51,22),
(52,22),
(53,22),
(51,23),
(52,23),
(53,23),
(54,23),
(52,24),
(53,24),
(54,24),
(55,24),
(53,25),
(54,25),
(55,25),
(56,25),
(54,26),
(55,26),
(56,26),
(57,26),
(55,27),
(56,27),
(57,27),
(58,27),
(56,28),
(57,28),
(58,28),
(59,28),
(57,29),
(58,29),
(59,29),
(60,29),
(58,30),
(59,30),
(60,30),
(61,30);
/*!40000 ALTER TABLE `CONTRIBUE_PARTENAIRE_MISSION` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `CONVENTION`
--

DROP TABLE IF EXISTS `CONVENTION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `CONVENTION` (
  `idConv` int NOT NULL AUTO_INCREMENT,
  `nom_conv` varchar(100) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`idConv`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CONVENTION`
--

LOCK TABLES `CONVENTION` WRITE;
/*!40000 ALTER TABLE `CONVENTION` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `CONVENTION` VALUES
(1,'Convention 1','2023-01-01','2023-01-31','Description de la convention 1'),
(2,'Convention 2','2023-02-01','2023-02-28','Description de la convention 2'),
(3,'Convention 3','2023-03-01','2023-03-31','Description de la convention 3'),
(4,'Convention 4','2023-04-01','2023-04-30','Description de la convention 4'),
(5,'Convention 5','2023-05-01','2023-05-31','Description de la convention 5'),
(6,'Convention 6','2023-06-01','2023-06-30','Description de la convention 6'),
(7,'Convention 7','2023-07-01','2023-07-31','Description de la convention 7'),
(8,'Convention 8','2023-08-01','2023-08-31','Description de la convention 8'),
(9,'Convention 9','2023-09-01','2023-09-30','Description de la convention 9'),
(10,'Convention 10','2023-10-01','2023-10-31','Description de la convention 10'),
(11,'Convention 11','2023-11-01','2023-11-30','Description de la convention 11'),
(12,'Convention 12','2023-12-01','2023-12-31','Description de la convention 12'),
(13,'Convention 13','2024-01-01','2024-01-31','Description de la convention 13'),
(14,'Convention 14','2024-02-01','2024-02-29','Description de la convention 14'),
(15,'Convention 15','2024-03-01','2024-03-31','Description de la convention 15'),
(16,'Convention 16','2024-04-01','2024-04-30','Description de la convention 16'),
(17,'Convention 17','2024-05-01','2024-05-31','Description de la convention 17'),
(18,'Convention 18','2024-06-01','2024-06-30','Description de la convention 18'),
(19,'Convention 19','2024-07-01','2024-07-31','Description de la convention 19'),
(20,'Convention 20','2024-08-01','2024-08-31','Description de la convention 20'),
(21,'Convention 21','2024-09-01','2024-09-30','Description de la convention 21'),
(22,'Convention 22','2024-10-01','2024-10-31','Description de la convention 22'),
(23,'Convention 23','2024-11-01','2024-11-30','Description de la convention 23'),
(24,'Convention 24','2024-12-01','2024-12-31','Description de la convention 24'),
(25,'Convention 25','2025-01-01','2025-01-31','Description de la convention 25'),
(26,'Convention 26','2025-02-01','2025-02-28','Description de la convention 26'),
(27,'Convention 27','2025-03-01','2025-03-31','Description de la convention 27'),
(28,'Convention 28','2025-04-01','2025-04-30','Description de la convention 28'),
(29,'Convention 29','2025-05-01','2025-05-31','Description de la convention 29'),
(30,'Convention 30','2025-06-01','2025-06-30','Description de la convention 30'),
(31,'Convention 31','2025-07-01','2025-07-31','Description de la convention 31'),
(32,'Convention 32','2025-08-01','2025-08-31','Description de la convention 32'),
(33,'Convention 33','2025-09-01','2025-09-30','Description de la convention 33'),
(34,'Convention 34','2025-10-01','2025-10-31','Description de la convention 34'),
(35,'Convention 35','2025-11-01','2025-11-30','Description de la convention 35'),
(36,'Convention 36','2025-12-01','2025-12-31','Description de la convention 36'),
(37,'Convention 37','2026-01-01','2026-01-31','Description de la convention 37'),
(38,'Convention 38','2026-02-01','2026-02-28','Description de la convention 38'),
(39,'Convention 39','2026-03-01','2026-03-31','Description de la convention 39'),
(40,'Convention 40','2026-04-01','2026-04-30','Description de la convention 40'),
(41,'Convention 41','2026-05-01','2026-05-31','Description de la convention 41'),
(42,'Convention 42','2026-06-01','2026-06-30','Description de la convention 42'),
(43,'Convention 43','2026-07-01','2026-07-31','Description de la convention 43'),
(44,'Convention 44','2026-08-01','2026-08-31','Description de la convention 44'),
(45,'Convention 45','2026-09-01','2026-09-30','Description de la convention 45'),
(46,'Convention 46','2026-10-01','2026-10-31','Description de la convention 46'),
(47,'Convention 47','2026-11-01','2026-11-30','Description de la convention 47'),
(48,'Convention 48','2026-12-01','2026-12-31','Description de la convention 48'),
(49,'Convention 49','2027-01-01','2027-01-31','Description de la convention 49'),
(50,'Convention 50','2027-02-01','2027-02-28','Description de la convention 50'),
(51,'Convention 51','2027-03-01','2027-03-31','Description de la convention 51'),
(52,'Convention 52','2027-04-01','2027-04-30','Description de la convention 52'),
(53,'Convention 53','2027-05-01','2027-05-31','Description de la convention 53'),
(54,'Convention 54','2027-06-01','2027-06-30','Description de la convention 54'),
(55,'Convention 55','2027-07-01','2027-07-31','Description de la convention 55'),
(56,'Convention 56','2027-08-01','2027-08-31','Description de la convention 56'),
(57,'Convention 57','2027-09-01','2027-09-30','Description de la convention 57'),
(58,'Convention 58','2027-10-01','2027-10-31','Description de la convention 58'),
(59,'Convention 59','2027-11-01','2027-11-30','Description de la convention 59'),
(60,'Convention 60','2027-12-01','2027-12-31','Description de la convention 60'),
(61,'Convention 61','2028-01-01','2028-01-31','Description de la convention 61'),
(62,'Convention 62','2028-02-01','2028-02-29','Description de la convention 62'),
(63,'Convention 63','2028-03-01','2028-03-31','Description de la convention 63'),
(64,'Convention 64','2028-04-01','2028-04-30','Description de la convention 64'),
(65,'Convention 65','2028-05-01','2028-05-31','Description de la convention 65'),
(66,'Convention 66','2028-06-01','2028-06-30','Description de la convention 66'),
(67,'Convention 67','2028-07-01','2028-07-31','Description de la convention 67'),
(68,'Convention 68','2028-08-01','2028-08-31','Description de la convention 68'),
(69,'Convention 69','2028-09-01','2028-09-30','Description de la convention 69'),
(70,'Convention 70','2028-10-01','2028-10-31','Description de la convention 70'),
(71,'Convention 71','2028-11-01','2028-11-30','Description de la convention 71'),
(72,'Convention 72','2028-12-01','2028-12-31','Description de la convention 72'),
(73,'Convention 73','2029-01-01','2029-01-31','Description de la convention 73'),
(74,'Convention 74','2029-02-01','2029-02-28','Description de la convention 74'),
(75,'Convention 75','2029-03-01','2029-03-31','Description de la convention 75'),
(76,'Convention 76','2029-04-01','2029-04-30','Description de la convention 76'),
(77,'Convention 77','2029-05-01','2029-05-31','Description de la convention 77'),
(78,'Convention 78','2029-06-01','2029-06-30','Description de la convention 78'),
(79,'Convention 79','2029-07-01','2029-07-31','Description de la convention 79'),
(80,'Convention 80','2029-08-01','2029-08-31','Description de la convention 80'),
(81,'Convention 81','2029-09-01','2029-09-30','Description de la convention 81'),
(82,'Convention 82','2029-10-01','2029-10-31','Description de la convention 82'),
(83,'Convention 83','2029-11-01','2029-11-30','Description de la convention 83'),
(84,'Convention 84','2029-12-01','2029-12-31','Description de la convention 84'),
(85,'Convention 85','2030-01-01','2030-01-31','Description de la convention 85'),
(86,'Convention 86','2030-02-01','2030-02-28','Description de la convention 86'),
(87,'Convention 87','2030-03-01','2030-03-31','Description de la convention 87'),
(88,'Convention 88','2030-04-01','2030-04-30','Description de la convention 88'),
(89,'Convention 89','2030-05-01','2030-05-31','Description de la convention 89'),
(90,'Convention 90','2030-06-01','2030-06-30','Description de la convention 90'),
(91,'Convention 91','2030-07-01','2030-07-31','Description de la convention 91'),
(92,'Convention 92','2030-08-01','2030-08-31','Description de la convention 92'),
(93,'Convention 93','2030-09-01','2030-09-30','Description de la convention 93'),
(94,'Convention 94','2030-10-01','2030-10-31','Description de la convention 94'),
(95,'Convention 95','2030-11-01','2030-11-30','Description de la convention 95'),
(96,'Convention 96','2030-12-01','2030-12-31','Description de la convention 96'),
(97,'Convention 97','2031-01-01','2031-01-31','Description de la convention 97'),
(98,'Convention 98','2031-02-01','2031-02-28','Description de la convention 98'),
(99,'Convention 99','2031-03-01','2031-03-31','Description de la convention 99'),
(100,'Convention 100','2031-04-01','2031-04-30','Description de la convention 100');
/*!40000 ALTER TABLE `CONVENTION` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `COTISATION`
--

DROP TABLE IF EXISTS `COTISATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `COTISATION` (
  `idCot` int NOT NULL AUTO_INCREMENT,
  `montant` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idCot`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COTISATION`
--

LOCK TABLES `COTISATION` WRITE;
/*!40000 ALTER TABLE `COTISATION` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `COTISATION` VALUES
(1,50.00),
(2,75.00),
(3,100.00),
(4,125.00),
(5,150.00),
(6,175.00),
(7,200.00),
(8,225.00),
(9,250.00),
(10,275.00),
(11,300.00),
(12,325.00),
(13,350.00),
(14,375.00),
(15,400.00),
(16,425.00),
(17,450.00),
(18,475.00),
(19,500.00),
(20,525.00),
(21,550.00),
(22,575.00),
(23,600.00),
(24,625.00),
(25,650.00),
(26,675.00),
(27,700.00),
(28,725.00),
(29,750.00),
(30,775.00),
(31,800.00),
(32,825.00),
(33,850.00),
(34,875.00),
(35,900.00),
(36,925.00),
(37,950.00),
(38,975.00),
(39,1000.00),
(40,1025.00),
(41,1050.00),
(42,1075.00),
(43,1100.00),
(44,1125.00),
(45,1150.00),
(46,1175.00),
(47,1200.00),
(48,1225.00),
(49,1250.00),
(50,1275.00),
(51,1300.00),
(52,1325.00),
(53,1350.00),
(54,1375.00),
(55,1400.00),
(56,1425.00),
(57,1450.00),
(58,1475.00),
(59,1500.00),
(60,1525.00),
(61,1550.00),
(62,1575.00),
(63,1600.00),
(64,1625.00),
(65,1650.00),
(66,1675.00),
(67,1700.00),
(68,1725.00),
(69,1750.00),
(70,1775.00),
(71,1800.00),
(72,1825.00),
(73,1850.00),
(74,1875.00),
(75,1900.00),
(76,1925.00),
(77,1950.00),
(78,1975.00),
(79,2000.00),
(80,2025.00),
(81,2050.00),
(82,2075.00),
(83,2100.00),
(84,2125.00),
(85,2150.00),
(86,2175.00),
(87,2200.00),
(88,2225.00),
(89,2250.00),
(90,2275.00),
(91,2300.00),
(92,2325.00),
(93,2350.00),
(94,2375.00),
(95,2400.00),
(96,2425.00),
(97,2450.00),
(98,2475.00),
(99,2500.00),
(100,2525.00),
(101,2550.00),
(102,2575.00),
(103,2600.00),
(104,2625.00),
(105,2650.00),
(106,2675.00),
(107,2700.00),
(108,2725.00),
(109,2750.00),
(110,2775.00);
/*!40000 ALTER TABLE `COTISATION` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `DON`
--

DROP TABLE IF EXISTS `DON`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `DON` (
  `idDon` int NOT NULL AUTO_INCREMENT,
  `montant` decimal(10,2) NOT NULL,
  `date_` date NOT NULL,
  `type_don` varchar(50) NOT NULL,
  `idPersonne` int DEFAULT NULL,
  PRIMARY KEY (`idDon`),
  KEY `idPersonne` (`idPersonne`),
  CONSTRAINT `fk_don` FOREIGN KEY (`idPersonne`) REFERENCES `DONATEUR` (`idPersonne`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DON`
--

LOCK TABLES `DON` WRITE;
/*!40000 ALTER TABLE `DON` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `DON` VALUES
(1,50.00,'2023-01-10','Ponctuel',1),
(2,45.00,'2023-01-15','ponctuel',2),
(3,100.00,'2023-02-01','Mensuel',3),
(4,75.00,'2023-02-12','Ponctuel',4),
(5,20.00,'2023-02-20','Ponctuel',5),
(6,60.00,'2023-03-01','Mensuel',6),
(7,45.00,'2023-03-10','Ponctuel',7),
(8,90.00,'2023-03-18','Mensuel',8),
(9,25.00,'2023-03-25','Ponctuel',9),
(10,120.00,'2023-04-01','Mensuel',10),
(11,40.00,'2023-04-08','Ponctuel',11),
(12,80.00,'2023-04-15','Mensuel',12),
(13,55.00,'2023-04-22','Ponctuel',13),
(14,150.00,'2023-05-01','Mensuel',14),
(15,35.00,'2023-05-10','Ponctuel',15),
(16,70.00,'2023-05-18','Mensuel',16),
(17,20.00,'2023-05-25','Ponctuel',17),
(18,110.00,'2023-06-01','Mensuel',18),
(19,45.00,'2023-06-08','Ponctuel',19),
(20,60.00,'2023-06-15','Ponctuel',20),
(22,30.00,'2023-07-01','Ponctuel',22),
(23,130.00,'2023-07-08','Mensuel',23),
(24,50.00,'2023-07-15','Ponctuel',24),
(25,75.00,'2023-07-22','Ponctuel',25),
(26,100.00,'2023-08-01','Mensuel',26),
(27,40.00,'2023-08-08','Ponctuel',27),
(28,90.00,'2023-08-15','Mensuel',28),
(29,35.00,'2023-08-22','Ponctuel',29),
(30,120.00,'2023-09-01','Mensuel',30),
(31,1000.00,'2025-12-12','ZZZZZ',NULL),
(32,1000.00,'2025-12-12','ZZZZZZ',NULL),
(33,1000.00,'2025-12-10','ZZZZZ',NULL),
(34,100.00,'2025-12-12','ZZZZZ',5);
/*!40000 ALTER TABLE `DON` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `DONATEUR`
--

DROP TABLE IF EXISTS `DONATEUR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `DONATEUR` (
  `idPersonne` int NOT NULL,
  `type_donateur` varchar(50) DEFAULT NULL,
  `date_premier_don` date NOT NULL,
  PRIMARY KEY (`idPersonne`),
  CONSTRAINT `fk_donateur` FOREIGN KEY (`idPersonne`) REFERENCES `PERSONNE` (`idPersonne`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DONATEUR`
--

LOCK TABLES `DONATEUR` WRITE;
/*!40000 ALTER TABLE `DONATEUR` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `DONATEUR` VALUES
(1,'Particulier','2019-03-12'),
(2,'Particulier','2020-06-25'),
(3,'Entreprise','2018-01-10'),
(4,'Association','2021-09-05'),
(5,'Particulier','2020-11-18'),
(6,'Entreprise','2017-04-30'),
(7,'Particulier','2019-02-14'),
(8,'Association','2022-07-03'),
(9,'Entreprise','2018-05-27'),
(10,'Particulier','2021-08-09'),
(11,'Particulier','2019-04-11'),
(12,'Entreprise','2020-10-21'),
(13,'Association','2017-01-19'),
(14,'Particulier','2018-06-14'),
(15,'Entreprise','2021-03-08'),
(16,'Particulier','2022-12-25'),
(17,'Association','2019-09-01'),
(18,'Entreprise','2018-07-17'),
(19,'Particulier','2020-11-29'),
(20,'Association','2021-05-06'),
(22,'Particulier','2019-04-15'),
(23,'Entreprise','2018-08-27'),
(24,'Association','2020-01-30'),
(25,'Particulier','2021-10-12'),
(26,'Entreprise','2019-06-09'),
(27,'Particulier','2018-12-19'),
(28,'Association','2020-03-05'),
(29,'Entreprise','2019-07-23'),
(30,'Particulier','2021-09-14');
/*!40000 ALTER TABLE `DONATEUR` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `EVENEMENT`
--

DROP TABLE IF EXISTS `EVENEMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `EVENEMENT` (
  `idEvenement` int NOT NULL AUTO_INCREMENT,
  `date_heure` datetime NOT NULL,
  `type_evenement` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `idLieu` int DEFAULT NULL,
  `budget` int DEFAULT NULL,
  `materiel_necessaire` varchar(50) DEFAULT NULL,
  `nom_evenement` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idEvenement`),
  KEY `idLieu` (`idLieu`),
  CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`idLieu`) REFERENCES `LIEU` (`idLieu`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENEMENT`
--

LOCK TABLES `EVENEMENT` WRITE;
/*!40000 ALTER TABLE `EVENEMENT` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `EVENEMENT` VALUES
(101,'2025-01-01 09:00:00','Conférence','Conférence sur la technologie',1,500,'Chaises','Réunion'),
(102,'2025-01-02 10:00:00','Atelier','Atelier pratique sur le développement web',2,400,'Micro','Réunion'),
(103,'2025-01-03 11:00:00','Séminaire','Séminaire sur la gestion de projet',3,100,'Ecrans','Collecte'),
(104,'2025-01-04 14:00:00','Conférence','Présentation des nouvelles tendances',4,300,'Tables','Collecte'),
(105,'2025-01-05 15:00:00','Atelier','Atelier sur la cybersécurité',5,100,'Tables','Conférence'),
(106,'2025-01-06 09:30:00','Séminaire','Séminaire sur la finance',6,200,'Chaises','Collecte'),
(107,'2025-01-07 13:00:00','Conférence','Conférence sur l’IA',7,200,'Chaises','Collecte'),
(108,'2025-01-08 10:30:00','Atelier','Atelier sur le design UX',8,400,'Micro','Atelier'),
(109,'2025-01-09 11:15:00','Séminaire','Séminaire sur le marketing digital',9,200,'Micro','Réunion'),
(110,'2025-01-10 14:45:00','Conférence','Conférence sur le développement durable',10,300,'Chaises','Réunion'),
(111,'2025-01-11 09:00:00','Atelier','Atelier sur le leadership',11,500,'Ecrans','Collecte'),
(112,'2025-01-12 10:00:00','Séminaire','Séminaire sur les startups',12,400,'Ecrans','Atelier'),
(113,'2025-01-13 13:30:00','Conférence','Conférence sur la blockchain',13,500,'Tables','Atelier'),
(114,'2025-01-14 15:00:00','Atelier','Atelier sur le cloud computing',14,400,'Chaises','Formation'),
(115,'2025-01-15 16:30:00','Séminaire','Séminaire sur la gestion de crise',15,400,'Ecrans','Formation'),
(116,'2025-01-16 09:15:00','Conférence','Conférence sur l’entrepreneuriat',16,300,'Tables','Formation'),
(117,'2025-01-17 11:00:00','Atelier','Atelier sur l’intelligence artificielle',17,300,'Ecrans','Conférence'),
(118,'2025-01-18 14:00:00','Séminaire','Séminaire sur la communication',18,100,'Chaises','Réunion'),
(119,'2025-01-19 13:00:00','Conférence','Conférence sur la finance durable',19,500,'Projecteur','Atelier'),
(120,'2025-01-20 15:30:00','Atelier','Atelier sur le management',20,400,'Tables','Collecte'),
(121,'2025-01-21 09:00:00','Séminaire','Séminaire sur le développement personnel',21,200,'Projecteur','Collecte'),
(122,'2025-01-22 10:30:00','Conférence','Conférence sur la data science',22,200,'Micro','Collecte'),
(123,'2025-01-23 11:45:00','Atelier','Atelier sur le Python avancé',23,500,'Micro','Collecte'),
(124,'2025-01-24 14:15:00','Séminaire','Séminaire sur la cybersécurité',24,200,'Projecteur','Réunion'),
(125,'2025-01-25 15:30:00','Conférence','Conférence sur le cloud computing',25,100,'Chaises','Formation'),
(126,'2025-01-26 09:00:00','Atelier','Atelier sur la finance',26,300,'Micro','Collecte'),
(127,'2025-01-27 10:00:00','Séminaire','Séminaire sur le marketing',27,100,'Micro','Réunion'),
(128,'2025-01-28 11:00:00','Conférence','Conférence sur l’innovation',28,500,'Micro','Formation'),
(129,'2025-01-29 14:00:00','Atelier','Atelier sur la gestion de projet',29,200,'Chaises','Réunion'),
(130,'2025-01-30 15:00:00','Séminaire','Séminaire sur la blockchain',30,400,'Ecrans','Conférence'),
(131,'2025-01-31 09:30:00','Conférence','Conférence sur l’intelligence artificielle',31,500,'Tables','Collecte'),
(132,'2025-02-01 13:00:00','Atelier','Atelier sur le design UX',32,300,'Tables','Réunion'),
(133,'2025-02-02 10:30:00','Séminaire','Séminaire sur le marketing digital',33,400,'Chaises','Collecte'),
(134,'2025-02-03 11:15:00','Conférence','Conférence sur le développement durable',34,500,'Tables','Réunion'),
(135,'2025-02-04 14:45:00','Atelier','Atelier sur le leadership',35,300,'Chaises','Atelier'),
(136,'2025-02-05 09:00:00','Séminaire','Séminaire sur les startups',36,400,'Projecteur','Formation'),
(137,'2025-02-06 10:00:00','Conférence','Conférence sur la blockchain',37,400,'Ecrans','Formation'),
(138,'2025-02-07 13:30:00','Atelier','Atelier sur le cloud computing',38,400,'Projecteur','Atelier'),
(139,'2025-02-08 15:00:00','Séminaire','Séminaire sur la gestion de crise',39,300,'Ecrans','Conférence'),
(140,'2025-02-09 16:30:00','Conférence','Conférence sur l’entrepreneuriat',40,100,'Chaises','Formation'),
(141,'2025-02-10 09:15:00','Atelier','Atelier sur l’intelligence artificielle',41,100,'Ecrans','Atelier'),
(142,'2025-02-11 11:00:00','Séminaire','Séminaire sur la communication',42,300,'Chaises','Atelier'),
(143,'2025-02-12 14:00:00','Conférence','Conférence sur la finance durable',43,500,'Tables','Collecte'),
(144,'2025-02-13 13:00:00','Atelier','Atelier sur le management',44,200,'Projecteur','Atelier'),
(145,'2025-02-14 15:30:00','Séminaire','Séminaire sur le développement personnel',45,500,'Micro','Atelier'),
(146,'2025-02-15 09:00:00','Conférence','Conférence sur la data science',46,100,'Ecrans','Atelier'),
(147,'2025-02-16 10:30:00','Atelier','Atelier sur le Python avancé',47,400,'Chaises','Collecte'),
(148,'2025-02-17 11:45:00','Séminaire','Séminaire sur la cybersécurité',48,400,'Ecrans','Collecte'),
(149,'2025-02-18 14:15:00','Conférence','Conférence sur le cloud computing',49,500,'Ecrans','Réunion'),
(150,'2025-02-19 15:30:00','Atelier','Atelier sur la finance',50,500,'Projecteur','Formation'),
(151,'2025-02-20 09:00:00','Séminaire','Séminaire sur le marketing',51,400,'Tables','Formation'),
(152,'2025-02-21 10:00:00','Conférence','Conférence sur l’innovation',52,400,'Projecteur','Atelier'),
(153,'2025-02-22 11:00:00','Atelier','Atelier sur la gestion de projet',53,200,'Ecrans','Collecte'),
(154,'2025-02-23 14:00:00','Séminaire','Séminaire sur la blockchain',54,100,'Chaises','Réunion'),
(155,'2025-02-24 15:00:00','Conférence','Conférence sur l’intelligence artificielle',55,200,'Chaises','Atelier'),
(156,'2025-02-25 09:30:00','Atelier','Atelier sur le design UX',56,500,'Chaises','Atelier'),
(157,'2025-02-26 13:00:00','Séminaire','Séminaire sur le marketing digital',57,200,'Ecrans','Réunion'),
(158,'2025-02-27 10:30:00','Conférence','Conférence sur le développement durable',58,300,'Ecrans','Atelier'),
(159,'2025-02-28 11:15:00','Atelier','Atelier sur le leadership',59,500,'Projecteur','Atelier'),
(160,'2025-03-01 14:45:00','Séminaire','Séminaire sur les startups',60,200,'Micro','Réunion');
/*!40000 ALTER TABLE `EVENEMENT` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `ILLUSTRE_EVENEMENT`
--

DROP TABLE IF EXISTS `ILLUSTRE_EVENEMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ILLUSTRE_EVENEMENT` (
  `idMedia` int NOT NULL,
  `idEvenement` int NOT NULL,
  `role_media` varchar(50) NOT NULL,
  PRIMARY KEY (`idMedia`,`idEvenement`),
  KEY `idEvenement` (`idEvenement`),
  CONSTRAINT `illustre_evenement_ibfk_1` FOREIGN KEY (`idMedia`) REFERENCES `MEDIA` (`idMedia`),
  CONSTRAINT `illustre_evenement_ibfk_2` FOREIGN KEY (`idEvenement`) REFERENCES `EVENEMENT` (`idEvenement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ILLUSTRE_EVENEMENT`
--

LOCK TABLES `ILLUSTRE_EVENEMENT` WRITE;
/*!40000 ALTER TABLE `ILLUSTRE_EVENEMENT` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `ILLUSTRE_EVENEMENT` VALUES
(2,101,'Caméraman'),
(3,102,'Reporter'),
(4,103,'Graphiste'),
(5,104,'Photographe'),
(6,105,'Caméraman'),
(7,106,'Reporter'),
(8,107,'Graphiste'),
(9,108,'Photographe'),
(10,109,'Caméraman'),
(11,110,'Reporter'),
(12,111,'Graphiste'),
(13,112,'Photographe'),
(14,113,'Caméraman'),
(15,114,'Reporter'),
(16,115,'Graphiste'),
(17,116,'Photographe'),
(18,117,'Caméraman'),
(19,118,'Reporter'),
(20,119,'Graphiste'),
(21,120,'Photographe'),
(22,121,'Caméraman'),
(23,122,'Reporter'),
(24,123,'Graphiste'),
(25,124,'Photographe'),
(26,125,'Caméraman'),
(27,126,'Reporter'),
(28,127,'Graphiste'),
(29,128,'Photographe'),
(30,129,'Caméraman'),
(31,130,'Reporter'),
(32,131,'Graphiste'),
(33,132,'Photographe'),
(34,133,'Caméraman'),
(35,134,'Reporter'),
(36,135,'Graphiste'),
(37,136,'Photographe'),
(38,137,'Caméraman'),
(39,138,'Reporter'),
(40,139,'Graphiste'),
(41,140,'Photographe'),
(42,141,'Caméraman'),
(43,142,'Reporter'),
(44,143,'Graphiste'),
(45,144,'Photographe'),
(46,145,'Caméraman'),
(47,146,'Reporter'),
(48,147,'Graphiste'),
(49,148,'Photographe'),
(50,149,'Caméraman'),
(51,150,'Reporter'),
(52,151,'Graphiste'),
(53,152,'Photographe'),
(54,153,'Caméraman'),
(55,154,'Reporter'),
(56,155,'Graphiste'),
(57,156,'Photographe'),
(58,157,'Caméraman'),
(59,158,'Reporter'),
(60,159,'Graphiste');
/*!40000 ALTER TABLE `ILLUSTRE_EVENEMENT` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `LIEU`
--

DROP TABLE IF EXISTS `LIEU`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `LIEU` (
  `idLieu` int NOT NULL AUTO_INCREMENT,
  `ville` varchar(100) NOT NULL,
  `code_postal` varchar(10) NOT NULL,
  `region` varchar(100) NOT NULL,
  `adresse_detail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idLieu`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LIEU`
--

LOCK TABLES `LIEU` WRITE;
/*!40000 ALTER TABLE `LIEU` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `LIEU` VALUES
(1,'Paris','75001','Île-de-France','10 rue de Rivoli'),
(2,'Paris','75002','Île-de-France','22 boulevard Sébastopol'),
(3,'Paris','75003','Île-de-France','5 rue du Temple'),
(4,'Paris','75004','Île-de-France','18 rue Saint-Antoine'),
(5,'Paris','75005','Île-de-France','12 rue Mouffetard'),
(6,'Paris','75006','Île-de-France','9 boulevard Saint-Germain'),
(7,'Paris','75007','Île-de-France','25 rue de Grenelle'),
(8,'Paris','75008','Île-de-France','40 avenue des Champs-Élysées'),
(9,'Paris','75009','Île-de-France','7 rue Lafayette'),
(10,'Paris','75010','Île-de-France','15 rue du Faubourg Saint-Denis'),
(11,'Lyon','69001','Auvergne-Rhône-Alpes','3 rue de la République'),
(12,'Lyon','69002','Auvergne-Rhône-Alpes','14 place Bellecour'),
(13,'Lyon','69003','Auvergne-Rhône-Alpes','28 rue Garibaldi'),
(14,'Lyon','69004','Auvergne-Rhône-Alpes','6 montée de la Grande Côte'),
(15,'Lyon','69005','Auvergne-Rhône-Alpes','21 rue Saint-Jean'),
(16,'Lyon','69006','Auvergne-Rhône-Alpes','11 cours Vitton'),
(17,'Lyon','69007','Auvergne-Rhône-Alpes','34 avenue Jean Jaurès'),
(18,'Lyon','69008','Auvergne-Rhône-Alpes','9 avenue des Frères Lumière'),
(19,'Lyon','69009','Auvergne-Rhône-Alpes','17 quai Arloing'),
(20,'Lyon','69010','Auvergne-Rhône-Alpes','5 rue de l’Industrie'),
(21,'Marseille','13001','Provence-Alpes-Côte d’Azur','8 rue de Rome'),
(22,'Marseille','13002','Provence-Alpes-Côte d’Azur','19 quai du Port'),
(23,'Marseille','13003','Provence-Alpes-Côte d’Azur','12 rue Loubon'),
(24,'Marseille','13004','Provence-Alpes-Côte d’Azur','6 boulevard Sakakini'),
(25,'Marseille','13005','Provence-Alpes-Côte d’Azur','33 boulevard Baille'),
(26,'Marseille','13006','Provence-Alpes-Côte d’Azur','4 place Castellane'),
(27,'Marseille','13007','Provence-Alpes-Côte d’Azur','16 rue d’Endoume'),
(28,'Marseille','13008','Provence-Alpes-Côte d’Azur','28 avenue du Prado'),
(29,'Marseille','13009','Provence-Alpes-Côte d’Azur','5 boulevard Michelet'),
(30,'Marseille','13010','Provence-Alpes-Côte d’Azur','22 rue Pierre Doize'),
(31,'Toulouse','31000','Occitanie','7 place du Capitole'),
(32,'Toulouse','31100','Occitanie','18 avenue de Muret'),
(33,'Toulouse','31200','Occitanie','25 route de Launaguet'),
(34,'Toulouse','31300','Occitanie','9 allée Charles de Fitte'),
(35,'Toulouse','31400','Occitanie','11 avenue Jules Julien'),
(36,'Toulouse','31500','Occitanie','4 rue Louis Plana'),
(37,'Toulouse','31600','Occitanie','30 chemin des Capelles'),
(38,'Toulouse','31700','Occitanie','6 rue du Midi'),
(39,'Toulouse','31800','Occitanie','13 rue Bayard'),
(40,'Toulouse','31900','Occitanie','21 boulevard Lazare Carnot'),
(41,'Lille','59000','Hauts-de-France','10 rue Nationale'),
(42,'Lille','59160','Hauts-de-France','5 avenue Marx Dormoy'),
(43,'Lille','59260','Hauts-de-France','22 rue Jean Jaurès'),
(44,'Lille','59350','Hauts-de-France','17 place Rihour'),
(45,'Lille','59491','Hauts-de-France','8 rue de l’Abbé Lemire'),
(46,'Lille','59520','Hauts-de-France','14 rue de Tourcoing'),
(47,'Lille','59650','Hauts-de-France','19 boulevard de Metz'),
(48,'Lille','59777','Hauts-de-France','6 rue de la Plaine'),
(49,'Lille','59800','Hauts-de-France','29 rue Esquermoise'),
(50,'Lille','59930','Hauts-de-France','3 rue de la Gare'),
(51,'Nantes','44000','Pays de la Loire','12 rue Crébillon'),
(52,'Nantes','44100','Pays de la Loire','9 boulevard de la Liberté'),
(53,'Nantes','44200','Pays de la Loire','27 quai de la Fosse'),
(54,'Nantes','44300','Pays de la Loire','4 rue du Perray'),
(55,'Nantes','44400','Pays de la Loire','15 rue Aristide Briand'),
(56,'Nantes','44500','Pays de la Loire','6 avenue de la République'),
(57,'Nantes','44600','Pays de la Loire','20 rue du Port'),
(58,'Nantes','44700','Pays de la Loire','11 rue Jules Verne'),
(59,'Nantes','44800','Pays de la Loire','8 rue des Acacias'),
(60,'Nantes','44900','Pays de la Loire','19 chemin des Vignes');
/*!40000 ALTER TABLE `LIEU` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `MEDIA`
--

DROP TABLE IF EXISTS `MEDIA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `MEDIA` (
  `idMedia` int NOT NULL AUTO_INCREMENT,
  `url_media` varchar(255) NOT NULL,
  `type_media` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`idMedia`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEDIA`
--

LOCK TABLES `MEDIA` WRITE;
/*!40000 ALTER TABLE `MEDIA` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `MEDIA` VALUES
(1,'https://example.com/media1.jpg','video','Media 1'),
(2,'https://example.com/media2.jpg','image','Media 2'),
(3,'https://example.com/media3.jpg','image','Media 3'),
(4,'https://example.com/media4.jpg','image','Media 4'),
(5,'https://example.com/media5.jpg','image','Media 5'),
(6,'https://example.com/media6.jpg','image','Media 6'),
(7,'https://example.com/media7.jpg','image','Media 7'),
(8,'https://example.com/media8.jpg','image','Media 8'),
(9,'https://example.com/media9.jpg','image','Media 9'),
(10,'https://example.com/media10.jpg','image','Media 10'),
(11,'https://example.com/media11.mp4','video','Media 11'),
(12,'https://example.com/media12.mp4','video','Media 12'),
(13,'https://example.com/media13.mp4','video','Media 13'),
(14,'https://example.com/media14.mp4','video','Media 14'),
(15,'https://example.com/media15.mp4','video','Media 15'),
(16,'https://example.com/media16.mp4','video','Media 16'),
(17,'https://example.com/media17.mp4','video','Media 17'),
(18,'https://example.com/media18.mp4','video','Media 18'),
(19,'https://example.com/media19.mp4','video','Media 19'),
(20,'https://example.com/media20.mp4','video','Media 20'),
(21,'https://example.com/media21.mp3','audio','Media 21'),
(22,'https://example.com/media22.mp3','audio','Media 22'),
(23,'https://example.com/media23.mp3','audio','Media 23'),
(24,'https://example.com/media24.mp3','audio','Media 24'),
(25,'https://example.com/media25.mp3','audio','Media 25'),
(26,'https://example.com/media26.mp3','audio','Media 26'),
(27,'https://example.com/media27.mp3','audio','Media 27'),
(28,'https://example.com/media28.mp3','audio','Media 28'),
(29,'https://example.com/media29.mp3','audio','Media 29'),
(30,'https://example.com/media30.mp3','audio','Media 30'),
(31,'https://example.com/media31.jpg','image','Media 31'),
(32,'https://example.com/media32.jpg','image','Media 32'),
(33,'https://example.com/media33.jpg','image','Media 33'),
(34,'https://example.com/media34.jpg','image','Media 34'),
(35,'https://example.com/media35.jpg','image','Media 35'),
(36,'https://example.com/media36.jpg','image','Media 36'),
(37,'https://example.com/media37.jpg','image','Media 37'),
(38,'https://example.com/media38.jpg','image','Media 38'),
(39,'https://example.com/media39.jpg','image','Media 39'),
(40,'https://example.com/media40.jpg','image','Media 40'),
(41,'https://example.com/media41.mp4','video','Media 41'),
(42,'https://example.com/media42.mp4','video','Media 42'),
(43,'https://example.com/media43.mp4','video','Media 43'),
(44,'https://example.com/media44.mp4','video','Media 44'),
(45,'https://example.com/media45.mp4','video','Media 45'),
(46,'https://example.com/media46.mp4','video','Media 46'),
(47,'https://example.com/media47.mp4','video','Media 47'),
(48,'https://example.com/media48.mp4','video','Media 48'),
(49,'https://example.com/media49.mp4','video','Media 49'),
(50,'https://example.com/media50.mp4','video','Media 50'),
(51,'https://example.com/media51.mp3','audio','Media 51'),
(52,'https://example.com/media52.mp3','audio','Media 52'),
(53,'https://example.com/media53.mp3','audio','Media 53'),
(54,'https://example.com/media54.mp3','audio','Media 54'),
(55,'https://example.com/media55.mp3','audio','Media 55'),
(56,'https://example.com/media56.mp3','audio','Media 56'),
(57,'https://example.com/media57.mp3','audio','Media 57'),
(58,'https://example.com/media58.mp3','audio','Media 58'),
(59,'https://example.com/media59.mp3','audio','Media 59'),
(60,'https://example.com/media60.mp3','audio','Media 60'),
(61,'https://example.com/media61.jpg','image','Media 61'),
(62,'https://example.com/media62.jpg','image','Media 62'),
(63,'https://example.com/media63.jpg','image','Media 63'),
(64,'https://example.com/media64.jpg','image','Media 64'),
(65,'https://example.com/media65.jpg','image','Media 65'),
(66,'https://example.com/media66.jpg','image','Media 66'),
(67,'https://example.com/media67.jpg','image','Media 67'),
(68,'https://example.com/media68.jpg','image','Media 68'),
(69,'https://example.com/media69.jpg','image','Media 69'),
(70,'https://example.com/media70.jpg','image','Media 70'),
(71,'https://example.com/media71.mp4','video','Media 71'),
(72,'https://example.com/media72.mp4','video','Media 72'),
(73,'https://example.com/media73.mp4','video','Media 73'),
(74,'https://example.com/media74.mp4','video','Media 74'),
(75,'https://example.com/media75.mp4','video','Media 75'),
(76,'https://example.com/media76.mp4','video','Media 76'),
(77,'https://example.com/media77.mp4','video','Media 77'),
(78,'https://example.com/media78.mp4','video','Media 78'),
(79,'https://example.com/media79.mp4','video','Media 79'),
(80,'https://example.com/media80.mp4','video','Media 80'),
(81,'https://example.com/media81.mp3','audio','Media 81'),
(82,'https://example.com/media82.mp3','audio','Media 82'),
(83,'https://example.com/media83.mp3','audio','Media 83'),
(84,'https://example.com/media84.mp3','audio','Media 84'),
(85,'https://example.com/media85.mp3','audio','Media 85'),
(86,'https://example.com/media86.mp3','audio','Media 86'),
(87,'https://example.com/media87.mp3','audio','Media 87'),
(88,'https://example.com/media88.mp3','audio','Media 88'),
(89,'https://example.com/media89.mp3','audio','Media 89'),
(90,'https://example.com/media90.mp3','audio','Media 90'),
(91,'https://example.com/media91.jpg','image','Media 91'),
(92,'https://example.com/media92.jpg','image','Media 92'),
(93,'https://example.com/media93.jpg','image','Media 93'),
(94,'https://example.com/media94.jpg','image','Media 94'),
(95,'https://example.com/media95.jpg','image','Media 95'),
(96,'https://example.com/media96.jpg','image','Media 96'),
(97,'https://example.com/media97.jpg','image','Media 97'),
(98,'https://example.com/media98.jpg','image','Media 98'),
(99,'https://example.com/media99.jpg','image','Media 99'),
(100,'https://example.com/media100.jpg','image','Media 100');
/*!40000 ALTER TABLE `MEDIA` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `MISSION`
--

DROP TABLE IF EXISTS `MISSION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `MISSION` (
  `idMission` int NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `categorie` varchar(50) NOT NULL,
  `materiel_necessaire` text NOT NULL,
  `responsable` varchar(100) NOT NULL,
  `idLieu` int DEFAULT NULL,
  `nom_mission` varchar(255) DEFAULT NULL,
  `budget` int DEFAULT NULL,
  PRIMARY KEY (`idMission`),
  KEY `idLieu` (`idLieu`),
  CONSTRAINT `mission_ibfk_1` FOREIGN KEY (`idLieu`) REFERENCES `LIEU` (`idLieu`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MISSION`
--

LOCK TABLES `MISSION` WRITE;
/*!40000 ALTER TABLE `MISSION` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `MISSION` VALUES
(32,'Description de la mission 1','2025-01-01','2025-01-10','Catégorie A','Matériel 1','Responsable 1',1,'Distribution alimentaire',400),
(33,'Description de la mission 2','2025-01-02','2025-01-11','Catégorie B','Matériel 2','Responsable 2',2,'Nettoyage du parc',300),
(34,'Description de la mission 3','2025-01-03','2025-01-12','Catégorie C','Matériel 3','Responsable 3',3,'Animation pour enfants',400),
(35,'Description de la mission 4','2025-01-04','2025-01-13','Catégorie A','Matériel 4','Responsable 4',4,'Distribution alimentaire',100),
(36,'Description de la mission 5','2025-01-05','2025-01-14','Catégorie B','Matériel 5','Responsable 5',5,'Distribution alimentaire',200),
(37,'Description de la mission 6','2025-01-06','2025-01-15','Catégorie C','Matériel 6','Responsable 6',6,'Animation pour enfants',300),
(38,'Description de la mission 7','2025-01-07','2025-01-16','Catégorie A','Matériel 7','Responsable 7',7,'Soutien scolaire',400),
(39,'Description de la mission 8','2025-01-08','2025-01-17','Catégorie B','Matériel 8','Responsable 8',8,'Collecte de fonds',200),
(40,'Description de la mission 9','2025-01-09','2025-01-18','Catégorie C','Matériel 9','Responsable 9',9,'Distribution alimentaire',100),
(41,'Description de la mission 10','2025-01-10','2025-01-19','Catégorie A','Matériel 10','Responsable 10',10,'Soutien scolaire',300),
(42,'Description de la mission 11','2025-01-11','2025-01-20','Catégorie B','Matériel 11','Responsable 11',11,'Nettoyage du parc',100),
(43,'Description de la mission 12','2025-01-12','2025-01-21','Catégorie C','Matériel 12','Responsable 12',12,'Animation pour enfants',300),
(44,'Description de la mission 13','2025-01-13','2025-01-22','Catégorie A','Matériel 13','Responsable 13',13,'Collecte de fonds',500),
(45,'Description de la mission 14','2025-01-14','2025-01-23','Catégorie B','Matériel 14','Responsable 14',14,'Animation pour enfants',500),
(46,'Description de la mission 15','2025-01-15','2025-01-24','Catégorie C','Matériel 15','Responsable 15',15,'Animation pour enfants',400),
(47,'Description de la mission 16','2025-01-16','2025-01-25','Catégorie A','Matériel 16','Responsable 16',16,'Animation pour enfants',400),
(48,'Description de la mission 17','2025-01-17','2025-01-26','Catégorie B','Matériel 17','Responsable 17',17,'Soutien scolaire',100),
(49,'Description de la mission 18','2025-01-18','2025-01-27','Catégorie C','Matériel 18','Responsable 18',18,'Animation pour enfants',400),
(50,'Description de la mission 19','2025-01-19','2025-01-28','Catégorie A','Matériel 19','Responsable 19',19,'Animation pour enfants',300),
(51,'Description de la mission 20','2025-01-20','2025-01-29','Catégorie B','Matériel 20','Responsable 20',20,'Distribution alimentaire',300),
(52,'Description de la mission 21','2025-01-21','2025-01-30','Catégorie C','Matériel 21','Responsable 21',21,'Nettoyage du parc',100),
(53,'Description de la mission 22','2025-01-22','2025-01-31','Catégorie A','Matériel 22','Responsable 22',22,'Soutien scolaire',400),
(54,'Description de la mission 23','2025-01-23','2025-02-01','Catégorie B','Matériel 23','Responsable 23',23,'Nettoyage du parc',500),
(55,'Description de la mission 24','2025-01-24','2025-02-02','Catégorie C','Matériel 24','Responsable 24',24,'Soutien scolaire',400),
(56,'Description de la mission 25','2025-01-25','2025-02-03','Catégorie A','Matériel 25','Responsable 25',25,'Distribution alimentaire',300),
(57,'Description de la mission 26','2025-01-26','2025-02-04','Catégorie B','Matériel 26','Responsable 26',26,'Soutien scolaire',200),
(58,'Description de la mission 27','2025-01-27','2025-02-05','Catégorie C','Matériel 27','Responsable 27',27,'Nettoyage du parc',500),
(59,'Description de la mission 28','2025-01-28','2025-02-06','Catégorie A','Matériel 28','Responsable 28',28,'Distribution alimentaire',300),
(60,'Description de la mission 29','2025-01-29','2025-02-07','Catégorie B','Matériel 29','Responsable 29',29,'Distribution alimentaire',400),
(61,'Description de la mission 30','2025-01-30','2025-02-18','Catégorie C','Matériel 30','Responsable 30',17,'Soutien Scolaire',300);
/*!40000 ALTER TABLE `MISSION` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `PARTENAIRE`
--

DROP TABLE IF EXISTS `PARTENAIRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `PARTENAIRE` (
  `idPart` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `type_partenaire` varchar(50) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `secteur` varchar(100) NOT NULL,
  `date_debut_partenariat` date DEFAULT NULL,
  PRIMARY KEY (`idPart`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PARTENAIRE`
--

LOCK TABLES `PARTENAIRE` WRITE;
/*!40000 ALTER TABLE `PARTENAIRE` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `PARTENAIRE` VALUES
(1,'Partenaire 1','Entreprise','contact1@example.com','Informatique','2023-01-01'),
(2,'Partenaire 2','Association','contact2@example.com','Santé','2023-01-02'),
(3,'Partenaire 3','Entreprise','contact3@example.com','Finance','2023-01-03'),
(4,'Partenaire 4','ONG','contact4@example.com','Éducation','2023-01-04'),
(5,'Partenaire 5','Association','contact5@example.com','Social','2023-01-05'),
(6,'Partenaire 6','Entreprise','contact6@example.com','Technologie','2023-01-06'),
(7,'Partenaire 7','ONG','contact7@example.com','Environnement','2023-01-07'),
(8,'Partenaire 8','Entreprise','contact8@example.com','Industrie','2023-01-08'),
(9,'Partenaire 9','Association','contact9@example.com','Culture','2023-01-09'),
(10,'Partenaire 10','Entreprise','contact10@example.com','Santé','2023-01-10'),
(11,'Partenaire 11','ONG','contact11@example.com','Finance','2023-01-11'),
(12,'Partenaire 12','Entreprise','contact12@example.com','Éducation','2023-01-12'),
(13,'Partenaire 13','Association','contact13@example.com','Social','2023-01-13'),
(14,'Partenaire 14','Entreprise','contact14@example.com','Technologie','2023-01-14'),
(15,'Partenaire 15','ONG','contact15@example.com','Environnement','2023-01-15'),
(16,'Partenaire 16','Entreprise','contact16@example.com','Industrie','2023-01-16'),
(17,'Partenaire 17','Association','contact17@example.com','Culture','2023-01-17'),
(18,'Partenaire 18','Entreprise','contact18@example.com','Santé','2023-01-18'),
(19,'Partenaire 19','ONG','contact19@example.com','Finance','2023-01-19'),
(20,'Partenaire 20','Entreprise','contact20@example.com','Éducation','2023-01-20'),
(21,'Partenaire 21','Association','contact21@example.com','Social','2023-01-21'),
(22,'Partenaire 22','Entreprise','contact22@example.com','Technologie','2023-01-22'),
(23,'Partenaire 23','ONG','contact23@example.com','Environnement','2023-01-23'),
(24,'Partenaire 24','Entreprise','contact24@example.com','Industrie','2023-01-24'),
(25,'Partenaire 25','Association','contact25@example.com','Culture','2023-01-25'),
(26,'Partenaire 26','Entreprise','contact26@example.com','Santé','2023-01-26'),
(27,'Partenaire 27','ONG','contact27@example.com','Finance','2023-01-27'),
(28,'Partenaire 28','Entreprise','contact28@example.com','Éducation','2023-01-28'),
(29,'Partenaire 29','Association','contact29@example.com','Social','2023-01-29'),
(30,'Partenaire 30','Entreprise','contact30@example.com','Technologie','2023-01-30'),
(31,'Partenaire 31','ONG','contact31@example.com','Environnement','2023-01-31'),
(32,'Partenaire 32','Entreprise','contact32@example.com','Industrie','2023-02-01'),
(33,'Partenaire 33','Association','contact33@example.com','Culture','2023-02-02'),
(34,'Partenaire 34','Entreprise','contact34@example.com','Santé','2023-02-03'),
(35,'Partenaire 35','ONG','contact35@example.com','Finance','2023-02-04'),
(36,'Partenaire 36','Entreprise','contact36@example.com','Éducation','2023-02-05'),
(37,'Partenaire 37','Association','contact37@example.com','Social','2023-02-06'),
(38,'Partenaire 38','Entreprise','contact38@example.com','Technologie','2023-02-07'),
(39,'Partenaire 39','ONG','contact39@example.com','Environnement','2023-02-08'),
(40,'Partenaire 40','Entreprise','contact40@example.com','Industrie','2023-02-09'),
(41,'Partenaire 41','Association','contact41@example.com','Culture','2023-02-10'),
(42,'Partenaire 42','Entreprise','contact42@example.com','Santé','2023-02-11'),
(43,'Partenaire 43','ONG','contact43@example.com','Finance','2023-02-12'),
(44,'Partenaire 44','Entreprise','contact44@example.com','Éducation','2023-02-13'),
(45,'Partenaire 45','Association','contact45@example.com','Social','2023-02-14'),
(46,'Partenaire 46','Entreprise','contact46@example.com','Technologie','2023-02-15'),
(47,'Partenaire 47','ONG','contact47@example.com','Environnement','2023-02-16'),
(48,'Partenaire 48','Entreprise','contact48@example.com','Industrie','2023-02-17'),
(49,'Partenaire 49','Association','contact49@example.com','Culture','2023-02-18'),
(50,'Partenaire 50','Entreprise','contact50@example.com','Santé','2023-02-19'),
(51,'Partenaire 51','ONG','contact51@example.com','Finance','2023-02-20'),
(52,'Partenaire 52','Entreprise','contact52@example.com','Éducation','2023-02-21'),
(53,'Partenaire 53','Association','contact53@example.com','Social','2023-02-22'),
(54,'Partenaire 54','Entreprise','contact54@example.com','Technologie','2023-02-23'),
(55,'Partenaire 55','ONG','contact55@example.com','Environnement','2023-02-24'),
(56,'Partenaire 56','Entreprise','contact56@example.com','Industrie','2023-02-25'),
(57,'Partenaire 57','Association','contact57@example.com','Culture','2023-02-26'),
(58,'Partenaire 58','Entreprise','contact58@example.com','Santé','2023-02-27'),
(59,'Partenaire 59','ONG','contact59@example.com','Finance','2023-02-28'),
(60,'Partenaire 60','Entreprise','contact60@example.com','Éducation','2023-03-01'),
(61,'Partenaire 61','Association','contact61@example.com','Social','2023-03-02'),
(62,'Partenaire 62','Entreprise','contact62@example.com','Technologie','2023-03-03'),
(63,'Partenaire 63','ONG','contact63@example.com','Environnement','2023-03-04'),
(64,'Partenaire 64','Entreprise','contact64@example.com','Industrie','2023-03-05'),
(65,'Partenaire 65','Association','contact65@example.com','Culture','2023-03-06'),
(66,'Partenaire 66','Entreprise','contact66@example.com','Santé','2023-03-07'),
(67,'Partenaire 67','ONG','contact67@example.com','Finance','2023-03-08'),
(68,'Partenaire 68','Entreprise','contact68@example.com','Éducation','2023-03-09'),
(69,'Partenaire 69','Association','contact69@example.com','Social','2023-03-10'),
(70,'Partenaire 70','Entreprise','contact70@example.com','Technologie','2023-03-11'),
(71,'Partenaire 71','ONG','contact71@example.com','Environnement','2023-03-12'),
(72,'Partenaire 72','Entreprise','contact72@example.com','Industrie','2023-03-13'),
(73,'Partenaire 73','Association','contact73@example.com','Culture','2023-03-14'),
(74,'Partenaire 74','Entreprise','contact74@example.com','Santé','2023-03-15'),
(75,'Partenaire 75','ONG','contact75@example.com','Finance','2023-03-16'),
(76,'Partenaire 76','Entreprise','contact76@example.com','Éducation','2023-03-17'),
(77,'Partenaire 77','Association','contact77@example.com','Social','2023-03-18'),
(78,'Partenaire 78','Entreprise','contact78@example.com','Technologie','2023-03-19'),
(79,'Partenaire 79','ONG','contact79@example.com','Environnement','2023-03-20'),
(80,'Partenaire 80','Entreprise','contact80@example.com','Industrie','2023-03-21'),
(81,'Partenaire 81','Association','contact81@example.com','Culture','2023-03-22'),
(82,'Partenaire 82','Entreprise','contact82@example.com','Santé','2023-03-23'),
(83,'Partenaire 83','ONG','contact83@example.com','Finance','2023-03-24'),
(84,'Partenaire 84','Entreprise','contact84@example.com','Éducation','2023-03-25'),
(85,'Partenaire 85','Association','contact85@example.com','Social','2023-03-26'),
(86,'Partenaire 86','Entreprise','contact86@example.com','Technologie','2023-03-27'),
(87,'Partenaire 87','ONG','contact87@example.com','Environnement','2023-03-28'),
(88,'Partenaire 88','Entreprise','contact88@example.com','Industrie','2023-03-29'),
(89,'Partenaire 89','Association','contact89@example.com','Culture','2023-03-30'),
(90,'Partenaire 90','Entreprise','contact90@example.com','Santé','2023-03-31'),
(91,'Partenaire 91','ONG','contact91@example.com','Finance','2023-04-01'),
(92,'Partenaire 92','Entreprise','contact92@example.com','Éducation','2023-04-02'),
(93,'Partenaire 93','Association','contact93@example.com','Social','2023-04-03'),
(94,'Partenaire 94','Entreprise','contact94@example.com','Technologie','2023-04-04'),
(95,'Partenaire 95','ONG','contact95@example.com','Environnement','2023-04-05'),
(96,'Partenaire 96','Entreprise','contact96@example.com','Industrie','2023-04-06'),
(97,'Partenaire 97','Association','contact97@example.com','Culture','2023-04-07'),
(98,'Partenaire 98','Entreprise','contact98@example.com','Santé','2023-04-08'),
(99,'Partenaire 99','ONG','contact99@example.com','Finance','2023-04-09'),
(100,'Partenaire 100','Entreprise','contact100@example.com','Éducation','2023-04-10');
/*!40000 ALTER TABLE `PARTENAIRE` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `PARTICIPE_A_EVENEMENT`
--

DROP TABLE IF EXISTS `PARTICIPE_A_EVENEMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `PARTICIPE_A_EVENEMENT` (
  `idPersonne` int NOT NULL,
  `idEvenement` int NOT NULL,
  `date_inscription` date NOT NULL,
  `presence` tinyint(1) NOT NULL,
  PRIMARY KEY (`idPersonne`,`idEvenement`),
  KEY `idEvenement` (`idEvenement`),
  CONSTRAINT `fk_participe_a_even` FOREIGN KEY (`idPersonne`) REFERENCES `BENEVOLE` (`idPersonne`) ON DELETE CASCADE,
  CONSTRAINT `participe_a_evenement_ibfk_2` FOREIGN KEY (`idEvenement`) REFERENCES `EVENEMENT` (`idEvenement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PARTICIPE_A_EVENEMENT`
--

LOCK TABLES `PARTICIPE_A_EVENEMENT` WRITE;
/*!40000 ALTER TABLE `PARTICIPE_A_EVENEMENT` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `PARTICIPE_A_EVENEMENT` VALUES
(1,101,'2025-01-05',1),
(1,131,'2025-02-04',1),
(2,102,'2025-01-06',0),
(2,132,'2025-02-05',0),
(3,103,'2025-01-07',1),
(3,133,'2025-02-06',1),
(4,104,'2025-01-08',0),
(4,134,'2025-02-07',0),
(5,105,'2025-01-09',1),
(5,135,'2025-02-08',1),
(6,106,'2025-01-10',0),
(6,136,'2025-02-09',0),
(7,107,'2025-01-11',1),
(7,137,'2025-02-10',1),
(8,108,'2025-01-12',0),
(8,138,'2025-02-11',0),
(9,109,'2025-01-13',1),
(9,139,'2025-02-12',1),
(10,110,'2025-01-14',0),
(10,140,'2025-02-13',0),
(11,111,'2025-01-15',1),
(11,141,'2025-02-14',1),
(12,112,'2025-01-16',0),
(12,142,'2025-02-15',0),
(13,113,'2025-01-17',1),
(13,143,'2025-02-16',1),
(14,114,'2025-01-18',0),
(14,144,'2025-02-17',0),
(15,115,'2025-01-19',1),
(15,145,'2025-02-18',1),
(16,116,'2025-01-20',0),
(16,146,'2025-02-19',0),
(17,117,'2025-01-21',1),
(17,147,'2025-02-20',1),
(18,118,'2025-01-22',0),
(18,148,'2025-02-21',0),
(19,119,'2025-01-23',1),
(19,149,'2025-02-22',1),
(20,120,'2025-01-24',0),
(20,150,'2025-02-23',0),
(22,122,'2025-01-26',0),
(22,152,'2025-02-25',0),
(23,123,'2025-01-27',1),
(23,153,'2025-02-26',1),
(24,124,'2025-01-28',0),
(24,154,'2025-02-27',0),
(25,125,'2025-01-29',1),
(25,155,'2025-02-28',1),
(26,126,'2025-01-30',0),
(26,156,'2025-03-01',0),
(27,127,'2025-01-31',1),
(27,157,'2025-03-02',1),
(28,128,'2025-02-01',0),
(28,158,'2025-03-03',0),
(29,129,'2025-02-02',1),
(29,159,'2025-03-04',1),
(30,130,'2025-02-03',0);
/*!40000 ALTER TABLE `PARTICIPE_A_EVENEMENT` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `PERSONNE`
--

DROP TABLE IF EXISTS `PERSONNE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `PERSONNE` (
  `idPersonne` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `mail` varchar(255) NOT NULL DEFAULT '',
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `Profession` varchar(50) DEFAULT NULL,
  `Ville` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idPersonne`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PERSONNE`
--

LOCK TABLES `PERSONNE` WRITE;
/*!40000 ALTER TABLE `PERSONNE` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `PERSONNE` VALUES
(1,'Martin','Lucas','1995-03-12','lucas.martin1@mail.com','0600000001','12 rue Victor Hugo','75002','Designer','Paris'),
(2,'Bernar','Emma','1998-07-22','emma.bernard2@mail.com','0600000000','45 avenue de la République','75002','Gestionnaire','Toulouse'),
(3,'Thomas','Hugo','1992-01-10','hugo.thomas3@mail.com','0600000003','8 rue Pasteur','75001','Analyste','Toulouse'),
(4,'Petit','Lina','2000-11-05','lina.petit4@mail.com','0600000004','19 boulevard Voltaire','75005','Gestionnaire','Marseille'),
(5,'Robert','Noah','1996-09-18','noah.robert5@mail.com','0600000005','27 rue Nationale','75004','Développeur','Lille'),
(6,'Richard','Chloé','1994-06-30','chloe.richard6@mail.com','0600000006','3 place de la Mairie','75003','Analyste','Lyon'),
(7,'Durand','Adam','1999-02-14','adam.durand7@mail.com','0600000007','52 rue Jean Jaurès','75005','Designer','Paris'),
(8,'Dubois','Inès','1997-12-03','ines.dubois8@mail.com','0600000008','10 rue des Lilas','75002','Gestionnaire','Toulouse'),
(9,'Moreau','Louis','1993-05-27','louis.moreau9@mail.com','0600000009','6 avenue Victor Hugo','75002','Analyste','Paris'),
(10,'Laurent','Mila','2001-08-09','mila.laurent10@mail.com','0600000010','41 rue Gambetta','75005','Gestionnaire','Lille'),
(11,'Simon','Ethan','1995-04-11','ethan.simon11@mail.com','0600000011','15 rue Lafayette','75001','Technicien','Toulouse'),
(12,'Michel','Jade','1998-10-21','jade.michel12@mail.com','0600000012','7 rue de Paris','75003','Développeur','Toulouse'),
(13,'Lefevre','Gabriel','1991-01-19','gabriel.lefevre13@mail.com','0600000013','22 rue Anatole France','75004','Analyste','Lille'),
(14,'Leroy','Sarah','1996-06-14','sarah.leroy14@mail.com','0600000014','9 rue des Roses','75005','Analyste','Marseille'),
(15,'Roux','Nathan','1994-03-08','nathan.roux15@mail.com','0600000015','30 boulevard Saint-Michel','75001','Développeur','Toulouse'),
(16,'David','Zoé','2000-12-25','zoe.david16@mail.com','0600000016','18 rue du Bac','75001','Analyste','Toulouse'),
(17,'Bertrand','Tom','1997-09-01','tom.bertrand17@mail.com','0600000017','55 avenue Foch','75001','Analyste','Lille'),
(18,'Morel','Manon','1993-07-17','manon.morel18@mail.com','0600000018','4 rue du Temple','75002','Analyste','Toulouse'),
(19,'Fournier','Léo','1999-11-29','leo.fournier19@mail.com','0600000019','26 rue Oberkampf','75003','Technicien','Paris'),
(20,'Girard','Eva','1995-05-06','eva.girard20@mail.com','0600000020','13 rue de Rennes','75002','Analyste','Marseille'),
(22,'Mercier','Alice','1998-04-15','alice.mercier22@mail.com','0600000022','5 rue des Écoles','75002','Analyste','Toulouse'),
(23,'Blanc','Arthur','1996-08-27','arthur.blanc23@mail.com','0600000023','14 rue Montmartre','75001','Gestionnaire','Marseille'),
(24,'Guerin','Camille','2000-01-30','camille.guerin24@mail.com','0600000024','33 avenue Ledru-Rollin','75004','Designer','Lille'),
(25,'Boyer','Sacha','1994-10-12','sacha.boyer25@mail.com','0600000025','2 rue des Acacias','75004','Analyste','Lille'),
(26,'Garnier','Clara','1997-06-09','clara.garnier26@mail.com','0600000026','29 rue de la Paix','75002','Analyste','Lyon'),
(27,'Chevalier','Maxime','1993-12-19','maxime.chevalier27@mail.com','0600000027','11 rue Vaugirard','75005','Designer','Marseille'),
(28,'Francois','Louise','1999-03-05','louise.francois28@mail.com','0600000028','17 rue Saint-Honoré','75004','Développeur','Toulouse'),
(29,'Legrand','Alex','1995-07-23','alex.legrand29@mail.com','0600000029','40 rue du Faubourg','75001','Développeur','Lyon'),
(30,'Gaillard','Nina','2001-09-14','nina.gaillard30@mail.com','0600000030','6 rue de Sèvres','75002','Technicien','Paris'),
(44,'Imadeddine','Aklouf','2026-01-08','akimadeddine@gmail.com','0744407662','2 rue fr','92400','Etudiant','Paris');
/*!40000 ALTER TABLE `PERSONNE` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `RECOIT_SUBVENTION`
--

DROP TABLE IF EXISTS `RECOIT_SUBVENTION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `RECOIT_SUBVENTION` (
  `idSub` int NOT NULL,
  `idPart` int NOT NULL,
  PRIMARY KEY (`idPart`,`idSub`),
  KEY `idSub` (`idSub`),
  CONSTRAINT `recoit_subvention_ibfk_1` FOREIGN KEY (`idSub`) REFERENCES `SUBVENTION` (`idSub`),
  CONSTRAINT `recoit_subvention_ibfk_2` FOREIGN KEY (`idPart`) REFERENCES `PARTENAIRE` (`idPart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RECOIT_SUBVENTION`
--

LOCK TABLES `RECOIT_SUBVENTION` WRITE;
/*!40000 ALTER TABLE `RECOIT_SUBVENTION` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `RECOIT_SUBVENTION` VALUES
(1,1),
(2,2),
(3,3),
(4,4),
(5,5),
(6,6),
(7,7),
(8,8),
(9,9),
(10,10),
(11,11),
(12,12),
(13,13),
(14,14),
(15,15),
(16,16),
(17,17),
(18,18),
(19,19),
(20,20),
(21,21),
(22,22),
(23,23),
(24,24),
(25,25),
(26,26),
(27,27),
(28,28),
(29,29),
(30,30),
(31,1),
(32,2),
(33,3),
(34,4),
(35,5),
(36,6),
(37,7),
(38,8),
(39,9),
(40,10),
(41,11),
(42,12),
(43,13),
(44,14),
(45,15),
(46,16),
(47,17),
(48,18),
(49,19),
(50,20),
(51,21),
(52,22),
(53,23),
(54,24),
(55,25),
(56,26),
(57,27),
(58,28),
(59,29),
(60,30),
(61,1),
(62,2),
(63,3),
(64,4),
(65,5),
(66,6),
(67,7),
(68,8),
(69,9),
(70,10),
(71,11),
(72,12),
(73,13),
(74,14),
(75,15),
(76,16),
(77,17),
(78,18),
(79,19),
(80,20),
(81,21),
(82,22),
(83,23),
(84,24),
(85,25),
(86,26),
(87,27),
(88,28),
(89,29),
(90,30),
(91,1),
(92,2),
(93,3),
(94,4),
(95,5),
(96,6),
(97,7),
(98,8),
(99,9),
(100,10);
/*!40000 ALTER TABLE `RECOIT_SUBVENTION` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `SIGNE_CONVENTION`
--

DROP TABLE IF EXISTS `SIGNE_CONVENTION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `SIGNE_CONVENTION` (
  `idPart` int NOT NULL,
  `idConv` int NOT NULL,
  PRIMARY KEY (`idPart`,`idConv`),
  KEY `idConv` (`idConv`),
  CONSTRAINT `signe_convention_ibfk_1` FOREIGN KEY (`idConv`) REFERENCES `CONVENTION` (`idConv`),
  CONSTRAINT `signe_convention_ibfk_2` FOREIGN KEY (`idPart`) REFERENCES `PARTENAIRE` (`idPart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SIGNE_CONVENTION`
--

LOCK TABLES `SIGNE_CONVENTION` WRITE;
/*!40000 ALTER TABLE `SIGNE_CONVENTION` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `SIGNE_CONVENTION` VALUES
(1,1),
(11,1),
(21,1),
(2,2),
(12,2),
(22,2),
(3,3),
(13,3),
(23,3),
(4,4),
(14,4),
(24,4),
(5,5),
(15,5),
(25,5),
(6,6),
(16,6),
(26,6),
(7,7),
(17,7),
(27,7),
(8,8),
(18,8),
(28,8),
(9,9),
(19,9),
(29,9),
(10,10),
(20,10),
(30,10),
(1,11),
(11,11),
(21,11),
(2,12),
(12,12),
(22,12),
(3,13),
(13,13),
(23,13),
(4,14),
(14,14),
(24,14),
(5,15),
(15,15),
(25,15),
(6,16),
(16,16),
(26,16),
(7,17),
(17,17),
(27,17),
(8,18),
(18,18),
(28,18),
(9,19),
(19,19),
(29,19),
(10,20),
(20,20),
(30,20),
(11,21),
(21,21),
(12,22),
(22,22),
(13,23),
(23,23),
(14,24),
(24,24),
(15,25),
(25,25),
(16,26),
(26,26),
(17,27),
(27,27),
(18,28),
(28,28),
(19,29),
(29,29),
(20,30),
(30,30),
(1,31),
(21,31),
(2,32),
(22,32),
(3,33),
(23,33),
(4,34),
(24,34),
(5,35),
(25,35),
(6,36),
(26,36),
(7,37),
(27,37),
(8,38),
(28,38),
(9,39),
(29,39),
(10,40),
(30,40),
(1,41),
(11,41),
(2,42),
(12,42),
(3,43),
(13,43),
(4,44),
(14,44),
(5,45),
(15,45),
(6,46),
(16,46),
(7,47),
(17,47),
(8,48),
(18,48),
(9,49),
(19,49),
(10,50),
(20,50);
/*!40000 ALTER TABLE `SIGNE_CONVENTION` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `SOUTIEN`
--

DROP TABLE IF EXISTS `SOUTIEN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `SOUTIEN` (
  `idSoutien` int NOT NULL AUTO_INCREMENT,
  `type_soutien` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`idSoutien`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SOUTIEN`
--

LOCK TABLES `SOUTIEN` WRITE;
/*!40000 ALTER TABLE `SOUTIEN` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `SOUTIEN` VALUES
(1,'Soutien 1','Description du soutien 1'),
(2,'Soutien 2','Description du soutien 2'),
(3,'Soutien 3','Description du soutien 3'),
(4,'Soutien 4','Description du soutien 4'),
(5,'Soutien 5','Description du soutien 5'),
(6,'Soutien 6','Description du soutien 6'),
(7,'Soutien 7','Description du soutien 7'),
(8,'Soutien 8','Description du soutien 8'),
(9,'Soutien 9','Description du soutien 9'),
(10,'Soutien 10','Description du soutien 10'),
(11,'Soutien 11','Description du soutien 11'),
(12,'Soutien 12','Description du soutien 12'),
(13,'Soutien 13','Description du soutien 13'),
(14,'Soutien 14','Description du soutien 14'),
(15,'Soutien 15','Description du soutien 15'),
(16,'Soutien 16','Description du soutien 16'),
(17,'Soutien 17','Description du soutien 17'),
(18,'Soutien 18','Description du soutien 18'),
(19,'Soutien 19','Description du soutien 19'),
(20,'Soutien 20','Description du soutien 20'),
(21,'Soutien 21','Description du soutien 21'),
(22,'Soutien 22','Description du soutien 22'),
(23,'Soutien 23','Description du soutien 23'),
(24,'Soutien 24','Description du soutien 24'),
(25,'Soutien 25','Description du soutien 25'),
(26,'Soutien 26','Description du soutien 26'),
(27,'Soutien 27','Description du soutien 27'),
(28,'Soutien 28','Description du soutien 28'),
(29,'Soutien 29','Description du soutien 29'),
(30,'Soutien 30','Description du soutien 30'),
(31,'Soutien 31','Description du soutien 31'),
(32,'Soutien 32','Description du soutien 32'),
(33,'Soutien 33','Description du soutien 33'),
(34,'Soutien 34','Description du soutien 34'),
(35,'Soutien 35','Description du soutien 35'),
(36,'Soutien 36','Description du soutien 36'),
(37,'Soutien 37','Description du soutien 37'),
(38,'Soutien 38','Description du soutien 38'),
(39,'Soutien 39','Description du soutien 39'),
(40,'Soutien 40','Description du soutien 40'),
(41,'Soutien 41','Description du soutien 41'),
(42,'Soutien 42','Description du soutien 42'),
(43,'Soutien 43','Description du soutien 43'),
(44,'Soutien 44','Description du soutien 44'),
(45,'Soutien 45','Description du soutien 45'),
(46,'Soutien 46','Description du soutien 46'),
(47,'Soutien 47','Description du soutien 47'),
(48,'Soutien 48','Description du soutien 48'),
(49,'Soutien 49','Description du soutien 49'),
(50,'Soutien 50','Description du soutien 50'),
(51,'Soutien 51','Description du soutien 51'),
(52,'Soutien 52','Description du soutien 52'),
(53,'Soutien 53','Description du soutien 53'),
(54,'Soutien 54','Description du soutien 54'),
(55,'Soutien 55','Description du soutien 55'),
(56,'Soutien 56','Description du soutien 56'),
(57,'Soutien 57','Description du soutien 57'),
(58,'Soutien 58','Description du soutien 58'),
(59,'Soutien 59','Description du soutien 59'),
(60,'Soutien 60','Description du soutien 60'),
(61,'Soutien 61','Description du soutien 61'),
(62,'Soutien 62','Description du soutien 62'),
(63,'Soutien 63','Description du soutien 63'),
(64,'Soutien 64','Description du soutien 64'),
(65,'Soutien 65','Description du soutien 65'),
(66,'Soutien 66','Description du soutien 66'),
(67,'Soutien 67','Description du soutien 67'),
(68,'Soutien 68','Description du soutien 68'),
(69,'Soutien 69','Description du soutien 69'),
(70,'Soutien 70','Description du soutien 70'),
(71,'Soutien 71','Description du soutien 71'),
(72,'Soutien 72','Description du soutien 72'),
(73,'Soutien 73','Description du soutien 73'),
(74,'Soutien 74','Description du soutien 74'),
(75,'Soutien 75','Description du soutien 75'),
(76,'Soutien 76','Description du soutien 76'),
(77,'Soutien 77','Description du soutien 77'),
(78,'Soutien 78','Description du soutien 78'),
(79,'Soutien 79','Description du soutien 79'),
(80,'Soutien 80','Description du soutien 80'),
(81,'Soutien 81','Description du soutien 81'),
(82,'Soutien 82','Description du soutien 82'),
(83,'Soutien 83','Description du soutien 83'),
(84,'Soutien 84','Description du soutien 84'),
(85,'Soutien 85','Description du soutien 85'),
(86,'Soutien 86','Description du soutien 86'),
(87,'Soutien 87','Description du soutien 87'),
(88,'Soutien 88','Description du soutien 88'),
(89,'Soutien 89','Description du soutien 89'),
(90,'Soutien 90','Description du soutien 90'),
(91,'Soutien 91','Description du soutien 91'),
(92,'Soutien 92','Description du soutien 92'),
(93,'Soutien 93','Description du soutien 93'),
(94,'Soutien 94','Description du soutien 94'),
(95,'Soutien 95','Description du soutien 95'),
(96,'Soutien 96','Description du soutien 96'),
(97,'Soutien 97','Description du soutien 97'),
(98,'Soutien 98','Description du soutien 98'),
(99,'Soutien 99','Description du soutien 99'),
(100,'Soutien 100','Description du soutien 100');
/*!40000 ALTER TABLE `SOUTIEN` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `subvention`
--

DROP TABLE IF EXISTS `subvention`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `subvention` (
  `idSub` int NOT NULL AUTO_INCREMENT,
  `nom_sub` varchar(100) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `annee` int NOT NULL,
  PRIMARY KEY (`idSub`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subvention`
--

LOCK TABLES `subvention` WRITE;
/*!40000 ALTER TABLE `subvention` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `subvention` VALUES
(1,'Subvention 1',1000.00,2025),
(2,'Subvention 2',1500.50,2023),
(3,'Subvention 3',2000.00,2024),
(4,'Subvention 4',2500.75,2024),
(5,'Subvention 5',3000.00,2025),
(6,'Subvention 6',3500.50,2025),
(7,'Subvention 7',4000.00,2023),
(8,'Subvention 8',4500.25,2023),
(9,'Subvention 9',5000.00,2024),
(10,'Subvention 10',5500.75,2024),
(11,'Subvention 11',6000.00,2025),
(12,'Subvention 12',6500.50,2025),
(13,'Subvention 13',7000.00,2023),
(14,'Subvention 14',7500.25,2023),
(15,'Subvention 15',8000.00,2024),
(16,'Subvention 16',8500.75,2024),
(17,'Subvention 17',9000.00,2025),
(18,'Subvention 18',9500.50,2025),
(19,'Subvention 19',10000.00,2023),
(20,'Subvention 20',10500.25,2023),
(21,'Subvention 21',11000.00,2024),
(22,'Subvention 22',11500.75,2024),
(23,'Subvention 23',12000.00,2025),
(24,'Subvention 24',12500.50,2025),
(25,'Subvention 25',13000.00,2023),
(26,'Subvention 26',13500.25,2023),
(27,'Subvention 27',14000.00,2024),
(28,'Subvention 28',14500.75,2024),
(29,'Subvention 29',15000.00,2025),
(30,'Subvention 30',15500.50,2025),
(31,'Subvention 31',16000.00,2023),
(32,'Subvention 32',16500.25,2023),
(33,'Subvention 33',17000.00,2024),
(34,'Subvention 34',17500.75,2024),
(35,'Subvention 35',18000.00,2025),
(36,'Subvention 36',18500.50,2025),
(37,'Subvention 37',19000.00,2023),
(38,'Subvention 38',19500.25,2023),
(39,'Subvention 39',20000.00,2024),
(40,'Subvention 40',20500.75,2024),
(41,'Subvention 41',21000.00,2025),
(42,'Subvention 42',21500.50,2025),
(43,'Subvention 43',22000.00,2023),
(44,'Subvention 44',22500.25,2023),
(45,'Subvention 45',23000.00,2024),
(46,'Subvention 46',23500.75,2024),
(47,'Subvention 47',24000.00,2025),
(48,'Subvention 48',24500.50,2025),
(49,'Subvention 49',25000.00,2023),
(50,'Subvention 50',25500.25,2023),
(51,'Subvention 51',26000.00,2024),
(52,'Subvention 52',26500.75,2024),
(53,'Subvention 53',27000.00,2025),
(54,'Subvention 54',27500.50,2025),
(55,'Subvention 55',28000.00,2023),
(56,'Subvention 56',28500.25,2023),
(57,'Subvention 57',29000.00,2024),
(58,'Subvention 58',29500.75,2024),
(59,'Subvention 59',30000.00,2025),
(60,'Subvention 60',30500.50,2025),
(61,'Subvention 61',31000.00,2023),
(62,'Subvention 62',31500.25,2023),
(63,'Subvention 63',32000.00,2024),
(64,'Subvention 64',32500.75,2024),
(65,'Subvention 65',33000.00,2025),
(66,'Subvention 66',33500.50,2025),
(67,'Subvention 67',34000.00,2023),
(68,'Subvention 68',34500.25,2023),
(69,'Subvention 69',35000.00,2024),
(70,'Subvention 70',35500.75,2024),
(71,'Subvention 71',36000.00,2025),
(72,'Subvention 72',36500.50,2025),
(73,'Subvention 73',37000.00,2023),
(74,'Subvention 74',37500.25,2023),
(75,'Subvention 75',38000.00,2024),
(76,'Subvention 76',38500.75,2024),
(77,'Subvention 77',39000.00,2025),
(78,'Subvention 78',39500.50,2025),
(79,'Subvention 79',40000.00,2023),
(80,'Subvention 80',40500.25,2023),
(81,'Subvention 81',41000.00,2024),
(82,'Subvention 82',41500.75,2024),
(83,'Subvention 83',42000.00,2025),
(84,'Subvention 84',42500.50,2025),
(85,'Subvention 85',43000.00,2023),
(86,'Subvention 86',43500.25,2023),
(87,'Subvention 87',44000.00,2024),
(88,'Subvention 88',44500.75,2024),
(89,'Subvention 89',45000.00,2025),
(90,'Subvention 90',45500.50,2025),
(91,'Subvention 91',46000.00,2023),
(92,'Subvention 92',46500.25,2023),
(93,'Subvention 93',47000.00,2024),
(94,'Subvention 94',47500.75,2024),
(95,'Subvention 95',48000.00,2025),
(96,'Subvention 96',48500.50,2025),
(97,'Subvention 97',49000.00,2023),
(98,'Subvention 98',49500.25,2023),
(99,'Subvention 99',50000.00,2024),
(100,'Subvention 100',50500.75,2024);
/*!40000 ALTER TABLE `subvention` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `VERSE_COTISATION`
--

DROP TABLE IF EXISTS `VERSE_COTISATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `VERSE_COTISATION` (
  `idPersonne` int NOT NULL,
  `idCot` int NOT NULL,
  `annee` int NOT NULL,
  PRIMARY KEY (`idPersonne`,`idCot`),
  UNIQUE KEY `idPersonne` (`idPersonne`,`annee`),
  KEY `idCot` (`idCot`),
  CONSTRAINT `fk_verse_cotisation` FOREIGN KEY (`idPersonne`) REFERENCES `BENEVOLE` (`idPersonne`) ON DELETE CASCADE,
  CONSTRAINT `verse_cotisation_ibfk_2` FOREIGN KEY (`idCot`) REFERENCES `COTISATION` (`idCot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `VERSE_COTISATION`
--

LOCK TABLES `VERSE_COTISATION` WRITE;
/*!40000 ALTER TABLE `VERSE_COTISATION` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `VERSE_COTISATION` VALUES
(1,1,2020),
(2,2,2020),
(3,3,2020),
(4,4,2020),
(5,5,2020),
(6,6,2020),
(7,7,2020),
(8,8,2020),
(9,9,2020),
(10,10,2020),
(11,11,2020),
(12,12,2020),
(13,13,2020),
(14,14,2020),
(15,15,2020),
(16,16,2020),
(17,17,2020),
(18,18,2020),
(19,19,2020),
(20,20,2020),
(22,22,2020),
(23,23,2020),
(24,24,2020),
(25,25,2020),
(26,26,2020),
(27,27,2020),
(28,28,2020),
(29,29,2020),
(30,30,2020);
/*!40000 ALTER TABLE `VERSE_COTISATION` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-01-08 13:10:33
