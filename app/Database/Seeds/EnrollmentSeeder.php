<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'student_id'    => 1,
                'course_id'     => 1,
                'academic_year' => 2023,
                'semester'      => 1,
                'status'        => 'Enrolled',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'student_id'    => 2,
                'course_id'     => 2,
                'academic_year' => 2023,
                'semester'      => 2,
                'status'        => 'Completed',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'student_id'    => 3,
                'course_id'     => 3,
                'academic_year' => 2022,
                'semester'      => 1,
                'status'        => 'Dropped',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'student_id'    => 4,
                'course_id'     => 4,
                'academic_year' => 2022,
                'semester'      => 2,
                'status'        => 'Enrolled',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'student_id'    => 5,
                'course_id'     => 5,
                'academic_year' => 2021,
                'semester'      => 1,
                'status'        => 'Completed',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('enrollments')->insertBatch($data);
    }
}
