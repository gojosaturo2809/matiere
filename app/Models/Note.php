<?php

namespace App\Models;

use CodeIgniter\Model;

class Note extends Model
{
    protected $table = 'Note';
    protected $primaryKey = 'id_note';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_etudiant',
        'code_ue',
        'note',
        'coefficient',
        'session_note',
        'commentaire',
        'date_saisie',
    ];

    protected $validationRules = [
        'id_etudiant' => 'required|integer',
        'code_ue' => 'required|string|max_length[10]',
        'note' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[20]',
        'coefficient' => 'permit_empty|decimal|greater_than[0]',
        'session_note' => 'permit_empty|string|max_length[20]',
        'commentaire' => 'permit_empty|string|max_length[1000]',
    ];

    protected $validationMessages = [
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

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $useTimestamps = false;
    protected $createdField = 'date_saisie';
    protected $updatedField = null;
    protected $deletedField = null;

    protected array $casts = [
        'id_note' => 'integer',
        'id_etudiant' => 'integer',
        'note' => 'float', // Ensure this is explicitly typed
        'coefficient' => 'float', // Ensure this is explicitly typed
    ];
}