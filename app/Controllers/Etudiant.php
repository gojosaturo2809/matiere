<?php

namespace App\Controllers;

use App\Models\Etudiant as EtudiantModel;

class Etudiant extends BaseController
{
    protected $etudiantModel;

    public function __construct()
    {
        $this->etudiantModel = new EtudiantModel();
    }

    /**
     * Afficher la liste de tous les étudiants
     */
    public function index()
    {
        $data = [
            'title' => 'SysInfo - Liste des etudiants',
            'activePage' => 'etudiants',
            'etudiants' => $this->etudiantModel
                ->orderBy('nom', 'ASC')
                ->orderBy('prenom', 'ASC')
                ->findAll(),
        ];

        return view('etudiants/list', $data);
    }

    // Les méthodes suivantes seront implémentées par les autres membres du groupe:
    // - create() : Afficher le formulaire de création
    // - store() : Enregistrer un nouvel étudiant
    // - show() : Afficher les détails et les notes d'un étudiant
    // - edit() : Afficher le formulaire d'édition
    // - update() : Mettre à jour un étudiant
    // - delete() : Supprimer un étudiant
}
