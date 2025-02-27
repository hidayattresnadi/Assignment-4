<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StudentGradeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'enrollment_id' => 1,
                'grade_value'   => 85.50,
                'grade_letter'  => 'A',
                'completed_at'  => '2024-02-10 10:30:00',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'enrollment_id' => 2,
                'grade_value'   => 78.25,
                'grade_letter'  => 'B',
                'completed_at'  => '2024-01-15 14:00:00',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'enrollment_id' => 3,
                'grade_value'   => 65.00,
                'grade_letter'  => 'C',
                'completed_at'  => '2023-12-20 08:45:00',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'enrollment_id' => 4,
                'grade_value'   => 90.75,
                'grade_letter'  => 'A',
                'completed_at'  => '2024-02-01 12:15:00',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'enrollment_id' => 5,
                'grade_value'   => 50.00,
                'grade_letter'  => 'D',
                'completed_at'  => '2023-11-10 16:30:00',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('student_grades')->insertBatch($data);
    }
}
