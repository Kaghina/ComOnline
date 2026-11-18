-- =====================================================================
-- ComOnline - Script de création et de peuplement de la base
-- Compatible MySQL 8 / MariaDB 10+
-- Usage : mysql -u <user> -p <base> < commune.sql
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS SERVICE_COMMUNE;
DROP TABLE IF EXISTS DEMANDE_SIGNALEMENT;
DROP TABLE IF EXISTS LIEU;
DROP TABLE IF EXISTS DEMANDE_ETAT_CIVIL;
DROP TABLE IF EXISTS DEMANDE_UNION_CIVILE;
DROP TABLE IF EXISTS DEMANDE_ELECTIONS;
DROP TABLE IF EXISTS BUREAU_DE_VOTE;
DROP TABLE IF EXISTS DEMANDE_SCOLAIRE;
DROP TABLE IF EXISTS DEMANDE_RESTAURATION;
DROP TABLE IF EXISTS ENFANT;
DROP TABLE IF EXISTS CANTINE;
DROP TABLE IF EXISTS ECOLE;
DROP TABLE IF EXISTS JUSTIFICATIF;
DROP TABLE IF EXISTS SERVICE;
DROP TABLE IF EXISTS CITOYEN;
DROP TABLE IF EXISTS COMMUNE;
DROP TABLE IF EXISTS DEPARTEMENT;
DROP TABLE IF EXISTS REGION;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------
-- Création des tables
-- ---------------------------------------------------------------------

-- Table REGION
CREATE TABLE REGION (
    ID_Region INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255)
);

-- Table DEPARTEMENT
CREATE TABLE DEPARTEMENT (
    ID_Departement INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    ID_Region INT,
    FOREIGN KEY (ID_Region) REFERENCES REGION(ID_Region)
);

-- Table COMMUNE
CREATE TABLE COMMUNE (
    ID_Commune INT PRIMARY KEY AUTO_INCREMENT,
    code_INSEE VARCHAR(10),
    code_postal VARCHAR(10),
    latitude FLOAT,
    longitude FLOAT,
    Nom VARCHAR(255),
    ID_Departement INT,
    FOREIGN KEY (ID_Departement) REFERENCES DEPARTEMENT(ID_Departement)
);

-- Table CITOYEN
CREATE TABLE CITOYEN (
    ID_Citoyen INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255),
    nom VARCHAR(255),
    prenom VARCHAR(255),
    adresse VARCHAR(255),
    date_naissance DATE,
    tel VARCHAR(20),
    ID_Commune INT,
    FOREIGN KEY (ID_Commune) REFERENCES COMMUNE(ID_Commune)
);

-- Table SERVICE
CREATE TABLE SERVICE (
    ID_Service INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(255),
    description TEXT
);

-- Table JUSTIFICATIF
CREATE TABLE JUSTIFICATIF (
    ID_Justificatif INT PRIMARY KEY AUTO_INCREMENT,
    numero VARCHAR(50),
    type VARCHAR(255),
    description TEXT,
    chemin_fichier VARCHAR(255)
);

-- Table ECOLE
CREATE TABLE ECOLE (
    ID_Ecole INT PRIMARY KEY AUTO_INCREMENT,
    nom_Ecole VARCHAR(255),
    adresse VARCHAR(255),
    nombre_classes INT,
    ID_Commune INT,
    FOREIGN KEY (ID_Commune) REFERENCES COMMUNE(ID_Commune)
);

-- Table CANTINE
CREATE TABLE CANTINE (
    ID_Cantine INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    adresse VARCHAR(255),
    nombre_places INT,
    ID_Ecole INT,
    coordonnees_geographiques VARCHAR(255),
    FOREIGN KEY (ID_Ecole) REFERENCES ECOLE(ID_Ecole)
);

-- Table ENFANT
CREATE TABLE ENFANT (
    ID_Enfant INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    quotient_familial INT
);

-- Table DEMANDE_RESTAURATION
CREATE TABLE DEMANDE_RESTAURATION (
    ID_Service INT,
    ID_Enfant INT,
    message VARCHAR(255),
    date_debut DATE,
    date_fin DATE,
    ID_Cantine INT,
    tarifs_reduits BOOLEAN,
    ID_Justificatif INT,
    PRIMARY KEY (ID_Service, ID_Enfant),
    FOREIGN KEY (ID_Service) REFERENCES SERVICE(ID_Service),
    FOREIGN KEY (ID_Enfant) REFERENCES ENFANT(ID_Enfant),
    FOREIGN KEY (ID_Cantine) REFERENCES CANTINE(ID_Cantine),
    FOREIGN KEY (ID_Justificatif) REFERENCES JUSTIFICATIF(ID_Justificatif)
);

