<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'student_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'study_program' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'current_semester' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null' => false
            ],
            'academic_status' => [
                'type'       => 'ENUM',
                'constraint' => ['Active', 'On Leave', 'Graduated'],
                'default'    => 'Active',
            ],
            'entry_year' => [
                'type'       => 'YEAR',
                'null'       => false,
            ],
            'gpa' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
