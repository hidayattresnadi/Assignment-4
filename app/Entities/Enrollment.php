<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Enrollment extends Entity
{
    protected $attributes = [
        'id' => null,
        'course_id' => null,
        'student_id' => null,
        'academic_year' => null,
        'semester' => null,
        'created_at' => null,
        'status' => null
    ];
}
