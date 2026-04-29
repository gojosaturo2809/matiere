<?php

namespace App\Controllers;

use App\Models\Etudiant;
use Config\Database;
use CodeIgniter\HTTP\RedirectResponse;

class Releve extends BaseController
{
    public function index(): string
    {
        $db = Database::connect();

        $etudiantModel = new Etudiant();
        $etudiants = $etudiantModel->orderBy('nom', 'ASC')->findAll();

        $programRows = $db->table('Programme')
            ->select('Programme.id_parcours, Programme.id_semestre, Programme.code_ue, Programme.est_optionnel')
            ->join('UniteEnseignement', 'UniteEnseignement.code_ue = Programme.code_ue', 'left')
            ->orderBy('Programme.id_parcours', 'ASC')
            ->orderBy('Programme.id_semestre', 'ASC')
            ->orderBy('Programme.code_ue', 'ASC')
            ->get()
            ->getResultArray();

        $noteRows = $db->table('v_releve_notes')
            ->select('id_etudiant, code_ue, note_max')
            ->get()
            ->getResultArray();

        $s3ByParcours = [];
        $s4RequiredByParcours = [];
        $optionGroups = [
            'dev' => [],
            'bddres' => [],
            'web' => [],
        ];

        foreach ($programRows as $row) {
            $idParcours = (int) ($row['id_parcours'] ?? 0);
            $semester = (int) ($row['id_semestre'] ?? 0);
            $codeUe = (string) ($row['code_ue'] ?? '');
            $isOptional = (int) ($row['est_optionnel'] ?? 0) === 1;

            if ($semester === 3) {
                $s3ByParcours[$idParcours][] = $codeUe;
                continue;
            }

            if ($semester === 4) {
                if ($isOptional) {
                    if ($idParcours === 1) {
                        $optionGroups['dev'][] = $codeUe;
                    } elseif ($idParcours === 2) {
                        $optionGroups['bddres'][] = $codeUe;
                    } elseif ($idParcours === 3) {
                        $optionGroups['web'][] = $codeUe;
                    }
                } else {
                    $s4RequiredByParcours[$idParcours][] = $codeUe;
                }
            }
        }

        $notesByStudent = [];
        foreach ($noteRows as $row) {
            $idEtudiant = (int) ($row['id_etudiant'] ?? 0);
            $codeUe = (string) ($row['code_ue'] ?? '');
            $noteValue = (float) ($row['note_max'] ?? 0);
            if ($idEtudiant > 0 && $codeUe !== '') {
                $notesByStudent[$idEtudiant][$codeUe] = $noteValue;
            }
        }

        $scoreFor = static function (array $codes, array $studentNotes): float {
            $sum = 0.0;
            $count = 0;
            foreach ($codes as $code) {
                if (! array_key_exists($code, $studentNotes)) {
                    continue;
                }
                $sum += (float) $studentNotes[$code];
                $count++;
            }

            return $count > 0 ? round($sum / $count, 2) : 0.0;
        };

        $releves = [];
        foreach ($etudiants as $etudiant) {
            $idEtudiant = (int) $etudiant['id_etudiant'];
            $idParcours = (int) ($etudiant['id_parcours'] ?? 0);
            $studentNotes = $notesByStudent[$idEtudiant] ?? [];

            $s3 = $scoreFor($s3ByParcours[$idParcours] ?? [], $studentNotes);
            $s4 = $scoreFor($s4RequiredByParcours[$idParcours] ?? [], $studentNotes);

            $optionDev = $scoreFor($optionGroups['dev'], $studentNotes);
            $optionBddres = $scoreFor($optionGroups['bddres'], $studentNotes);
            $optionWeb = $scoreFor($optionGroups['web'], $studentNotes);

            $releves[] = [
                'etudiant' => $etudiant,
                's3' => $s3,
                's4' => $s4,
                'option_dev' => $optionDev,
                'option_bddres' => $optionBddres,
                'option_web' => $optionWeb,
                'l2' => round($s3 + $s4, 2),
            ];
        }

        return view('releve', [
            'title' => 'SysInfo — Relevé de notes',
            'activePage' => 'releve',
            'releves' => $releves,
        ]);
    }

