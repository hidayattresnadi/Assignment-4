<?php

namespace App\Controllers;

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
        $cacheKey = 'view_' . str_replace('/', '_', $this->request->getUri()->getPath());
        return cache()->remember($cacheKey, 3600, function () {
            return $this->renderer->render('course/index');
        });
    }

    public function showCourses()
    {
        // get all student data
        $data['courses'] = $this->courseModel->findAll();
        $data['content'] = view_cell('ListCoursesCell', ['courses' => $data['courses']]);
        $this->renderer->setData($data);
        $cacheKey = 'view_' . str_replace('/', '_', $this->request->getUri()->getPath());
        return cache()->remember($cacheKey, 86400, function () {
            return $this->renderer->render('academic/course_list');
        });
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
            return view('academics/courses/add', [
                'errors' => $this->courseModel->errors(),
            ]);
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

        // validate if no update occurs
        if (empty($data)) {
            return redirect()->back()->with('error', 'No data provided for update');
        }

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
