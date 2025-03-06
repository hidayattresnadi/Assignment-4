<?php

namespace App\Libraries;

use CodeIgniter\HTTP\IncomingRequest;

class DataParams
{
    public $search = '';
    // public $filters = [];
    public $credits = 0;
    public $semester = 0;
    public $sort = 'id';
    public $order = 'asc';
    public $page_courses = 1;
    public $perPage = 2;

    public function __construct(array $params = [])
    {
        $this->search = $params['search'] ?? '';
        $this->credits = $params['credits'];
        $this->semester = $params['semester'];
        $this->sort = $params['sort'] ?? 'id';
        $this->order = $params['order'] ?? 'asc';
        $this->page_courses = (int)($params['page_courses'] ?? 1);
        $this->perPage = (int)($params['perPage'] ?? 2);
    }

    public function getParams()
    {
        return [
            'search' => $this->search,
            'credits' => $this->credits,
            'semester' => $this->semester,
            'sort' => $this->sort,
            'order' => $this->order,
            'page_courses' => $this->page_courses,
            'perPage' => $this->perPage
        ];
    }

    public function getSortUrl($column, $baseUrl)
    {
        $params = $this->getParams();

        // Set sort to column and toggle order if already sorted by this column
        $params['sort'] = $column;
        $params['order'] = ($column == $this->sort && $this->order == 'asc') ? 'desc' : 'asc';

        // Build query string
        $queryString = http_build_query(array_filter($params));
        return $baseUrl . '?' . $queryString;
    }

    public function getResetUrl($baseUrl)
    {
        return $baseUrl;
    }


    public function isSortedBy($column)
    {
        return $this->sort === $column;
    }


    public function getSortDirection()
    {
        return $this->order;
    }
}
