<?php

namespace App\Providers;

use App\Models\News;
use App\Models\User;
use App\Models\Answer;
use App\Models\Contest;
use App\Models\Document;
use App\Models\Question;
use App\Models\WorkShop;
use App\Observers\NewsObserver;
use App\Observers\UserObserver;
use App\Observers\AnswerObserver;
use App\Observers\ContestObserver;
use App\Observers\DocumentObserver;
use App\Observers\QuestionObserver;
use App\Observers\WorkShopObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Contest::observe(ContestObserver::class);
        Question::observe(QuestionObserver::class);
        Answer::observe(AnswerObserver::class);
        WorkShop::observe(WorkShopObserver::class);
        Document::observe(DocumentObserver::class);
        News::observe(NewsObserver::class);
    }
}
