<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ListCoursesCell extends Cell
{
    protected array $courses = [];

    public function mount(array $courses)
    {
        $this->courses = $courses;
    }

    public function getCoursesProperty()
    {
        return $this->courses;
    }
}
