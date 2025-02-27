<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Course extends Entity
{
    protected $attributes = [
        'id' => null,
        'code' => null,
        'name' => null,
        'credits' => null,
        'semester' => null,
        'created_at' => null,
        'updated_at' => null
    ];
}
