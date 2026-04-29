create database matiere;
use matiere;
-- Création des tables
CREATE TABLE Parcours (
    id_parcours INT PRIMARY KEY AUTO_INCREMENT,
    nom_parcours VARCHAR(100) NOT NULL,
    responsable VARCHAR(100)
);

CREATE TABLE Semestre (
    id_semestre INT PRIMARY KEY,
    nom_semestre VARCHAR(50)
);

CREATE TABLE UniteEnseignement (
    code_ue VARCHAR(10) PRIMARY KEY,
    intitule VARCHAR(255) NOT NULL,
    credits INT NOT NULL
);

-- Table de liaison pour gérer le programme par parcours et semestre
CREATE TABLE Programme (
    id_programme INT PRIMARY KEY AUTO_INCREMENT,
    id_parcours INT,
    id_semestre INT,
    code_ue VARCHAR(10),
    est_optionnel BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_parcours) REFERENCES Parcours(id_parcours),
    FOREIGN KEY (id_semestre) REFERENCES Semestre(id_semestre),
    FOREIGN KEY (code_ue) REFERENCES UniteEnseignement(code_ue)
);

-- Insertion des Parcours
INSERT INTO Parcours (nom_parcours, responsable) VALUES 
('Développement', 'Razafinjoelina Tahina'),
('Bases de Données et Réseaux', 'Rakotomalala Vahatriniaina'),
('Web et Design', 'Rabenanahary Rojo');

-- Insertion des Semestres
INSERT INTO Semestre (id_semestre, nom_semestre) VALUES (3, 'Semestre 3'), (4, 'Semestre 4');

-- Insertion d'un échantillon d'Unités d'Enseignement (Semestre 3)
INSERT INTO UniteEnseignement (code_ue, intitule, credits) VALUES 
('INF201', 'Programmation orientée objet', 6),
('INF202', 'Bases de données objets', 6),
('INF203', 'Programmation système', 4),
('INF208', 'Réseaux informatiques', 6),
('MTH201', 'Méthodes numériques', 4),
('ORG201', 'Bases de gestion', 4);

-- Liaison Programme pour le Semestre 3 (Commun à tous les parcours selon le document)
INSERT INTO Programme (id_semestre, code_ue, est_optionnel) VALUES 
(3, 'INF201', FALSE),
(3, 'INF202', FALSE),
(3, 'INF203', FALSE),
(3, 'INF208', FALSE),
(3, 'MTH201', FALSE),
(3, 'ORG201', FALSE);