-- Table DEMANDE_SCOLAIRE
CREATE TABLE DEMANDE_SCOLAIRE (
    ID_Service INT,
    message TEXT,
    nom_contact VARCHAR(255),
    tel_contact VARCHAR(20),
    ID_Enfant INT,
    ID_Ecole INT,
    ID_Justificatif INT,
    premiere_inscription BOOLEAN,
    PRIMARY KEY (ID_Enfant, ID_Ecole),
    FOREIGN KEY (ID_Service) REFERENCES SERVICE(ID_Service),
    FOREIGN KEY (ID_Enfant) REFERENCES ENFANT(ID_Enfant),
    FOREIGN KEY (ID_Ecole) REFERENCES ECOLE(ID_Ecole),
    FOREIGN KEY (ID_Justificatif) REFERENCES JUSTIFICATIF(ID_Justificatif)
);

-- Table BUREAU_DE_VOTE
CREATE TABLE BUREAU_DE_VOTE (
    ID_Bureau INT PRIMARY KEY,
    nom_bureau VARCHAR(255),
    ID_Commune INT,
    FOREIGN KEY (ID_Commune) REFERENCES COMMUNE(ID_Commune)
);

-- Table DEMANDE_ELECTIONS
CREATE TABLE DEMANDE_ELECTIONS (
    ID_Service INT,
    message TEXT,
    ID_Bureau INT,
    ID_Citoyen INT,
    ID_Justificatif INT,
    PRIMARY KEY (ID_Service, ID_Citoyen),
    FOREIGN KEY (ID_Service) REFERENCES SERVICE(ID_Service),
    FOREIGN KEY (ID_Bureau) REFERENCES BUREAU_DE_VOTE(ID_Bureau),
    FOREIGN KEY (ID_Citoyen) REFERENCES CITOYEN(ID_Citoyen),
    FOREIGN KEY (ID_Justificatif) REFERENCES JUSTIFICATIF(ID_Justificatif)
);

-- Table DEMANDE_UNION_CIVILE
CREATE TABLE DEMANDE_UNION_CIVILE (
    ID_Service INT,
    type_union VARCHAR(255),
    date DATE,
    ID_Citoyen1 INT,
    ID_Citoyen2 INT,
    ID_Justificatif INT,
    PRIMARY KEY (ID_Service, ID_Citoyen1, ID_Citoyen2),
    FOREIGN KEY (ID_Service) REFERENCES SERVICE(ID_Service),
    FOREIGN KEY (ID_Citoyen1) REFERENCES CITOYEN(ID_Citoyen),
    FOREIGN KEY (ID_Citoyen2) REFERENCES CITOYEN(ID_Citoyen),
    FOREIGN KEY (ID_Justificatif) REFERENCES JUSTIFICATIF(ID_Justificatif)
);

-- Table DEMANDE_ETAT_CIVIL
CREATE TABLE DEMANDE_ETAT_CIVIL (
    ID_Service INT,
    date DATE,
    message TEXT,
    type_document VARCHAR(255),
    date_disponibilite DATE,
    ID_Citoyen INT,
    ID_Justificatif INT,
    PRIMARY KEY (ID_Service, ID_Citoyen),
    FOREIGN KEY (ID_Service) REFERENCES SERVICE(ID_Service),
    FOREIGN KEY (ID_Citoyen) REFERENCES CITOYEN(ID_Citoyen),
    FOREIGN KEY (ID_Justificatif) REFERENCES JUSTIFICATIF(ID_Justificatif)
);

-- Table LIEU
CREATE TABLE LIEU (
    ID_Lieu INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    type VARCHAR(50),
    coordonnees_geographiques VARCHAR(255)
);

-- Table DEMANDE_SIGNALEMENT
CREATE TABLE DEMANDE_SIGNALEMENT (
    ID_Service INT,
    Description TEXT,
    Date_Signalement DATE,
    ID_Lieu INT,
    ID_Citoyen INT,
    ID_Justificatif INT,
    PRIMARY KEY (ID_Service, ID_Citoyen),
    FOREIGN KEY (ID_Lieu) REFERENCES LIEU(ID_Lieu),
    FOREIGN KEY (ID_Service) REFERENCES SERVICE(ID_Service),
    FOREIGN KEY (ID_Citoyen) REFERENCES CITOYEN(ID_Citoyen),
    FOREIGN KEY (ID_Justificatif) REFERENCES JUSTIFICATIF(ID_Justificatif)
);

