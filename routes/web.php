<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FaqController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AjaxActionController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\DocumentController;
use App\Http\Controllers\Frontend\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'homepage'])->name('homepage');

Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'kh'])) {
        abort(400);
    }

    if (request()->segment(1) == 'taking-exam') {
        redirect()->route('taking_exam', ['regContestId' => request()->regContestId]);
    }

    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('workshop', [HomeController::class, 'index'])->name('workshop');
Route::get('/workshop/details/{id}', [HomeController::class, 'workshopDetails'])->name('workshop_details');

Route::get('contest', [HomeController::class, 'contest'])->name('contest');
Route::get('contest/details/{id}', [HomeController::class, 'contestDetail'])->name('contest_detail');

Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about_us');
Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact_us');

Route::get('my-students', [HomeController::class, 'studentBySchool'])->name('my_student');
Route::get('my-student/{id}', [HomeController::class, 'studentBySchoolDetail'])->name('my_student_detail');
Route::get('my-contest', [HomeController::class, 'studentContests'])->name('my_contest');
Route::put('my-contest/{id}/start', [HomeController::class, 'startContest'])->name('my_contest_start');
Route::get('taking-exam/{regContestId}', [HomeController::class, 'takingExam'])->name('taking_exam');
Route::get('view-stat/{regContestId}', [HomeController::class, 'viewContestStat'])->name('view_contest_stat');
Route::get('certificate/{regContestId}', [HomeController::class, 'certificate'])->name('view_certificate');
Route::get('workshop-certificate/{wsId}', [HomeController::class, 'workshopCertificate'])->name('view_workshop_certificate');
Route::post('contact-us/send-mail', [HomeController::class, 'sendMailContactUs'])->name('send_mail_contact_us');

Route::get('exam-questions/{contestId}', [AjaxActionController::class, 'getContestQuestionIds'])->name('exam_questions');
Route::get('exam-attempt-questions/{id}', [AjaxActionController::class, 'getAttemptQuestion'])->name('exam_attempt_questions');
Route::post('exam-submit-question', [AjaxActionController::class, 'submitAnswer'])->name('exam_submit_question');
Route::post('submit-exam', [AjaxActionController::class, 'submitExam'])->name('submit_exam');

Route::get('form_register', [RegisterController::class, 'formRegister'])->name('formRegister');
Route::post('register', [RegisterController::class, 'create'])->name('register');

Route::get('form_login', [LoginController::class, 'formLogin'])->name('formLogin');
Route::post('login', [LoginController::class, 'save'])->name('login');
Route::get('deep_link/login/contest', [LoginController::class, 'deepLinkLogin'])->name('deep_link_login');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('document', [DocumentController::class, 'index'])->name('document');

//FAQ
Route::get('faq', [FaqController::class, 'index'])->name('faq');
Route::get('faq_question', [FaqController::class, 'faqQuestion'])->name('faq_question');
Route::get('faq_answer', [FaqController::class, 'faqAnswer'])->name('faq_answer');

//NEWS
Route::get('news/details/{id}', [HomeController::class, 'newsDetail'])->name('news_detail');
Route::post('student/create', [HomeController::class, 'creatStudent'])->name('create_student');

Route::get('my-account', [HomeController::class, 'myAccount'])->name('my_account');
