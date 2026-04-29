<?php

namespace App\Controllers;

use App\Models\Etudiant;
use App\Models\Note as NoteModel;
use App\Models\UniteEnseignement;

class Note extends BaseController
{
    public function index(): string
    {
        $etudiantModel = new Etudiant();
        $noteModel = new NoteModel();

        $etudiants = $etudiantModel->orderBy('nom', 'ASC')->findAll();
        $notes = $noteModel->orderBy('date_saisie', 'DESC')->findAll();

        $etudiantIndex = [];
        foreach ($etudiants as $etudiant) {
            $etudiantIndex[$etudiant['id_etudiant']] = $etudiant;
        }

        return view('list', [
            'title' => 'SysInfo — Étudiants',
            'activePage' => 'notes',
            'etudiants' => $etudiants,
            'notes' => $notes,
            'etudiantIndex' => $etudiantIndex,
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
            'coefficient' => 'permit_empty|decimal|greater_than[0]',
            'session_note' => 'permit_empty|string|max_length[20]',
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
            'coefficient',
            'session_note',
            'commentaire',
        ]);

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $noteModel->insert([
            'id_etudiant' => (int) $data['id_etudiant'],
            'code_ue' => trim((string) $data['code_ue']),
            'note' => (float) $data['note'],
            'coefficient' => $data['coefficient'] !== null && $data['coefficient'] !== '' ? (float) $data['coefficient'] : 1,
            'session_note' => trim((string) ($data['session_note'] ?? 'Normale')) ?: 'Normale',
            'commentaire' => trim((string) ($data['commentaire'] ?? '')),
        ]);

        return redirect()->to(site_url('notes'))->with('success', 'La note a été enregistrée.');
    }
}