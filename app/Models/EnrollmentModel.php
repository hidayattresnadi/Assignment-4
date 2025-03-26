<?php

namespace App\Models;

use App\Libraries\DataParams;
use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table            = 'enrollments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Enrollment::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['course_id', 'student_id', 'academic_year', 'semester', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
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

    public function getEnrollmentUsers($studentId)
    {
        return $this->select('enrollments.*, courses.name as courseName')
            ->join('students', 'students.id = enrollments.student_id')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->where('enrollments.student_id', $studentId)
            ->findAll();
    }

    public function getEnrollmentUsersCount($studentId)
    {
        return $this->where('student_id', $studentId)->countAllResults();
    }


    public function getCreditComparison($studentId)
    {
        return $this->select('students.id as student_id, enrollments.semester as semester, sum(courses.credits) as credits_taken')
            ->join('academic.students', 'academic.students.id = academic.enrollments.student_id')
            ->join('academic.courses', 'academic.courses.id = academic.enrollments.course_id')
            ->where('enrollments.student_id', $studentId)
            ->groupBy('academic.enrollments.semester')
            ->findAll();
    }

    public function getEnrollmentAllUsers($search, $filter_by)
    {
        if (!empty($filter_by)) {
            if (!empty($search)) {
                $this->groupStart()
                    ->like('academic.students.' . $filter_by, $search)
                    ->groupEnd();
            }
        }

        return $this
            ->select('
            academic.students.name as student_name, 
            academic.students.study_program, 
            academic.students.student_id as student_university_id,
            academic.students.current_semester,
            academic.courses.code as course_code,
            academic.courses.name as course_name,
            academic.courses.credits,
            enrollments.academic_year,
            enrollments.status,
            enrollments.semester as enrollment_semester
            ')
            ->join('academic.students', 'academic.students.id = enrollments.student_id')
            ->join('academic.courses', 'academic.courses.id = enrollments.course_id')
            ->findAll();
    }
}