-- Table SERVICE_COMMUNE
CREATE TABLE SERVICE_COMMUNE (
    ID_Service INT,
    ID_Commune INT,
    periode_ouverture VARCHAR(255),
    Gratuit BOOLEAN,
    PRIMARY KEY (ID_Service, ID_Commune),
    FOREIGN KEY (ID_Service) REFERENCES SERVICE(ID_Service),
    FOREIGN KEY (ID_Commune) REFERENCES COMMUNE(ID_Commune)
);

-- ---------------------------------------------------------------------
-- Insertion des données
-- ---------------------------------------------------------------------

-- Région
INSERT INTO REGION (ID_Region, nom)
VALUES (84, 'Auvergne-Rhône-Alpes');

-- Départements
INSERT INTO DEPARTEMENT (ID_Departement, nom, ID_Region)
VALUES
(1, 'Ain', 84),
(2, 'Allier', 84),
(3, 'Ardèche', 84),
(4, 'Cantal', 84),
(5, 'Drôme', 84),
(6, 'Isère', 84),
(7, 'Loire', 84),
(8, 'Haute-Loire', 84),
(9, 'Puy-de-Dôme', 84),
(10, 'Rhône', 84),
(11, 'Savoie', 84),
(12, 'Haute-Savoie', 84);

-- Communes (échantillon de communes réelles de la région)
-- NB : à l'origine les communes étaient importées depuis une base externe
-- (dataset.Communes) qui n'existe pas hors du serveur de la fac.
INSERT INTO COMMUNE (ID_Commune, code_INSEE, code_postal, latitude, longitude, Nom, ID_Departement)
VALUES
(1,  '69123', '69001', 45.7640, 4.8357, 'Lyon', 10),
(2,  '69266', '69100', 45.7719, 4.8902, 'Villeurbanne', 10),
(3,  '38185', '38000', 45.1885, 5.7245, 'Grenoble', 6),
(4,  '42218', '42000', 45.4397, 4.3872, 'Saint-Étienne', 7),
(5,  '63113', '63000', 45.7772, 3.0870, 'Clermont-Ferrand', 9),
(6,  '74010', '74000', 45.8992, 6.1294, 'Annecy', 12),
(7,  '73065', '73000', 45.5646, 5.9178, 'Chambéry', 11),
(8,  '26362', '26000', 44.9334, 4.8924, 'Valence', 5),
(9,  '01053', '01000', 46.2052, 5.2255, 'Bourg-en-Bresse', 1),
(10, '38544', '38200', 45.5256, 4.8744, 'Vienne', 6),
(11, '69259', '69200', 45.6973, 4.8858, 'Vénissieux', 10),
(12, '03190', '03000', 46.5660, 3.3330, 'Moulins', 2),
(13, '03310', '03200', 46.1278, 3.4259, 'Vichy', 2),
(14, '07186', '07000', 44.7353, 4.5990, 'Privas', 3),
(15, '15014', '15000', 44.9264, 2.4397, 'Aurillac', 4),
(16, '43157', '43000', 45.0434, 3.8858, 'Le Puy-en-Velay', 8),
(17, '42187', '42300', 46.0340, 4.0726, 'Roanne', 7),
(18, '26198', '26200', 44.5581, 4.7509, 'Montélimar', 5),
(19, '74012', '74100', 46.1934, 6.2342, 'Annemasse', 12),
(20, '73008', '73100', 45.6886, 5.9153, 'Aix-les-Bains', 11),
(21, '63300', '63200', 45.8936, 3.1128, 'Riom', 9),
(22, '01283', '01100', 46.2561, 5.6556, 'Oyonnax', 1);

