<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\StudentModel;
use Myth\Auth\Models\UserModel;

class DashboardController extends BaseController
{
    private StudentModel $studentModel;
    protected UserModel $userModel;
    protected EnrollmentModel $enrollmentModel;
    private CourseModel $courseModel;
    protected $renderer;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->userModel = new UserModel();
        $this->enrollmentModel = new EnrollmentModel();
        $this->courseModel = new CourseModel();
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
}