    public function ficheEtudiant($id = null): string|RedirectResponse
    {
        if ($id === null) {
            return redirect()->to('releve')->with('error', 'Étudiant non trouvé.');
        }

        $etudiantModel = new Etudiant();
        $etudiant = $etudiantModel->find((int) $id);

        if (! $etudiant) {
            return redirect()->to('releve')->with('error', 'Étudiant non trouvé.');
        }

        $parcoursLabels = [
            1 => 'Développement',
            2 => 'BDD / Réseaux',
            3 => 'Web',
        ];
        $parcoursId = (int) ($etudiant['id_parcours'] ?? 0);
        $parcoursLabel = $parcoursLabels[$parcoursId] ?? ($parcoursId > 0 ? 'Parcours #' . $parcoursId : 'Non défini');

        $db = Database::connect();

        // Récupérer les programmes et les notes
        $programRows = $db->table('Programme')
            ->select('Programme.id_parcours, Programme.id_semestre, Programme.code_ue, Programme.est_optionnel, UniteEnseignement.intitule AS libelle')
            ->join('UniteEnseignement', 'UniteEnseignement.code_ue = Programme.code_ue', 'left')
            ->orderBy('Programme.id_parcours', 'ASC')
            ->orderBy('Programme.id_semestre', 'ASC')
            ->orderBy('Programme.code_ue', 'ASC')
            ->get()
            ->getResultArray();

        // Récupérer les notes de cet étudiant (toutes les entrées, pas juste le max)
        $allNotes = $db->table('Note')
            ->select('code_ue, note, commentaire, date_saisie')
            ->where('id_etudiant', (int) $id)
            ->orderBy('code_ue', 'ASC')
            ->orderBy('date_saisie', 'DESC')
            ->get()
            ->getResultArray();

        // Organiser par note_max (considérer seulement le max)
        $notesByUe = [];
        foreach ($allNotes as $note) {
            $codeUe = (string) ($note['code_ue'] ?? '');
            if ($codeUe === '') {
                continue;
            }
            if (! isset($notesByUe[$codeUe])) {
                $notesByUe[$codeUe] = [
                    'note_max' => (float) ($note['note'] ?? 0),
                    'commentaire' => (string) ($note['commentaire'] ?? ''),
                ];
            }
        }

        // Organiser par semestre et optionnel
        $s3Ues = [];
        $s4RequiredUes = [];
        $optionsByParcours = [
            1 => [],  // Dev
            2 => [],  // BDD / Réseaux
            3 => [],  // Web
        ];

        foreach ($programRows as $row) {
            $codeUe = (string) ($row['code_ue'] ?? '');
            $semester = (int) ($row['id_semestre'] ?? 0);
            $isOptional = (int) ($row['est_optionnel'] ?? 0) === 1;
            $libelle = (string) ($row['libelle'] ?? '');
            $idParcours = (int) ($row['id_parcours'] ?? 0);

            $note = $notesByUe[$codeUe] ?? ['note_max' => 0, 'commentaire' => ''];
            $ueData = [
                'code' => $codeUe,
                'libelle' => $libelle,
                'note' => $note['note_max'],
                'commentaire' => $note['commentaire'],
            ];

            if ($semester === 3 && $idParcours === $parcoursId) {
                $s3Ues[] = $ueData;
            } elseif ($semester === 4) {
                if ($isOptional && isset($optionsByParcours[$idParcours])) {
                    $optionsByParcours[$idParcours][] = $ueData;
                } elseif (!$isOptional && $idParcours === $parcoursId) {
                    $s4RequiredUes[] = $ueData;
                }
            }
        }

        // Calculer les moyennes
        $scoreCalc = static function (array $ues): float {
            if (empty($ues)) {
                return 0.0;
            }
            $sum = 0.0;
            $count = 0;
            foreach ($ues as $ue) {
                if ((float) $ue['note'] > 0) {
                    $sum += (float) $ue['note'];
                    $count++;
                }
            }

            return $count > 0 ? round($sum / $count, 2) : 0.0;
        };

        $s3Avg = $scoreCalc($s3Ues);
        $s4Avg = $scoreCalc($s4RequiredUes);
        $optionAvgDev = $scoreCalc($optionsByParcours[1]);
        $optionAvgBddres = $scoreCalc($optionsByParcours[2]);
        $optionAvgWeb = $scoreCalc($optionsByParcours[3]);
        $l2 = round($s3Avg + $s4Avg, 2);

        return view('fiche_etudiant', [
            'title' => 'SysInfo — Fiche étudiant',
            'activePage' => 'releve',
            'etudiant' => $etudiant,
            'parcoursLabel' => $parcoursLabel,
            's3Ues' => $s3Ues,
            's4RequiredUes' => $s4RequiredUes,
            'optionsDev' => $optionsByParcours[1],
            'optionsBddres' => $optionsByParcours[2],
            'optionsWeb' => $optionsByParcours[3],
            's3Avg' => $s3Avg,
            's4Avg' => $s4Avg,
            'optionAvgDev' => $optionAvgDev,
            'optionAvgBddres' => $optionAvgBddres,
            'optionAvgWeb' => $optionAvgWeb,
            'l2' => $l2,
        ]);
    }
}