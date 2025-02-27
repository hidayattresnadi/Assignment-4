<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'code' => 'CS101',
                'name' => 'Introduction to Computer Science',
                'credits' => 3,
                'semester' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'CS102',
                'name' => 'Data Structures and Algorithms',
                'credits' => 4,
                'semester' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'CS201',
                'name' => 'Database Systems',
                'credits' => 3,
                'semester' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'CS202',
                'name' => 'Operating Systems',
                'credits' => 4,
                'semester' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'CS301',
                'name' => 'Software Engineering',
                'credits' => 3,
                'semester' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('courses')->insertBatch($data);
    }
}
