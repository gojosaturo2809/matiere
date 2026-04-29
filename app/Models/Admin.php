<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe'
    ];

    // Désactivation des timestamps car non présents dans le SQL
    protected $useTimestamps = false;

    protected $validationRules = [
        'nom' => 'required|min_length[2]|max_length[100]',
        'prenom' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|is_unique[admin.email]',
        'mot_de_passe' => 'required|min_length[3]|max_length[255]'
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'Le nom est obligatoire.',
            'min_length' => 'Le nom doit contenir au moins 2 caractères.',
            'max_length' => 'Le nom doit contenir au max 100 caractères.'
        ],
        'prenom' => [
            'required' => 'Le prénom est obligatoire.'
        ],
        'email' => [
            'required' => 'L\'email est obligatoire.',
            'valid_email' => 'Veuillez fournir une adresse email valide.',
            'is_unique' => 'Cette adresse email est déjà utilisée.'
        ],
        'mot_de_passe' => [
            'required' => 'Le mot de passe est obligatoire.',
            'min_length' => 'Le mot de passe doit contenir au moins 3 caractères.'
        ]
    ];
}