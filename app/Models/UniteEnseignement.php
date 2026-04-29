<?php

namespace App\Models;

use CodeIgniter\Model;

class UniteEnseignement extends Model
{
    protected $table = 'UniteEnseignement';
    protected $primaryKey = 'code_ue';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['code_ue', 'intitule', 'credits'];
}