<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEtudiantTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_etudiant' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'ETU' => [
                'type' => 'INT',
                'constraint' => 11,
                'unique' => true,
            ],
            'nom' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'prenom' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
                'unique' => true,
            ],
            'id_parcours' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'date_inscription' => [
                'type' => 'DATE',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_DATE'),
            ],
        ]);
        
        $this->forge->addPrimaryKey('id_etudiant');
        $this->forge->createTable('Etudiant');
    }

    public function down()
    {
        $this->forge->dropTable('Etudiant');
    }
}
