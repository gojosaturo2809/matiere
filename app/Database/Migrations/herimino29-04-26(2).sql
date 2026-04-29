CREATE TABLE Etudiant (
    id_etudiant INT PRIMARY KEY AUTO_INCREMENT,
    ETU INT NOT NULL UNIQUE, -- Numéro matricule
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE,
    id_parcours INT, -- Pour la liaison avec les parcours[cite: 3]
    date_inscription DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (id_parcours) REFERENCES Parcours(id_parcours)
);

INSERT INTO Etudiant (ETU, nom, prenom, email) 
VALUES 
(20241001, 'Dupont', 'Jean', 'jean.dupont@example.com'),
(20241002, 'Martin', 'Marie', 'marie.martin@example.com');