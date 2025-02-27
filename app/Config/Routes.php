<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->resource('students', ['controller' => 'StudentController']);
$routes->get('/academics', 'CourseController::index');
$routes->get('/academics/courses', 'CourseController::showCourses', ['as' => 'academics_courses']);
$routes->get('/academics/courses/(:num)', 'CourseController::courseDetail/$1');
$routes->delete('/academics/courses/(:num)', 'CourseController::delete/$1');
$routes->get('/academics/courses/new', 'CourseController::new');
$routes->post('/academics/courses', 'CourseController::create');
$routes->get('/academics/courses/edit/(:num)', 'CourseController::edit/$1');
$routes->put('/academics/courses/edit/(:num)', 'CourseController::update/$1');
