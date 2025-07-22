<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Transaction;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Mail\TransactionCreated;
use Exception;
use Illuminate\Support\Facades\Mail;


class TransactionController extends Controller
{
    public function create(Course $course)
    {
        return Inertia::render('Transaction', [
            'course' => $course,
        ]);
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'address' => 'required|string',
                'phone_number' => 'required|string',
                'course_id' => 'required|exists:courses,id',
                'payment_method' => 'required|in:cash,credit_card,bank_transfer',
            ]);

            $latestBatch = \App\Models\Batch::latest('created_at')->first();
            $student = Student::where('email', $validated['email'])->first();
            if (!$student) {

                $student = Student::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'address' => $validated['address'],
                    'status' => 'inactive',
                    'phone_number' => $validated['phone_number'],
                    'batch_id' => $latestBatch?->id,
                ]);
            }
            $course = Course::find($validated['course_id']);
            dd($course);
            $transaction = Transaction::create([
                'student_id' => $student->id,
                'course_id' => $validated['course_id'],
                'amount' => $course->fee,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'updated_by' => 1
            ]);

            // Bank account number for transfers
            $bankAccountNumber = '1234567890'; // Put your real account number here

            // Send email
            Mail::to($student->email)->send(new TransactionCreated(
                $student,
                $transaction,
                $transaction->payment_method === 'bank_transfer' ? $bankAccountNumber : null
            ));

            return to_route('courses');
        } catch (Exception $e) {
            logger($e->getMessage());
            throw $e;
        }
    }
}
