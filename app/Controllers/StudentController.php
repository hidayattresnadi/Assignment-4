<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParamsStudent;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\StudentModel;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;

class StudentController extends BaseController
{
    private StudentModel $studentModel;
    protected UserModel $userModel;
    protected EnrollmentModel $enrollmentModel;
    protected $renderer;
    protected CourseModel $courseModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->userModel = new UserModel();
        $this->enrollmentModel = new EnrollmentModel();
        $this->renderer = service('renderer');
        $this->courseModel = new CourseModel();
    }

    public function index()
    {
        $parser = \Config\Services::parser();

        $params = new DataParamsStudent([
            'search' => $this->request->getGet('search'),
            'academic_status' => $this->request->getGet('academic_status'),
            'entry_year' => $this->request->getGet('entry_year'),
            'study_program' => $this->request->getGet('study_program'),
            'sort' => $this->request->getGet('sort'),
            'order' => $this->request->getGet('order'),
            'page_students' => $this->request->getGet('page_students'),
            'perPage' => $this->request->getGet('perPage')
        ]);


        $result = $this->studentModel->getFilteredStudents($params);


        $data = [
            'students' => $result['students'],
            'total' => $result['total'],
            'academic_statuses' => $this->studentModel->getAllAcademicStatuses(),
            'entry_years' => $this->studentModel->getAllEntryYears(),
            'study_programs' => $this->studentModel->getAllStudyPrograms(),
            'baseUrl' => base_url('admin/students'),
            'student_id_th' => view_cell('SortTableHeaderCell', ['params' => $params, 'baseUrl' => base_url('/students'), 'tableField' => 'student_id', 'tableTitleHeader' => 'Student Id']),
            'current_semester_th' => view_cell('SortTableHeaderCell', ['params' => $params, 'baseUrl' => base_url('/students'), 'tableField' => 'current_semester', 'tableTitleHeader' => 'Current Semester'])
        ];

        // get all student data
        // $data['students'] = $this->studentModel->findAll();

        // render delete and edit button using view cell
        $data['students'] = array_map(function ($student) {
            $student->DeleteStudentButton = view_cell('DeleteStudentButtonCell', ['id' => (int) $student->id]);
            $student->EditStudentButton = view_cell('EditStudentButtonCell', ['id' => (int) $student->id]);
            return $student;
        }, $data['students']);

        $data['siteUrl'] = site_url('students/new');
        $data['content'] = $parser->setData($data)->render('components/students_list');
        $data['pager'] = $result['pager'];
        $data['params'] = $params;
        $this->renderer->setData($data);
        // $cacheKey = 'view_' . str_replace('/', '_', $this->request->getUri()->getPath());
        // return cache()->remember($cacheKey, 1800, function () {
        //     return $this->renderer->render('students/index');
        // });

        return $this->renderer->render('students/index');
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
        $data['users'] = $this->userModel->findAll();
        return view('students/add', $data);
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
            'user_id' => $data['user_id']
        ];

        // validate data before insert data

        if (! $this->studentModel->validate($data)) {
            return redirect()->back()
                ->with('errors', $this->studentModel->errors())
                ->withInput();
        }

        // add data to table
        $this->studentModel->save($data);

        return redirect()->to('admin/students')->with('success', 'Students added successfully');
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

        // find student data to update
        $student = $this->studentModel->find($id);

        // update student data with data from form
        $student->fill($data);

        // update student data at table and success
        if ($this->studentModel->save($student)) {
            session()->setFlashdata('success', 'User berhasil diupdate');
            return redirect()->to('admin/students');
        }

        // if update fail
        return redirect()->back()
            ->with('errors', $this->studentModel->errors())
            ->withInput();
    }

    public function delete($id)
    {
        // delete student data based on id
        $this->studentModel->delete($id);
        return redirect()->to('admin/students')->with('success', 'Students deleted successfully');
    }

    public function enrollment()
    {
        $userId = user_id();
        $student = $this->studentModel->where('user_id', $userId)->first();
        $data['enrollments'] = $this->enrollmentModel->getEnrollmentUsers($student->id);

        return view('students/enrollments', $data);
    }

    public function sendEmail()
    {
        $email = service('email');
        $email->setFrom('your@example.com', 'Your Name');
        $email->setTo('dayat@yopmail.com');
        $imagePath = ROOTPATH . 'public/uploads/gambar.png';

        // $email->setSubject('Email Test');

        // $email->setMessage('Testing the email class.');

        $email->setSubject('Email Test dengan Template HTML');

        $data = [
            'title' => 'Pemberitahuan Penting',
            'name' => 'John Doe',
            'content' => 'Ini adalah isi email yang akan dikirimkan.',
            'features' => [
                'Fitur 1: Informasi penting',
                'Fitur 2: Detail produk',
                'Fitur 3: Cara penggunaan'
            ]
        ];

        $message = view('email/testEmail', $data); // Isi konten email
        $email->setMessage($message);

        if (file_exists($imagePath)) {
            $email->attach($imagePath);
        }

        $ccList = [
            'dayat24@yopmail.com',
            'dayat25@yopmail.com'
        ];

        $email->setCC($ccList);

        if ($email->send()) {
            return redirect()->to('admin/students')->with('success', 'Email berhasil dikirim');
        } else {
            $data = ['error' => $email->printDebugger()];
            return view('email_form', $data);
        }
    }

    public function upload()
    {
        helper('form');
        $userfile = $this->request->getFile('userfile');

        $validationRules = [
            'userfile' => [
                'label' => 'Gambar',
                'rules' => [
                    'uploaded[userfile]',
                    'is_image[userfile]',
                    'mime_in[userfile,image/jpg,image/jpeg,image/png,image/gif]',
                    'max_size[userfile,3*1024]', // 5MB dalam KB (5 * 1024)
                ],
                'errors' => [
                    'uploaded' => 'Silakan pilih file gambar untuk diunggah',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'File harus berformat JPG, JPEG, PNG, atau GIF',
                    'max_size' => 'Ukuran file tidak boleh melebihi 1MB'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }


        // klo mau dapetin make nama file asli
        // $fileName = $userfile->getName();

        // kalau mau nyimpen make nama random
        $newName = $userfile->getRandomName();
        $userfile->move(WRITEPATH . 'uploads', $newName);
        $filepath = WRITEPATH . 'uploads/' . $newName;

        $this->createImageVersions($filepath, $newName);

        $data = ['uploaded_fileinfo' => new File($filepath)];
        $data['baseUrl'] = 'upload';
        return view('upload_success', $data);
    }

    public function uploadForm()
    {
        helper('form');
        return view('uploadForm');
    }

    private function createImageVersions($filePath, $fileName)
    {
        $image = service('image');


        $image->withFile($filePath)
            ->fit(100, 100, 'center')
            ->save(WRITEPATH . 'uploads/thumbnail/' . $fileName);


        // $image->withFile($filePath)
        //     ->fit(300, 300, 'center')
        //     ->save(WRITEPATH . 'uploads/medium/' . $fileName);

        // Jika ingin menggunakan resize (mempertahankan ratio) daripada fit:
        $image->withFile($filePath)
            ->resize(300, 300, true, 'height')
            ->save(WRITEPATH . 'uploads/medium/' . $fileName);

        $image->withFile($filePath)
            ->text('Copyright 2017 My Photo Co', [
                'color'      => '#fff',
                'opacity'    => 0.5,
                'withShadow' => true,
                'hAlign'     => 'center',
                'vAlign'     => 'bottom',
                'fontSize'   => 20,
            ])
            ->save(WRITEPATH . 'uploads/watermark/' . $fileName);
    }

    public function uploadDiplomaForm()
    {
        helper('form');
        return view('students/upload_diploma_file');
    }

    public function uploadDiplomaFile()
    {
        helper('form');
        $userfile = $this->request->getFile('userfile');

        $validationRules = [
            'userfile' => [
                'label' => 'Document',
                'rules' => [
                    'uploaded[userfile]',
                    'mime_in[userfile,application/pdf]',
                    'max_size[userfile,5*1024]', // 5MB dalam KB (5 * 1024)
                ],
                'errors' => [
                    'uploaded' => 'Please choose file to upload',
                    'mime_in' => 'File should be onlu in pdf format',
                    'max_size' => 'File size is not allowed for more than 5 MB'
                ]
            ]
        ];


        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = user_id();
        $student = $this->studentModel->where('user_id', $userId)->first();
        $studentId = $student ? $student->student_id : null;
        $studentName = $student ? $student->name : null;
        $timestamp = date("Ymd_His"); // Format: TahunBulanHari_JamMenitDetik
        $extension = pathinfo($userfile->getClientName(), PATHINFO_EXTENSION); // Ambil ekstensi file asli

        $newName = $studentId . "_" . $timestamp . "." . $extension;
        $uploadPath = WRITEPATH . 'uploads/' . $studentName;
        // Cek apakah folder sudah ada, jika belum buat folder
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true); // Buat folder dengan izin penuh
        }

        $userfile->move($uploadPath, $newName);
        $filepath = $uploadPath . '/' . $newName;

        $data = ['uploaded_fileinfo' => new File($filepath)];
        $data['baseUrl'] = 'student/upload/diploma_file_form';

        $student->diploma_file = $filepath;
        $this->studentModel->save($student);

        return view('upload_success', $data);
    }


    public function courseRegistrationForm()
    {
        $data['courses'] = $this->courseModel->findAll();
        return view('students/course_registration', $data);
    }

    public function courseRegistration()
    {
        $data = $this->request->getPost();
        $userId = user_id();
        $student = $this->studentModel->where('user_id', $userId)->first();
        $user = $this->userModel->find($userId);
        $courseId = $data['course_id'];
        $course = $this->courseModel->find(+$courseId);

        $email = service('email');
        $email->setFrom('rain@university.com', 'Rain university');
        $email->setTo($user->email);

        $email->setSubject('Course Registration');

        $time = Time::now('Asia/Jakarta');
        $formattedDate = $time->toLocalizedString('EEEE, dd MMMM yyyy'); // Format tanggal
        $formattedTime = $time->toLocalizedString('HH:mm:ss'); // Format jam & menit

        $data = [
            'student_id' => $student->id,
            'student_university_id' => $student->student_id,
            'name' => $student->name,
            'course_name' => $course->name,
            'course_code' => $course->code,
            'course_id' => $course->id,
            'academic_year' => date('Y'),
            'semester' => $student->current_semester,
            'course_credits' => $course->credits,
            'registration_date' => $formattedDate,
            'registration_time' => $formattedTime,
        ];

        $this->enrollmentModel->save($data);

        $message = view('email/course_registration', $data);
        $email->setMessage($message);

        if ($email->send()) {
            return redirect()->to('student/enrollment')->with('success', 'Email sended successfully');
        } else {
            $data = ['error' => $email->printDebugger()];
            return view('students/course_registration', $data);
        }
    }
}
