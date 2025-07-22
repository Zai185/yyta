<?php

use App\Filament\Pages\ChatConversation;
use App\Http\Controllers\BrochureController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Mail\ContactThankYouMail;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return to_route('dashboard');
});

Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/courses', [PageController::class, 'courses'])->name('courses');
Route::get('/courses/{id}', [PageController::class, 'course_detail'])->name('courses.detail');
Route::get('/contact-us', [PageController::class, 'contact_us'])->name('contact-us');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string|max:30',
        'subject' => 'nullable|string|max:255',
        'message' => 'required|string',
    ]);

    // Send email to user
    Mail::to($validated['email'])->send(new ContactThankYouMail(
        $validated['name'],
        $validated['message'],
        $validated['subject']
    ));

    return redirect()->back();
});

Route::post('/subscribe', function (Request $request) {

    $request->validate([
        'email' => ['required', 'email'],
    ]);

    $email = $request->input('email');

    // You could also store in DB here, e.g., in a `subscribers` table

    Mail::raw("Thank you for subscribing to Y Max University.\n\nWe'll keep you updated on our latest news and programs.", function ($message) use ($email) {
        $message->to($email)
            ->subject('Subscription Confirmation - Y Max University');
    });
});
Route::get('/courses/{course}/brochure', [BrochureController::class, 'download'])->name('courses.brochure');
Route::get('/courses/{course}/purchase', [TransactionController::class, 'create'])
    ->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])
    ->name('transactions.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/chat/send', [ChatController::class, 'send']);
Route::get('/chat/history', [ChatController::class, 'history']);

Route::get('/admin/chat-conversation/{messageId}', ChatConversation::class)
    ->name('filament.pages.chat-conversation')
    ->middleware([
        'web',
        'auth', // or 'filament.auth' if using a custom guard
        config('filament.middleware.base'),
    ]);

require __DIR__ . '/auth.php';
