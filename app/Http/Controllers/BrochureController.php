<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use App\Models\Course;

class BrochureController extends Controller
{

    public function download(Course $course)
    {
        $course->load('modules'); // assuming you have a `modules()` relationship

        $data = [
            'course' => $course,
        ];

        $pdf = Pdf::loadView('pdf.course-brochure', $data);

        return $pdf->download("{$course->title}-brochure.pdf");
    }
}
