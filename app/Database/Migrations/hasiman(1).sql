INSERT INTO Etudiant (ETU, nom, prenom, email, id_parcours) VALUES
(24001, 'Rakotoarisoa', 'Andry', 'andry.rakotoarisoa@matiere.mg', 1),
(24002, 'Rabe', 'Miora', 'miora.rabe@matiere.mg', 2),
(24003, 'Razafindrakoto', 'Hery', 'hery.razafindrakoto@matiere.mg', 1),
(24004, 'Randrianasolo', 'Lalao', 'lalao.randrianasolo@matiere.mg', 3),
(24005, 'Razanadrakoto', 'Tiana', 'tiana.razanadrakoto@matiere.mg', 2);

CREATE TABLE Note (
    id_note INT PRIMARY KEY AUTO_INCREMENT,
    id_etudiant INT NOT NULL,
    code_ue VARCHAR(10) NOT NULL,
    note DECIMAL(5,2) NOT NULL,
    coefficient DECIMAL(5,2) DEFAULT 1,
    session_note VARCHAR(20) DEFAULT 'Normale',
    commentaire TEXT,
    date_saisie DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant),
    FOREIGN KEY (code_ue) REFERENCES UniteEnseignement(code_ue)
);