-- Citoyens
INSERT INTO CITOYEN (email, nom, prenom, adresse, date_naissance, tel, ID_Commune)
VALUES
('DoeJohn@example.com', 'Doe', 'John', '123 Main St', '1990-05-15', '123-456-7890', 4),
('SmithJane@example.com', 'Smith', 'Jane', '456 Oak St', '1985-08-22', '987-654-3210', 2),
('JohnsonBob@example.com', 'Johnson', 'Bob', '789 Elm St', '1978-03-10', '555-123-4567', 9),
('WilliamsAlice@example.com', 'Williams', 'Alice', '101 Pine St', '1992-12-01', '111-222-3333', 1),
('JonesChris@example.com', 'Jones', 'Chris', '202 Cedar St', '1980-07-18', '999-888-7777', 8),
('DavisEmily@example.com', 'Davis', 'Emily', '303 Maple St', '1987-09-25', '444-333-2222', 6),
('BrownAlex@example.com', 'Brown', 'Alex', '404 Birch St', '1995-02-28', '777-666-5555', 10),
('MillerEva@example.com', 'Miller', 'Eva', '505 Walnut St', '1982-11-05', '333-444-5555', 5),
('WilsonMax@example.com', 'Wilson', 'Max', '606 Spruce St', '1975-06-12', '666-777-8888', 3),
('MooreLily@example.com', 'Moore', 'Lily', '707 Pineapple St', '1998-04-07', '222-111-9999', 1),
('TaylorNoah@example.com', 'Taylor', 'Noah', '12 Rue de la République', '1991-01-20', '600-100-2000', 1),
('AndersonMia@example.com', 'Anderson', 'Mia', '34 Avenue Jean Jaurès', '1993-03-14', '600-100-2001', 1),
('ThomasLeo@example.com', 'Thomas', 'Leo', '8 Place Bellecour', '1988-06-30', '600-100-2002', 2),
('JacksonZoe@example.com', 'Jackson', 'Zoe', '21 Cours Lafayette', '1990-09-09', '600-100-2003', 2),
('WhiteHugo@example.com', 'White', 'Hugo', '5 Rue Victor Hugo', '1984-12-24', '600-100-2004', 3),
('HarrisLina@example.com', 'Harris', 'Lina', '17 Boulevard Gambetta', '1986-02-11', '600-100-2005', 3),
('MartinTom@example.com', 'Martin', 'Tom', '3 Rue Pasteur', '1979-07-07', '600-100-2006', 1),
('GarciaInes@example.com', 'Garcia', 'Ines', '9 Rue Pasteur', '1981-10-01', '600-100-2007', 1),
('LeeSam@example.com', 'Lee', 'Sam', '44 Quai Saint-Antoine', '1996-05-05', '600-100-2008', 5),
('ClarkNina@example.com', 'Clark', 'Nina', '2 Rue du Lac', '1997-08-18', '600-100-2009', 6);

-- Services
INSERT INTO SERVICE (libelle, description)
VALUES
    ('Service État Civil', 'Service chargé des demandes liées à l\'état civil.'),
    ('Service Union Civile', 'Service chargé des demandes liées à l\'union civile.'),
    ('Service Signalement', 'Service chargé de la réception des signalements citoyens.'),
    ('Service Restauration', 'Service chargé des demandes liées à la restauration scolaire.'),
    ('Service Scolarité', 'Service chargé des demandes liées à la scolarité.'),
    ('Service Élection', 'Service chargé des demandes liées aux élections.');

-- Justificatifs (doivent exister avant les demandes qui les référencent)
INSERT INTO JUSTIFICATIF (numero, type, description, chemin_fichier)
VALUES
    ('JF001', 'Identité', 'Carte identité', '/chemin/vers/fichier1.pdf'),
    ('JF002', 'Scolarité', 'Bulletin scolaire', '/chemin/vers/fichier2.pdf'),
    ('JF003', 'Domicile', 'Justificatif de domicile', '/chemin/vers/fichier3.pdf'),
    ('JF004', 'Mariage', 'Acte de mariage', '/chemin/vers/fichier4.pdf'),
    ('JF005', 'Décès', 'Certificat de décès', '/chemin/vers/fichier5.pdf'),
    ('JF006', 'Signalement', 'Photos du signalement', '/chemin/vers/fichier6.pdf'),
    ('JF007', 'Restauration', 'Attestation de tarif réduit', '/chemin/vers/fichier7.pdf'),
    ('JF008', 'Élections', 'Carte électorale', '/chemin/vers/fichier8.pdf'),
    ('JF009', 'Union civile', 'Déclaration de PACS', '/chemin/vers/fichier9.pdf'),
    ('JF010', 'État civil', 'Acte de naissance', '/chemin/vers/fichier10.pdf');

