<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFilePathToStudents extends Migration
{
    public function up()
    {

        $this->forge->addColumn('students', [
            'diploma_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('students', 'diploma_file');
    }
}
