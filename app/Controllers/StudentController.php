<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;

class StudentController extends BaseController
{
    private StudentModel $studentModel;
    protected $renderer;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->renderer = service('renderer');
    }

    public function index()
    {
        $parser = \Config\Services::parser();
        // get all student data
        $data['students'] = $this->studentModel->findAll();

        // render delete and edit button using view cell
        $data['students'] = array_map(function ($student) {
            $student->DeleteStudentButton = view_cell('DeleteStudentButtonCell', ['id' => (int) $student->id]);
            $student->EditStudentButton = view_cell('EditStudentButtonCell', ['id' => (int) $student->id]);
            return $student;
        }, $data['students']);

        $data['siteUrl'] = site_url('students/new');
        $data['content'] = $parser->setData($data)->render('components/students_list');
        $this->renderer->setData($data);
        $cacheKey = 'view_' . str_replace('/', '_', $this->request->getUri()->getPath());
        return cache()->remember($cacheKey, 1800, function () {
            return $this->renderer->render('students/index');
        });
    }

    public function show($id)
    {
        $parser = \Config\Services::parser();

        // find student data based on id and conver result to array
        $studentData = $this->studentModel->asArray()->find((int) $id);
        $data = [
            'student_id' => $studentData['student_id'],
            'name' => $studentData['name'],
            'study_program' => $studentData['study_program'],
            'current_semester' => $studentData['current_semester'],
            'entry_year' => $studentData['entry_year'],
            'academic_status' => $studentData['academic_status'],
            'gpa' => $studentData['gpa'],
            'status_cell' => view_cell('AcademicStatusCell', ['type' => $studentData['academic_status']], 86400),
        ];
        $data['content'] = $parser->setData($data)->render('components/student_profile');
        return view('students/profile', $data);
    }


    public function new(): string
    {
        return view('students/add');
    }

    public function create()
    {
        // get data from form
        $data = $this->request->getPost();

        // mapping data from form to prepare insert data to table
        $data = [
            'student_id' => $data['studentId'],
            'name' => $data['name'],
            'study_program' => $data['programStudy'],
            'current_semester' => $data['currentSemester'],
            'entry_year' => $data['entryYear'],
            'academic_status' => $data['academicStatus'],
            'gpa' => $data['gpa'],
        ];

        // validate data before insert data

        if (! $this->studentModel->validate($data)) {
            return view('students/add', [
                'errors' => $this->studentModel->errors(),
            ]);
        }

        // add data to table
        $this->studentModel->save($data);

        return redirect()->to('students')->with('success', 'Students added successfully');
    }

    public function edit($id): string
    {
        $data['student'] = $this->studentModel->find((int) $id);
        return view('students/edit', $data);
    }

    public function update($id)
    {
        // get data from form
        $data = $this->request->getPost();

        // mapping data from form to prepare insert data to table
        $data = [
            'student_id' => $data['studentId'],
            'name' => $data['name'],
            'study_program' => $data['programStudy'],
            'current_semester' => $data['currentSemester'],
            'entry_year' => $data['entryYear'],
            'academic_status' => $data['academicStatus'],
            'gpa' => $data['gpa'],
        ];

        // validate if no update occurs

        if (empty($data)) {
            return redirect()->back()->with('error', 'No data provided for update');
        }

        // find student data to update
        $student = $this->studentModel->find($id);

        // update student data with data from form
        $student->fill($data);

        // update student data at table and success
        if ($this->studentModel->save($student)) {
            session()->setFlashdata('success', 'User berhasil diupdate');
            return redirect()->to('/students');
        }

        // if update fail
        return redirect()->back()
            ->with('errors', $this->studentModel->errors())
            ->withInput();
    }


    public function deleteCourse($id)
    {
        // delete student data based on id
        $this->studentModel->delete($id);
        return redirect()->to('students')->with('success', 'Students deleted successfully');
    }
}
