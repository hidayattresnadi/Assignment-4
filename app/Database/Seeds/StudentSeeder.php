<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'student_id' => 'S2024001',
                'name' => 'John Doe',
                'study_program' => 'Computer Science',
                'current_semester' => 4,
                'academic_status' => 'Active',
                'entry_year' => 2022,
                'gpa' => 3.75,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'student_id' => 'S2024002',
                'name' => 'Jane Smith',
                'study_program' => 'Information Systems',
                'current_semester' => 6,
                'academic_status' => 'Active',
                'entry_year' => 2021,
                'gpa' => 3.89,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'student_id' => 'S2024003',
                'name' => 'Michael Johnson',
                'study_program' => 'Electrical Engineering',
                'current_semester' => 8,
                'academic_status' => 'Graduated',
                'entry_year' => 2020,
                'gpa' => 3.45,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'student_id' => 'S2024004',
                'name' => 'Emily Brown',
                'study_program' => 'Mechanical Engineering',
                'current_semester' => 2,
                'academic_status' => 'On Leave',
                'entry_year' => 2023,
                'gpa' => 2.95,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'student_id' => 'S2024005',
                'name' => 'David Wilson',
                'study_program' => 'Civil Engineering',
                'current_semester' => 7,
                'academic_status' => 'On Leave',
                'entry_year' => 2021,
                'gpa' => 2.50,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('students')->insertBatch($data);
    }
}
