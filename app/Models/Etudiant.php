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

    protected $validationRules = [
        'ETU' => 'required|integer|is_unique[Etudiant.ETU]',
        'nom' => 'required|string|max_length[100]',
        'prenom' => 'required|string|max_length[100]',
        'email' => 'permit_empty|valid_email|is_unique[Etudiant.email]',
        'id_parcours' => 'permit_empty|integer',
        'date_inscription' => 'permit_empty|valid_date',
    ];

    protected $validationMessages = [];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    protected $useTimestamps = false;
    protected $createdField = 'date_inscription';
    protected $updatedField = null;
    protected $deletedField = null;

    // Casts
    protected array $casts = [
           'id_etudiant' => 'integer',
           'ETU' => 'integer',
           'id_parcours' => 'integer',
           // 'date_inscription' cast removed: handler unavailable in this environment
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