-- Bureaux de vote
INSERT INTO BUREAU_DE_VOTE (ID_Bureau, nom_bureau, ID_Commune)
VALUES
    (1, 'Bureau Étoile', 4),
    (2, 'Bureau Horizon', 2),
    (3, 'Bureau Lumière', 9),
    (4, 'Bureau Renaissance', 1),
    (5, 'Bureau Cascade', 8),
    (6, 'Bureau Harmonie', 6),
    (7, 'Bureau Aventure', 10),
    (8, 'Bureau Innovation', 3),
    (9, 'Bureau Sérénité', 5),
    (10, 'Bureau Fusion', 1);

-- Services proposés par les communes
INSERT INTO SERVICE_COMMUNE (ID_Service, ID_Commune, Gratuit, periode_ouverture)
VALUES
    (1, 4, 1, 'Janvier-Février'),
    (2, 2, 0, 'Février-Mars'),
    (3, 9, 1, 'Mars-Avril'),
    (4, 1, 0, 'Avril-Mai'),
    (5, 8, 1, 'Mai-Juin'),
    (6, 6, 1, 'Juin-Juillet'),
    (1, 10, 0, 'Juillet-Août'),
    (5, 3, 1, 'Août-Septembre'),
    (1, 5, 0, 'Septembre-Octobre'),
    (5, 1, 0, 'Octobre-Novembre');

-- Lieux
INSERT INTO LIEU (nom, type, coordonnees_geographiques)
VALUES
('Mairie Centrale', 'Administration', '45.764043, 4.835659'),
('Parc Municipal', 'Parc', '45.7745, 4.8530'),
('Centre Commercial', 'Commerce', '45.7606, 4.8578'),
('Bibliothèque Municipale', 'Culture', '45.7606, 4.8590'),
('Stade Municipal', 'Sport', '45.7653, 4.9822'),
('Cinéma du Centre', 'Divertissement', '45.7578, 4.8320'),
('Jardin Public', 'Parc', '45.7700, 4.8500'),
('Salle de Concert', 'Culture', '45.7480, 4.8270'),
('Place du Marché', 'Commerce', '45.7640, 4.8400'),
('Plage Municipale', 'Loisirs', '45.8992, 6.1400');

-- Écoles
INSERT INTO ECOLE (nom_Ecole, adresse, nombre_classes, ID_Commune)
VALUES
    ('École du Soleil', '123 Rue Principale', 20, 1),
    ('École des Étoiles', '456 Avenue des Chênes', 15, 2),
    ('École Arc-en-Ciel', '789 Chemin des Érables', 18, 1),
    ('École de la Vallée', '321 Route des Ormes', 25, 3),
    ('École des Lumières', '654 Boulevard des Pins', 22, 2),
    ('École Aurore', '987 Allée des Cèdres', 17, 3),
    ('École de la Montagne', '111 Cercle des Sapins', 30, 1),
    ('École du Bois', '222 Cour des Bouleaux', 14, 2),
    ('École Rivière Rouge', '333 Cour des Séquoias', 21, 3),
    ('École Printemps', '444 Chemin des Sapins Rouges', 19, 1);

-- Cantines
INSERT INTO CANTINE (nom, adresse, nombre_places, ID_Ecole, coordonnees_geographiques)
VALUES
    ('La Bonne Fourchette', '123 Rue Principale', 100, 2, '45.6789,4.8901'),
    ('Cuisine Scolaire Express', '456 Avenue des Chênes', 80, 3, '45.7890,4.9012'),
    ('Délices Éducatifs', '789 Chemin des Érables', 120, 1, '45.8901,4.0123'),
    ('Gourmandise en Herbe', '321 Route des Ormes', 150, 2, '45.9012,5.1234'),
    ('École Gourmet', '654 Boulevard des Pins', 90, 1, '45.0123,5.2345'),
    ('La Petite Cantine', '987 Allée des Cèdres', 80, 3, '45.1234,5.3456'),
    ('Saveurs Scolaires', '111 Cercle des Sapins', 120, 2, '45.2345,5.4567'),
    ('Le Coin Gourmand', '222 Cour des Bouleaux', 100, 1, '45.3456,5.5678'),
    ('Cantine des Petits Chefs', '333 Cour des Séquoias', 80, 3, '45.4567,5.6789'),
    ('Gastronomie Scolaire', '444 Chemin des Sapins Rouges', 110, 2, '45.5678,5.7890');

