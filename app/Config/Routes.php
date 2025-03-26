<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/academics', 'CourseController::index');
$routes->get('unauthorized', 'Home::unauthorized');

$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    // Route lain seperti login, dll
    $routes->get('login', 'Auth::login', ['as' => 'login']);
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('register', 'Auth::register', ['as' => 'register']);
    $routes->post('register', 'Auth::attemptRegister');
});


// Routes yang hanya bisa diakses lecturer
$routes->group('lecturer', ['filter' => 'role:lecturer'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::lecturerDashboard');
    $routes->get('academics/courses', 'CourseController::showCourses', ['as' => 'academics_courses']);
    $routes->get('academics/courses/(:num)', 'CourseController::courseDetail/$1');
    $routes->delete('academics/courses/(:num)', 'CourseController::delete/$1');
    $routes->get('academics/courses/new', 'CourseController::new');
    $routes->post('academics/courses', 'CourseController::create');
    $routes->get('academics/courses/edit/(:num)', 'CourseController::edit/$1');
    $routes->put('academics/courses/edit/(:num)', 'CourseController::update/$1');
});

// Routes yang hanya bisa diakses student
$routes->group('student', ['filter' => 'role:student'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('enrollment', 'StudentController::enrollment');
    $routes->get('profile/(:num)', 'StudentController::show/$1');
    $routes->get('upload/diploma_file_form', 'StudentController::uploadDiplomaForm');
    $routes->post('upload/diploma_file', 'StudentController::uploadDiplomaFile');
    $routes->get('course_registration', 'StudentController::courseRegistrationForm');
    $routes->post('course_registration', 'StudentController::courseRegistration');
});

// Routes yang bisa diakses oleh lecturer dan admin
$routes->group('', ['filter' => 'role:admin,lecturer'], function ($routes) {
    $routes->get('report/enrollment', 'ReportController::enrollmentForm');
    $routes->get('report/enrollmentExcel', 'ReportController::enrollmentExcel');
    $routes->get('report_students', 'ReportController::studentsbyprogramForm');
    $routes->post('report/studentsbyprogram', 'ReportController::studentsbyprogramPdf');
});

// Route unauthorized

$routes->get('/addUserToGroupForm', 'Auth::addUserToGroupForm');
$routes->post('/addUserToGroup', 'Auth::addUserToGroup');


$routes->group('admin/users', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'UserController::index', ['as' => 'users']);
    $routes->get('edit/(:num)', 'UserController::edit/$1');
    $routes->put('update/(:num)', 'UserController::update/$1');
    $routes->delete('delete/(:num)', 'UserController::delete/$1');
    $routes->get('register', 'UserController::create');
    $routes->post('store', 'UserController::store');
});

$routes->group('admin/students', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'StudentController::index', ['as' => 'students']);
    $routes->get('create', 'StudentController::new');
    $routes->post('store', 'StudentController::create');
    $routes->get('edit/(:num)', 'StudentController::edit/$1');
    $routes->put('update/(:num)', 'StudentController::update/$1');
    $routes->delete('delete/(:num)', 'StudentController::delete/$1');
});

$routes->get('admin/dashboard', 'DashboardController::adminDashboard', ['filter' => 'role:admin']);

$routes->get('sendEmail', 'StudentController::sendEmail');
$routes->get('upload', 'StudentController::uploadForm');
$routes->post('upload', 'StudentController::upload');
