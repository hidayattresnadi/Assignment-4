<?php

namespace App\Models;

use App\Libraries\DataParamsStudent;
use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table            = 'students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Student::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields  = ['student_id', 'name', 'study_program', 'current_semester', 'entry_year', 'academic_status', 'gpa', 'diploma_file'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    // protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'current_semester' => [
            'required',
            'integer',
            'greater_than_equal_to[1]',
            'less_than_equal_to[14]',
        ],

        'gpa' => [
            'required',
            'decimal',
            'greater_than_equal_to[0]',
            'less_than_equal_to[4.00]',
        ],

        'academic_status' => [
            'required',
            'in_list[Active,On Leave,Graduated]',
        ],
        'student_id' => [
            'required',
            'is_unique[students.student_id]',
        ]
    ];

    protected $validationMessages = [
        'current_semester' => [
            'required'               => 'Semester is required.',
            'integer'                => 'Semester must be a number.',
            'greater_than_equal_to'  => 'Semester must be at least 1.',
            'less_than_equal_to'     => 'Semester cannot be more than 14.',
        ],

        'gpa' => [
            'required'               => 'GPA is required.',
            'decimal'                => 'GPA must be a decimal number.',
            'greater_than_equal_to'  => 'GPA must be at least 0.00.',
            'less_than_equal_to'     => 'GPA cannot be more than 4.00.',
        ],

        'academic_status' => [
            'required' => 'Academic status is required.',
            'in_list'  => 'Academic status must be either Active, On Leave, or Graduated.',
        ],
        'student_id' => [
            'required'  => 'Student id is required.',
            'is_unique' => 'Student Id is already registered.',
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


    public function getFilteredStudents(DataParamsStudent $params)
    {
        if (!empty($params->search)) { // Apply search
            $this->groupStart()
                ->like('name', $params->search)
                ->orLike('student_id', $params->search)
                ->orLike('academic_status', $params->search)
                ->orLike('entry_year', $params->search)
                ->orLike('study_program', $params->search)
                ->orlike("CAST(current_semester AS CHAR)", $params->search)
                ->orlike("CAST(gpa AS CHAR)", $params->search)
                ->groupEnd();
        }

        // Apply filter academic status

        if (!empty($params->academic_status)) {
            $this->where('academic_status', $params->academic_status);
        }

        // Apply filter entry year

        if (!empty($params->entry_year)) {
            $this->where('entry_year', $params->entry_year);
        }

        // Apply filter entry study_program

        if (!empty($params->study_program)) {
            $this->where('study_program', $params->study_program);
        }

        // Apply sort
        $allowedSortColumns = ['student_id', 'current_semester'];
        $sort = in_array($params->sort, $allowedSortColumns) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'desc' : 'asc';

        $this->orderBy($sort, $order);

        $result = [
            'students' => $this->paginate($params->perPage, 'students', $params->page_students),
            'pager' => $this->pager,
            'total' => $this->countAllResults(false)
        ];
        return $result;
    }

    public function getAllAcademicStatuses()
    {
        $academic_statuses = $this->select('academic_status')->distinct()->findAll();
        return array_column($academic_statuses, 'academic_status');
    }

    public function getAllEntryYears()
    {
        $entry_years = $this->select('entry_year')->distinct()->findAll();
        return array_column($entry_years, 'entry_year');
    }

    public function getAllStudyPrograms()
    {
        $study_programs = $this->select('study_program')->distinct()->findAll();
        return array_column($study_programs, 'study_program');
    }
}
