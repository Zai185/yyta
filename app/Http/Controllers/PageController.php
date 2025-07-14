<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard', [
            'courses' => Course::with('modules')->latest()->limit(3)->get()
        ]);
    }

    public function about()
    {
        return Inertia::render('About');
    }

    public function courses()
    {
        return Inertia::render(
            'Courses',
            [
                'courses' => Course::with('modules')->get()
            ]
        );
    }
    public function course_detail(int $id)
    {
        $course = Course::where('id', $id)->with('modules')->first();
        return Inertia::render(
            'CourseDetail',
            [
                'course' => $course
            ]
        );
    }

    public function contact_us()
    {
        return Inertia::render('ContactUs');
    }
}
