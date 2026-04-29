-- Vue essentielle pour le relevé de notes : une ligne par étudiant et UE avec la meilleure note
-- LEFT JOIN est volontaire pour conserver les étudiants sans note.
CREATE OR REPLACE VIEW v_releve_notes AS
SELECT
    e.id_etudiant,
    e.ETU,
    e.nom,
    e.prenom,
    e.id_parcours,
    p.nom_parcours,
    pr.id_semestre,
    ue.code_ue,
    ue.intitule,
    ue.credits,
    pr.est_optionnel,
    MAX(n.note) AS note_max
FROM Etudiant e
LEFT JOIN Note n
    ON n.id_etudiant = e.id_etudiant
LEFT JOIN Programme pr
    ON pr.code_ue = n.code_ue
   AND (pr.id_parcours = e.id_parcours OR pr.id_parcours IS NULL)
LEFT JOIN UniteEnseignement ue
    ON ue.code_ue = n.code_ue
LEFT JOIN Parcours p
    ON p.id_parcours = e.id_parcours
GROUP BY
    e.id_etudiant,
    e.ETU,
    e.nom,
    e.prenom,
    e.id_parcours,
    p.nom_parcours,
    pr.id_semestre,
    ue.code_ue,
    ue.intitule,
    ue.credits,
    pr.est_optionnel;