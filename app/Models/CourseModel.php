<?php

namespace App\Models;

use App\Libraries\DataParams;
use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Course::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code', 'name', 'credits', 'semester'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'code' => [
            'required',
            'exact_length[5]',
            'is_unique[courses.code]'
        ],

        'credits' => [
            'required',
            'integer',
            'greater_than_equal_to[1]',
            'less_than_equal_to[6]',
        ],

        'semester' => [
            'required',
            'integer',
            'greater_than_equal_to[1]',
            'less_than_equal_to[8]',
        ],
    ];
    protected $validationMessages   = [
        'code' => [
            'required'     => 'Course code is required.',
            'exact_length' => 'Course code must be exactly 5 characters long.',
            'is_unique' => 'Course code is already registered.',
        ],

        'credits' => [
            'required'               => 'Course credits are required.',
            'integer'                => 'Course credits must be a number.',
            'greater_than_equal_to'  => 'Course credits must be at least 1.',
            'less_than_equal_to'     => 'Course credits cannot be more than 6.',
        ],

        'semester' => [
            'required'               => 'Semester is required.',
            'integer'                => 'Semester must be a number.',
            'greater_than_equal_to'  => 'Semester must be at least 1.',
            'less_than_equal_to'     => 'Semester cannot be more than 8.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getFilteredCourses(DataParams $params)
    {
        if (!empty($params->search)) { // Apply search
            $this->groupStart()
                ->like('name', $params->search)
                ->orLike('code', $params->search)
                ->orlike("CAST(credits AS CHAR)", $params->search)
                ->orlike("CAST(semester AS CHAR)", $params->search)
                ->groupEnd();
        }

        // Apply filter credits

        if (!empty($params->credits)) {
            $this->where('credits', $params->credits);
        }

        // Apply filter semester

        if (!empty($params->semester)) {
            $this->where('semester', $params->semester);
        }

        // Apply sort
        $allowedSortColumns = ['code', 'name'];
        $sort = in_array($params->sort, $allowedSortColumns) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'desc' : 'asc';

        $this->orderBy($sort, $order);

        $result = [
            'courses' => $this->paginate($params->perPage, 'courses', $params->page_courses),
            'pager' => $this->pager,
            'total' => $this->countAllResults(false)
        ];
        return $result;
    }

    public function getAllCredits()
    {
        return [2, 3, 4];
    }

    public function getAllSemesters()
    {
        $semesters = $this->select('semester')->distinct()->findAll();
        return array_column($semesters, 'semester');
    }
}
