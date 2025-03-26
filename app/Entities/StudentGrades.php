<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class StudentGrades extends Entity
{
    protected $attributes = [
        'id' => null,
        'enrollment_id' => null,
        'grade_value' => null,
        'grade_letter' => null,
        'completed_at' => null,
        'created_at' => null,
    ];
}
