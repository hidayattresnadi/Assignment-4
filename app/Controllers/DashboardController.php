<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\StudentGradesModel;
use App\Models\StudentModel;
use Myth\Auth\Models\UserModel;

class DashboardController extends BaseController
{
    private StudentModel $studentModel;
    protected UserModel $userModel;
    protected EnrollmentModel $enrollmentModel;
    private CourseModel $courseModel;
    private StudentGradesModel $studentGradesModel;
    protected $renderer;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->userModel = new UserModel();
        $this->enrollmentModel = new EnrollmentModel();
        $this->courseModel = new CourseModel();
        $this->studentGradesModel = new StudentGradesModel();
        $this->renderer = service('renderer');
    }

    public function studentDashboard()
    {

        $userId = user_id();
        $student = $this->studentModel->where('user_id', $userId)->first();
        $data['enrollments'] = $this->enrollmentModel->getEnrollmentUsersCount($student->id);

        return view('Dashboard/studentDashboard', $data);
    }

    public function adminDashboard()
    {
        $data['students'] = $this->studentModel->countAll();
        $data['users'] = $this->userModel->countAll();

        return view('Dashboard/adminDashboard', $data);
    }


    public function lecturerDashboard()
    {
        $data['courses'] = $this->courseModel->countAll();
        return view('Dashboard/lecturerDashboard', $data);
    }

    public function index()
    {

        $creditsByGrade = $this->getCreditsByGrade();

        $creditComparison = $this->getCreditComparison();

        $gpaData = $this->getGpaPerSemester();

        return view('dashboard', [

            'creditsByGrade' => json_encode($creditsByGrade),

            'creditComparison' => json_encode($creditComparison),

            'gpaData' => json_encode($gpaData),

        ]);
    }

    private function getCreditsByGrade()
    {
        // ini tuh kek satu siswa dijumlah dia dapet A dari berapa sks, B brapa sks, gtu

        $userId = user_id();
        $student = $this->studentModel->where('user_id', $userId)->first();

        $totalStudentCredits = $this->studentGradesModel->getStudentCredits($student->id);

        $backgroundColors = [
            'A' => 'rgb(54, 162, 235)',    // Biru untuk A
            'B+' => 'rgb(75, 192, 192)',    // Cyan untuk B+
            'B' => 'rgb(153, 102, 255)',   // Ungu untuk B
            'C+' => 'rgb(255, 205, 86)',    // Kuning untuk C+
            'C' => 'rgb(255, 159, 64)',    // Oranye untuk C
            'D' => 'rgb(255, 99, 132)'     // Merah untuk D
        ];

        foreach ($totalStudentCredits as $row) {
            $gradeLabels[] = $row['grade_letter'] . ' = ' . $row['credits'] . ' Credits';
            $creditCounts[] = (int)$row['credits'];
            $colors[] = $backgroundColors[$row['grade_letter']];
        }

        return [
            'labels' => $gradeLabels,
            'datasets' => [
                [
                    'label' => 'Credits by Grade',
                    'data' => $creditCounts,
                    'backgroundColor' => $colors,
                    'hoverOffset' => 4
                ]
            ]
        ];
    }

    private function getCreditComparison()
    {
        $userId = user_id();
        $student = $this->studentModel->where('user_id', $userId)->first();

        $creditsTaken = $this->enrollmentModel->getCreditComparison($student->id);

        $requiredCredits = [
            ['semester' => 1, 'credits_required' => 20],
            ['semester' => 2, 'credits_required' => 22],
            ['semester' => 3, 'credits_required' => 24],
            ['semester' => 4, 'credits_required' => 22],
            ['semester' => 5, 'credits_required' => 20],
            ['semester' => 6, 'credits_required' => 18]
        ];

        $comparisonTakenCredits = [];

        foreach ($creditsTaken as $credits) {
            foreach ($requiredCredits as $requiredCredit) {
                if ($requiredCredit['semester'] === (int) $credits->semester) {
                    $comparisonTakenCredits[] = [
                        'semester' => $requiredCredit['semester'],
                        'credits_required' => $requiredCredit['credits_required'],
                        'credits_taken' => (int) $credits->credits_taken,
                    ];
                    break;
                }
            }
        }

        foreach ($comparisonTakenCredits as $row) {
            $labels[] = 'Semester ' . $row['semester'];
            $creditsTakenList[] = (int)$row['credits_taken'];
            $creditsRequired[] = (int)$row['credits_required'];
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Credits Taken',
                    'data' => $creditsTakenList,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Credits Required',
                    'data' => $creditsRequired,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    private function getGpaPerSemester()
    {
        $userId = user_id();
        $student = $this->studentModel->where('user_id', $userId)->first();
        $gpaDataStudent = $this->studentGradesModel->getGpaPerSemester($student->id);

        foreach ($gpaDataStudent as $row) {
            $semesters[] = 'Semester ' . $row['semester'];
            $gpaData[] = round($row['semester_gpa'], 2);
        }

        return [
            'labels' => $semesters,
            'datasets' => [
                [
                    'label' => 'GPA',
                    'data' => $gpaData,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'tension' => 0.1,
                    'fill' => false
                ]
            ]
        ];
    }
}
