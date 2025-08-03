<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

use App\Models\Department;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Lecturer;
use App\Models\Module;
use App\Models\ModuleLecturer;
use App\Models\Student;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\BatchLecturer;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Staff;
use App\Models\Timetable;
use App\Models\TimetableSlot;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        # Departments
        $departments = collect(['Computer Science', 'Mathematics', 'Physics', 'Business'])
            ->map(fn($name) => Department::create(['name' => $name]));

        # Courses
        $courses = collect(range(1, 6))
            ->map(fn($i) => Course::create([
                'name' => "Course $i",
                'description' => $faker->text(),
                'duration' => $faker->numberBetween(6, 48),
                'fee' => $faker->numberBetween(1500, 6000),
                'is_online' => $faker->boolean(30),
            ]));

        # Modules (each course has random 3-6 modules)
        $modules = collect();
        foreach ($courses as $course) {
            $numModules = $faker->numberBetween(3, 6);
            for ($i = 1; $i <= $numModules; $i++) {
                $modules->push(Module::create([
                    'name' => "Module $i for Course {$course->id}",
                    'credits' => $faker->numberBetween(2, 5),
                    'course_id' => $course->id,
                ]));
            }
        }

        # Batches (4 years, 2022-2025)
        $batches = collect(range(2022, 2025))
            ->map(fn($year) => Batch::create(['name' => "Batch $year"]));

        # Lecturers (random per department)
        $lecturers = collect(range(1, 12))
            ->map(fn() => Lecturer::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'position' => $faker->randomElement(['Professor', 'Assistant Professor', 'Lecturer']),
                'department_id' => $departments->random()->id,
                'salary' => $faker->numberBetween(3000, 9000),
            ]));
       

        # Assign lecturers randomly to modules (module_lecturers)
        foreach ($modules as $module) {
            // assign 1-3 lecturers per module
            $numLecturers = $faker->numberBetween(1, 3);
            $assignedLecturers = $lecturers->random($numLecturers);
            foreach ($assignedLecturers as $lecturer) {
                ModuleLecturer::create([
                    'module_id' => $module->id,
                    'lecturer_id' => $lecturer->id,
                ]);
            }
        }

        // Students (random count per batch 40-80)
        $students = collect();
        foreach ($batches as $batch) {
            $countStudents = $faker->numberBetween(40, 80);
            for ($i = 0; $i < $countStudents; $i++) {
                $createdAt = $faker->dateTimeBetween("{$batch->name}", '2025-12-31');
                $students->push(Student::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'address' => $faker->address,
                    'phone_number' => $faker->phoneNumber,
                    'batch_id' => $batch->id,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]));
            }
        }

        // Batch Lecturers assignments (each batch and module, assign random lecturers)
        foreach ($batches as $batch) {
            // random 3-7 modules assigned for batch
            $batchModules = $modules->random($faker->numberBetween(3, 7));
            foreach ($batchModules as $module) {
                // assign 1-2 lecturers per batch-module
                $batchModuleLecturers = $lecturers->random($faker->numberBetween(1, 2));
                $batchModuleStudents = $students->random($faker->numberBetween(1, 2));
                foreach ($batchModuleLecturers as $lecturer) {
                    DB::table('batch_lecturers')->insert([
                        'batch_id' => $batch->id,
                        'lecturer_id' => $lecturer->id,
                        'module_id' => $module->id,
                    ]);
                }
                foreach ($batchModuleStudents as $student) {
                    $batch->students()->attach($student->id);
                }
            }
        }

        // Exams (each batch has 3-5 exams between 2022-2025)
        $exams = collect();
        foreach ($batches as $batch) {
            $numExams = $faker->numberBetween(3, 5);
            for ($i = 0; $i < $numExams; $i++) {
                $startDate = $faker->dateTimeBetween("{$batch->name}", '2025-12-31');
                $exams->push(Exam::create([
                    'start_date' => $startDate->format('Ymd'),
                    'start_at' => $startDate,
                    'module_id' => Module::inRandomOrder()->first()->id,
                    'end_at' => Carbon::parse($startDate)->addHours($faker->numberBetween(2, 5)),
                    'batch_id' => $batch->id,
                ]));
            }
        }

        // Exam Results (for each exam, assign random students of batch with random scores)
        foreach ($exams as $exam) {
            $batchStudents = $students->where('batch_id', $exam->batch_id);
            $numResults = $faker->numberBetween(30, $batchStudents->count());
            $examStudents = $batchStudents->random($numResults);

            foreach ($examStudents as $student) {
                ExamResult::create([
                    'exam_id' => $exam->id,
                    'student_id' => $student->id,
                    'score' => $faker->numberBetween(30, 100),
                ]);
            }
        }

        // Transactions - variable payments per student (1-4 payments), random status and amounts
        foreach ($students as $student) {
            $paymentsCount = $faker->numberBetween(1, 4);
            for ($p = 0; $p < $paymentsCount; $p++) {
                $paymentDate = $faker->dateTimeBetween($student->created_at, '2025-12-31');
                Transaction::create([
                    'student_id' => $student->id,
                    'course_id' => $courses->random()->id,
                    'amount' => $faker->numberBetween(1500, 6000),
                    'payment_method' => $faker->randomElement(['cash', 'credit_card', 'bank_transfer']),
                    'status' => $faker->randomElement(['paid', 'pending']),
                    'updated_by' => 1, // admin user id assumed
                    'created_at' => $paymentDate,
                    'updated_at' => $paymentDate,
                ]);
            }
        }

        (new TimetableSlotSeeder())->run();

        // Users (Admin + some staff users)
        if (!User::where('email', 'admin@example.com')->exists()) {

            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // for ($i = 0; $i < 5; $i++) {
        //     User::create([
        //         'name' => $faker->name,
        //         'email' => $faker->unique()->safeEmail,
        //         'password' => bcrypt('password'),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }

        // Staff (linked to departments, 5-8 entries)
        for ($i = 0; $i < $faker->numberBetween(5, 8); $i++) {
            Staff::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'salary' => $faker->numberBetween(2000, 8000),
                'department_id' => $departments->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
