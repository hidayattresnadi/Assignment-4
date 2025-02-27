<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class DeleteStudentButtonCell extends Cell
{
    protected int $id;

    public function mount(int $id)
    {
        $this->id = $id;
    }


    public function getIdProperty()
    {
        return $this->id;
    }
}
