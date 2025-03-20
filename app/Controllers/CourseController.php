<?php

namespace App\Controllers;

use App\Libraries\DataParams;
use App\Models\CourseModel;

class CourseController extends BaseController
{
    protected $renderer;
    private CourseModel $courseModel;

    public function __construct()
    {
        $this->renderer = service('renderer');
        $this->courseModel = new CourseModel();
    }
    public function index(): string
    {
        $data['academicStatistics'] = [
            "university" => "Rain University",
            "academicYear" => "2024/2025",
            "totalStudents" => 12000,
            "totalFaculties" => 10,
            "totalDepartments" => 50,
            "studentStatistics" => [
                "Active" => 8000,
                "On Leave" => 3000,
                "Graduate" => 1000
            ],
        ];
        $this->renderer->setData($data);
        return $this->renderer->render('course/index');
        // $cacheKey = 'view_' . str_replace('/', '_', $this->request->getUri()->getPath());
        // return cache()->remember($cacheKey, 3600, function () {});
    }

    public function showCourses()
    {
        $params = new DataParams([
            'search' => $this->request->getGet('search'),
            'credits' => $this->request->getGet('credits'),
            'semester' => $this->request->getGet('semester'),
            'sort' => $this->request->getGet('sort'),
            'order' => $this->request->getGet('order'),
            'page_courses' => $this->request->getGet('page_courses'),
            'perPage' => $this->request->getGet('perPage')
        ]);


        $result = $this->courseModel->getFilteredCourses($params);


        $data = [
            'title' => 'List Courses',
            'courses' => $result['courses'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'credits' => $this->courseModel->getAllCredits(),
            'semesters' => $this->courseModel->getAllSemesters(),
            'baseUrl' => base_url('lecturer/academics/courses')
        ];


        // get all student data
        // $data['courses'] = $this->courseModel->findAll();
        // $data['courses'] = $this->courseModel->paginate(2, 'courses');
        // $data['pager'] = $this->courseModel->pager;
        $data['content'] = view_cell('ListCoursesCell', ['courses' => $data['courses'], 'params' => $data['params'], 'baseUrl' => $data['baseUrl']]);
        $this->renderer->setData($data);
        // $cacheKey = 'view_' . str_replace('/', '_', $this->request->getUri()->getPath());
        // return cache()->remember($cacheKey, 86400, function () {
        //     return $this->renderer->render('course/course_list');
        // });
        return $this->renderer->render('course/course_list');
    }

    public function courseDetail($id)
    {

        // show course data based on id
        $courseData = $this->courseModel->find($id);
        $data = [
            'id' => $courseData->id,
            'code' => $courseData->code,
            'name' => $courseData->name,
            'credits' => $courseData->credits,
            'semester' => $courseData->semester,
        ];
        return view('course/detail', $data);
    }

    public function delete($id)
    {
        // delete course data based on id
        $this->courseModel->delete($id);
        return redirect()->to(route_to('academics_courses'))->with('success', 'Students deleted successfully');
    }

    public function new(): string
    {
        return view('course/add');
    }

    public function create()
    {
        // get data from form
        $data = $this->request->getPost();

        // mapping data from form to prepare insert data to table
        $data = [
            'name' => $data['name'],
            'code' => $data['code'],
            'credits' => $data['credits'],
            'semester' => $data['semester'],
        ];

        // validate data before insert data
        if (! $this->courseModel->validate($data)) {
            return redirect()->back()
                ->with('errors', $this->courseModel->errors())
                ->withInput();
        }

        // add data to table
        $this->courseModel->save($data);

        return redirect()->to(route_to('academics_courses'))->with('success', 'Students added successfully');
    }

    public function edit($id): string
    {
        $data['course'] = $this->courseModel->find((int) $id);
        return view('course/edit', $data);
    }

    public function update($id)
    {
        // get data from form
        $data = $this->request->getPost();

        // find course data to update
        $course = $this->courseModel->find($id);
        // update course data with data from form
        $course->fill($data);

        // update course data at table and success
        if ($this->courseModel->save($course)) {
            session()->setFlashdata('success', 'User berhasil diupdate');
            return redirect()->to(route_to('academics_courses'));
        }

        // if update fail
        return redirect()->back()
            ->with('errors', $this->courseModel->errors())
            ->withInput();
    }
}
