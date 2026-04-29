CREATE TABLE admin (
    id_admin INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

INSERT INTO admin (nom, prenom, email, mot_de_passe) VALUES 
('Admin', 'Principal', 'admin@matiere.com', 'admin123');