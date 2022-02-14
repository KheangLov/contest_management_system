<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AjaxActionController;
use App\Http\Controllers\Admin\NewsCrudController;
use App\Http\Controllers\Admin\UserCrudController;
use App\Http\Controllers\Admin\LevelCrudController;
use App\Http\Controllers\Admin\AnswerCrudController;
use App\Http\Controllers\Admin\ContestCrudController;
use App\Http\Controllers\Admin\StudentCrudController;
use App\Http\Controllers\Admin\DocumentCrudController;
use App\Http\Controllers\Admin\QuestionCrudController;
use App\Http\Controllers\Admin\WorkShopCrudController;
use App\Http\Controllers\Admin\RegisteredContestCrudController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.
Route::group([
    'namespace'  => 'App\Http\Controllers\Admin\Auth',
    'middleware' => config('backpack.base.web_middleware', 'web'),
    'prefix'     => config('backpack.base.route_prefix'),
], function () {
    // if not otherwise configured, setup the auth routes
    if (config('backpack.base.setup_auth_routes')) {
        // Authentication Routes...
        Route::get('login', 'LoginController@showLoginForm')->name('backpack.auth.login');
        Route::post('login', 'LoginController@login');
        Route::get('logout', 'LoginController@logout')->name('backpack.auth.logout');
        Route::post('logout', 'LoginController@logout');

        // Registration Routes...
        Route::get('register', 'RegisterController@showRegistrationForm')->name('backpack.auth.register');
        Route::post('register', 'RegisterController@register');

        // if not otherwise configured, setup the password recovery routes
        if (config('backpack.base.setup_password_recovery_routes', true)) {
            Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('backpack.auth.password.reset');
            Route::post('password/reset', 'ResetPasswordController@reset');
            Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('backpack.auth.password.reset.token');
            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('backpack.auth.password.email');
        }
    }
});

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin'),
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () {
    // if not otherwise configured, setup the dashboard routes
    if (config('backpack.base.setup_dashboard_routes')) {
        Route::get('dashboard', 'AdminController@dashboard')->name('backpack.dashboard');
        Route::get('/', 'AdminController@redirect')->name('backpack');
    }

    // if not otherwise configured, setup the "my account" routes
    if (config('backpack.base.setup_my_account_routes')) {
        Route::get('edit-account-info', 'MyAccountController@getAccountInfoForm')->name('backpack.account.info');
        Route::post('edit-account-info', 'MyAccountController@postAccountInfoForm')->name('backpack.account.info.store');
        Route::post('change-password', 'MyAccountController@postChangePasswordForm')->name('backpack.account.password');
    }

    // custom admin routes
    Route::get('language_locale', function () {
        Session::put('locale', 'en');
        return redirect(backpack_url('languages'));
    });

    Route::post('user/{id}/restore', [UserCrudController::class, 'restore'])->name('user.restore');
    Route::crud('level', 'LevelCrudController');
    Route::post('level/{id}/restore', [LevelCrudController::class, 'restore'])->name('level.restore');
    Route::crud('contest', 'ContestCrudController');
    Route::post('contest/{id}/restore', [ContestCrudController::class, 'restore'])->name('contest.restore');
    Route::post('contest/approve/{id}', [ContestCrudController::class, 'approve']);
    Route::post('contest/reject/{id}', [ContestCrudController::class, 'reject']);
    Route::crud('question', 'QuestionCrudController');
    Route::post('question/{id}/restore', [QuestionCrudController::class, 'restore'])->name('question.restore');
    Route::post('question/approve/{id}', [QuestionCrudController::class, 'approve']);
    Route::post('question/reject/{id}', [QuestionCrudController::class, 'reject']);
    Route::crud('answer', 'AnswerCrudController');
    Route::post('answer/{id}/restore', [AnswerCrudController::class, 'restore'])->name('answer.restore');
    Route::post('answer/approve/{id}', [AnswerCrudController::class, 'approve']);
    Route::post('answer/reject/{id}', [AnswerCrudController::class, 'reject']);

    Route::get('web-ajax-call', [AjaxActionController::class, 'webAjaxCall'])->name('web-ajax-call');
    Route::post('modal-form-action', [AjaxActionController::class, 'modalFormAction'])->name('modal-form-action');
    Route::put('object-relation/{id}', [AjaxActionController::class, 'objectRelationAction'])->name('object-relation-action');

    Route::post('student/{id}/restore', [StudentCrudController::class, 'restore'])->name('student.restore');
    Route::crud('student', 'StudentCrudController');
    //ROUTE WORKSHOP
    Route::crud('workshop', 'WorkShopCrudController');
    Route::post('workshop/{id}/restore', [WorkShopCrudController::class, 'restore'])->name('workshop.restore');
    Route::post('workshop/approve/{id}', [WorkShopCrudController::class, 'approve']);
    Route::post('workshop/reject/{id}', [WorkShopCrudController::class, 'reject']);
    Route::post('workshop_joiner', [WorkShopCrudController::class, 'workshopJoiner'])->name('workshop.joiner');

    //ROUTE DOCUMENT
    Route::crud('document', 'DocumentCrudController');
    Route::post('document/approve/{id}', [DocumentCrudController::class, 'approve']);
    Route::post('document/reject/{id}', [DocumentCrudController::class, 'reject']);

    Route::crud('registered_contest', 'RegisteredContestCrudController');
    Route::post('registered_contest/{id}/restore', [RegisteredContestCrudController::class, 'restore'])->name('registered_contest.restore');

    Route::crud('category', 'CategoryCrudController');
    Route::crud('faq', 'FaqCrudController');
    Route::crud('news', 'NewsCrudController');
    Route::post('news/approve/{id}', [NewsCrudController::class, 'approve']);
    Route::post('news/reject/{id}', [NewsCrudController::class, 'reject']);
});
