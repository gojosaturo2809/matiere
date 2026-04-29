<?php

namespace App\Models;

use CodeIgniter\Model;

class Etudiant extends Model
{
    protected $table = 'Etudiant';
    protected $primaryKey = 'id_etudiant';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['ETU', 'nom', 'prenom', 'email', 'id_parcours', 'date_inscription'];

    // Validation Rules
    protected $validationRules = [
        'ETU' => 'required|integer|is_unique[Etudiant.ETU]',
        'nom' => 'required|string|max_length[100]',
        'prenom' => 'required|string|max_length[100]',
        'email' => 'permit_empty|valid_email|is_unique[Etudiant.email]',
        'id_parcours' => 'permit_empty|integer',
        'date_inscription' => 'permit_empty|valid_date',
    ];

    protected $validationMessages = [
        'ETU' => [
            'required' => 'Le numéro matricule est obligatoire.',
            'integer' => 'Le numéro matricule doit être un entier.',
            'is_unique' => 'Ce numéro matricule existe déjà.',
        ],
        'nom' => [
            'required' => 'Le nom est obligatoire.',
            'max_length' => 'Le nom ne peut pas dépasser 100 caractères.',
        ],
        'prenom' => [
            'required' => 'Le prénom est obligatoire.',
            'max_length' => 'Le prénom ne peut pas dépasser 100 caractères.',
        ],
        'email' => [
            'valid_email' => 'Veuillez entrer une adresse email valide.',
            'is_unique' => 'Cette adresse email est déjà utilisée.',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Dates
    protected $useTimestamps = false;
    protected $createdField = 'date_inscription';
    protected $updatedField = null;
    protected $deletedField = null;

    // Casts
    protected $casts = [
        'id_etudiant' => 'integer',
        'ETU' => 'integer',
        'id_parcours' => 'integer',
        'date_inscription' => 'date',
    ];

    // Callbacks
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
