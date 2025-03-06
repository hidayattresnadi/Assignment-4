<?php

namespace App\Cells;

use App\Libraries\DataParamsStudent;
use CodeIgniter\View\Cells\Cell;

class SortTableHeaderCell extends Cell
{
    protected DataParamsStudent $params;
    protected string $baseUrl;
    protected string $tableField;
    protected string $tableTitleHeader;

    public function mount(DataParamsStudent $params, string $baseUrl, string $tableField, string $tableTitleHeader)
    {
        $this->params = $params;
        $this->baseUrl = $baseUrl;
        $this->tableField = $tableField;
        $this->tableTitleHeader = $tableTitleHeader;
    }

    public function getParamsProperty()
    {
        return $this->params;
    }

    public function getBaseUrlProperty()
    {
        return $this->baseUrl;
    }

    public function getTableFieldProperty()
    {
        return $this->tableField;
    }


    public function getTableTitleHeaderProperty()
    {
        return $this->tableTitleHeader;
    }
}
