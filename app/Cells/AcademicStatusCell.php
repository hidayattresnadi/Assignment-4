<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class AcademicStatusCell extends Cell
{
    protected string $type;
    protected string $alertClass;

    public function mount(string $type)
    {
        $this->type = $type;

        $alertTypes = [
            'Active' => 'alert-success',
            'On Leave' => 'alert-warning',
            'Graduated' => 'alert-primary'
        ];

        $this->alertClass = $alertTypes[$type] ?? 'alert-info';

        // cache()->save("cache_academic_status_" . $type, $type, 86400);
    }


    public function getAlertClassProperty()
    {
        return $this->alertClass;
    }

    public function getTypeProperty()
    {
        return $this->type;
    }
}
