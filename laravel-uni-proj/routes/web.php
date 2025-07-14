<?php

use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// User routes
Route::resource('users', 'App\Http\Controllers\UserController');

// Batch routes
Route::resource('batches', 'App\Http\Controllers\BatchController');

// Course routes
Route::resource('courses', 'App\Http\Controllers\CourseController');

// Department routes
Route::resource('departments', 'App\Http\Controllers\DepartmentController');

// Lecturer routes
Route::resource('lecturers', 'App\Http\Controllers\LecturerController');

// Module routes
Route::resource('modules', 'App\Http\Controllers\ModuleController');

// Staff routes
Route::resource('staff', 'App\Http\Controllers\StaffController');

// Student routes
Route::resource('students', 'App\Http\Controllers\StudentController');