-- Enfants
INSERT INTO ENFANT (nom, prenom, quotient_familial)
VALUES
    ('Dupont', 'Alice', 120),
    ('Martin', 'Louis', 90),
    ('Lefevre', 'Sophie', 110),
    ('Dubois', 'Pierre', 80),
    ('Moreau', 'Emma', 95),
    ('Girard', 'Lucas', 105),
    ('Lemoine', 'Julie', 115),
    ('Leclerc', 'Antoine', 100),
    ('Bertrand', 'Camille', 85),
    ('Roux', 'Mathieu', 75),
    ('Dupont', 'Alice', 180),
    ('Martin', 'Louis', 190),
    ('Lefevre', 'Sophie', 150),
    ('Dubois', 'Pierre', 80);

-- Demandes de restauration
INSERT INTO DEMANDE_RESTAURATION (ID_Service, ID_Enfant, message, date_debut, date_fin, ID_Cantine, tarifs_reduits, ID_Justificatif)
VALUES
    (4, 1, 'Demande de repas mensuel', '2023-12-05', '2024-01-05', 1, 1, 1),
    (4, 2, 'Demande de repas quotidien', '2023-12-02', '2024-02-06', 2, 0, 2),
    (4, 3, 'Demande de repas hebdomadaire', '2023-12-03', '2024-12-07', 3, 1, 3),
    (4, 4, 'Demande de repas occasionnel', '2023-12-04', '2023-12-08', 4, 0, 4),
    (4, 5, 'Demande de repas annuel', '2024-01-05', '2024-12-09', 5, 1, 5),
    (4, 6, 'Demande de repas mensuel', '2023-12-06', '2024-01-06', 6, 0, 6),
    (4, 7, 'Demande de repas quotidien', '2023-12-07', '2023-12-11', 7, 1, 7),
    (4, 8, 'Demande de repas hebdomadaire', '2023-12-08', '2023-12-12', 8, 0, 8),
    (4, 9, 'Demande de repas occasionnel', '2023-12-09', '2023-12-13', 9, 1, 9),
    (4, 10, 'Demande de repas annuel', '2023-12-10', '2023-12-14', 10, 0, 10);

-- Demandes d'inscription sur les listes électorales
INSERT INTO DEMANDE_ELECTIONS (ID_Service, message, ID_Bureau, ID_Citoyen, ID_Justificatif)
VALUES
    (6, 'Inscription pour les élections municipales', 1, 1, 1),
    (6, 'Changement de lieu de vote', 2, 2, 2),
    (6, 'Informations sur les candidats', 3, 3, 3),
    (6, 'Procuration pour voter', 4, 4, 4),
    (6, 'Inscription pour les élections régionales', 5, 5, 5),
    (6, 'Renseignements sur le processus électoral', 6, 6, 6),
    (6, 'Changement adresse pour les élections', 7, 7, 7),
    (6, 'Assistance pour les personnes handicapées', 8, 8, 8),
    (6, 'Inscription pour les élections présidentielles', 9, 9, 9),
    (6, 'Renouvellement de carte électeur', 10, 10, 10),
    (6, 'Première inscription', 4, 11, 1),
    (6, 'Changement de bureau', 10, 12, 2);

-- Demandes d'état civil
INSERT INTO DEMANDE_ETAT_CIVIL (ID_Service, date, message, type_document, date_disponibilite, ID_Citoyen, ID_Justificatif)
VALUES
    (1, '2023-12-01', 'Demande acte de naissance', 'Acte de Naissance', '2023-12-10', 1, 1),
    (1, '2023-12-02', 'Demande acte de mariage', 'Acte de Mariage', '2023-12-11', 2, 2),
    (1, '2023-12-03', 'Demande acte de décès', 'Acte de Décès', '2023-12-12', 3, 3),
    (1, '2023-12-04', 'Demande de certificat de célibat', 'Certificat de Célibat', '2023-12-13', 4, 4),
    (1, '2023-12-05', 'Demande de duplicata de livret de famille', 'Duplicata de Livret de Famille', '2023-12-14', 5, 5),
    (1, '2023-12-06', 'Demande de changement de prénom', 'Changement de Prénom', '2023-12-15', 6, 6),
    (1, '2023-12-07', 'Demande de reconnaissance anticipée de paternité', 'Reconnaissance Anticipée de Paternité', '2023-12-16', 7, 7),
    (1, '2023-12-08', 'Demande de rectification état civil', 'Rectification État Civil', '2023-12-17', 8, 8),
    (1, '2023-12-09', 'Demande acte de divorce', 'Acte de Divorce', '2023-12-18', 9, 9),
    (1, '2023-12-10', 'Demande de changement de nom', 'Changement de Nom', '2023-12-19', 10, 10);

