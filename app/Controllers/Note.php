<?php

namespace App\Controllers;

use App\Models\Etudiant;
use App\Models\Note as NoteModel;
use App\Models\UniteEnseignement;

class Note extends BaseController
{
    public function index($id = null): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $etudiantModel = new Etudiant();
        $noteModel = new NoteModel();

        $etudiants = $etudiantModel->orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')->findAll();

        if ($id !== null) {
            $student = $etudiantModel->find((int) $id);

            if (! $student) {
                return redirect()->to(site_url('notes'))->with('error', 'Étudiant non trouvé.');
            }

            $etudiants = [$student];
        }

        $notes = $noteModel
            ->select('Note.id_note, Note.id_etudiant, Note.code_ue, Note.note, Note.commentaire, Note.date_saisie, Etudiant.ETU, Etudiant.nom, Etudiant.prenom')
            ->join('Etudiant', 'Etudiant.id_etudiant = Note.id_etudiant', 'left')
            ->orderBy('Etudiant.nom', 'ASC')
            ->orderBy('Etudiant.prenom', 'ASC')
            ->orderBy('Note.date_saisie', 'DESC')
            ->findAll();

        $notesByStudent = [];
        foreach ($notes as $note) {
            $studentId = (int) ($note['id_etudiant'] ?? 0);
            if ($studentId > 0) {
                $notesByStudent[$studentId][] = $note;
            }
        }

        $studentSections = [];
        foreach ($etudiants as $etudiant) {
            $studentId = (int) ($etudiant['id_etudiant'] ?? 0);
            $studentSections[] = [
                'etudiant' => $etudiant,
                'notes' => $notesByStudent[$studentId] ?? [],
            ];
        }

        return view('notes/index', [
            'title' => 'SysInfo — Étudiants',
            'activePage' => 'notes',
            'studentSections' => $studentSections,
            'filteredStudent' => $id !== null,
        ]);
    }

    public function create(): string
    {
        $etudiantModel = new Etudiant();
        $ueModel = new UniteEnseignement();

        return view('form', [
            'title' => 'SysInfo — Saisie des notes',
            'activePage' => 'note-form',
            'etudiants' => $etudiantModel->orderBy('nom', 'ASC')->findAll(),
            'ues' => $ueModel->orderBy('code_ue', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $noteModel = new NoteModel();

        $rules = [
            'id_etudiant' => 'required|integer',
            'code_ue' => 'required|string|max_length[10]',
            'note' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[20]',
            'commentaire' => 'permit_empty|string|max_length[1000]',
        ];

        $messages = [
            'id_etudiant' => [
                'required' => 'Veuillez sélectionner un étudiant.',
                'integer' => 'L’identifiant de l’étudiant est invalide.',
            ],
            'code_ue' => [
                'required' => 'Veuillez sélectionner une UE.',
                'max_length' => 'Le code UE ne peut pas dépasser 10 caractères.',
            ],
            'note' => [
                'required' => 'La note est obligatoire.',
                'decimal' => 'La note doit être un nombre valide.',
                'less_than_equal_to' => 'La note ne peut pas dépasser 20.',
            ],
        ];

        $data = $this->request->getPost([
            'id_etudiant',
            'code_ue',
            'note',
            'commentaire',
        ]);

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $noteModel->insert([
            'id_etudiant' => (int) $data['id_etudiant'],
            'code_ue' => trim((string) $data['code_ue']),
            'note' => (float) $data['note'],
            'commentaire' => trim((string) ($data['commentaire'] ?? '')),
        ]);

        return redirect()->to(site_url('notes'))->with('success', 'La note a été enregistrée.');
    }

    public function delete($id = null)
    {
        if ($id === null) {
            return redirect()->to('notes')->with('error', 'Note non trouvée.');
        }

        $noteModel = new NoteModel();
        $note = $noteModel->find((int) $id);

        if (! $note) {
            return redirect()->to('notes')->with('error', 'Note non trouvée.');
        }

        $noteModel->delete((int) $id);

        return redirect()->back()->with('success', 'La note a été supprimée.');
    }
}