<?php

namespace App\Cells;

use App\Libraries\DataParams;
use CodeIgniter\View\Cells\Cell;

class ListCoursesCell extends Cell
{
    protected array $courses = [];
    protected DataParams $params;
    protected string $baseUrl;

    public function mount(array $courses, DataParams $params, string $baseUrl)
    {
        $this->courses = $courses;
        $this->params = $params;
        $this->baseUrl = $baseUrl;
    }

    public function getCoursesProperty()
    {
        return $this->courses;
    }

    public function getParamsProperty()
    {
        return $this->params;
    }

    public function getBaseUrlProperty()
    {
        return $this->baseUrl;
    }
}