-- Demandes scolaires
INSERT INTO DEMANDE_SCOLAIRE (ID_Service, message, nom_contact, tel_contact, ID_Enfant, ID_Ecole, ID_Justificatif, premiere_inscription)
VALUES
    (5, 'Inscription pour la rentrée scolaire', 'Mme Dupont', '123-456-7890', 1, 1, 1, true),
    (5, 'Demande de changement école', 'M. Martin', '987-654-3210', 2, 2, 2, false),
    (5, 'Demande information sur les fournitures scolaires', 'Mme Johnson', '555-123-4567', 3, 3, 3, true),
    (5, 'Inscription pour un programme spécialisé', 'M. Smith', '111-222-3333', 4, 4, 4, false),
    (5, 'Demande de bourse scolaire', 'Mme Davis', '999-888-7777', 5, 5, 5, true),
    (5, 'Demande de report de rentrée scolaire', 'M. Wilson', '444-333-2222', 6, 6, 6, false),
    (5, 'Inscription pour une activité parascolaire', 'Mme Moore', '777-666-5555', 7, 7, 7, true),
    (5, 'Demande de soutien éducatif', 'M. Brown', '222-111-9999', 8, 8, 8, false),
    (5, 'Demande de changement de classe', 'Mme Miller', '333-444-5555', 9, 9, 9, true),
    (5, 'Demande de justificatif pour absence prolongée', 'M. Jones', '666-777-8888', 10, 10, 10, false),
    (5, 'Inscription pour une activité parascolaire', 'Mme Moore', '777-666-5555', 11, 7, 7, true),
    (5, 'Demande de soutien éducatif', 'M. Brown', '222-111-9999', 12, 8, 8, false),
    (5, 'Demande de changement de classe', 'Mme Miller', '333-444-5555', 13, 9, 9, true),
    (5, 'Demande de justificatif pour absence prolongée', 'M. Jones', '666-777-8888', 14, 10, 10, false);

-- Demandes d'union civile
INSERT INTO DEMANDE_UNION_CIVILE (ID_Service, type_union, date, ID_Citoyen1, ID_Citoyen2, ID_Justificatif)
VALUES
    (2, 'Mariage', '2023-12-01', 1, 2, 1),
    (2, 'PACS', '2023-12-02', 3, 4, 2),
    (2, 'Mariage', '2023-12-03', 5, 6, 3),
    (2, 'PACS', '2023-12-04', 7, 8, 4),
    (2, 'Mariage', '2023-12-05', 9, 10, 5),
    (2, 'PACS', '2023-12-06', 11, 12, 6),
    (2, 'Mariage', '2023-12-07', 13, 14, 7),
    (2, 'PACS', '2023-12-08', 15, 16, 8),
    (2, 'Mariage', '2023-12-09', 17, 18, 9),
    (2, 'PACS', '2023-12-10', 19, 20, 10);

-- Signalements
INSERT INTO DEMANDE_SIGNALEMENT (ID_Service, Description, Date_Signalement, ID_Lieu, ID_Citoyen, ID_Justificatif)
VALUES
    (3, 'Déchets non ramassés dans le quartier', '2023-12-01', 1, 1, 1),
    (3, 'Nid de frelons à proximité du parc', '2023-12-02', 2, 2, 2),
    (3, 'Problème éclairage public dans la rue', '2023-12-03', 3, 3, 3),
    (3, 'Dégradation des espaces verts du quartier', '2023-12-04', 4, 4, 4),
    (3, 'Trou dans la chaussée au carrefour principal', '2023-12-05', 5, 5, 5),
    (3, 'Graffiti sur les murs du centre-ville', '2023-12-06', 6, 6, 6),
    (3, 'Feu de circulation hors service', '2023-12-07', 7, 7, 7),
    (3, 'Bancs publics endommagés dans le parc', '2023-12-08', 8, 8, 8),
    (3, 'Déversement de déchets dans la rivière', '2023-12-09', 9, 9, 9),
    (3, 'Vandalisme sur les panneaux de signalisation', '2023-12-10', 10, 10, 10);
