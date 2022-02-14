<?php

namespace App\Observers;

use App\Models\News;

class NewsObserver
{
    /**
     * Handle the News "created" event.
     *
     * @param  \App\Models\News  $News
     * @return void
     */
    public function creating(News $news)
    {
        $news->status = 'waiting';
    }

    public function updating(News $news)
    {
        if ($news->getOriginal('status') == config('const.answer_status.rejected')) {
            $news->status = 'waiting';
        }
    }

    /**
     * Handle the News "created" event.
     *
     * @param  \App\Models\News  $News
     * @return void
     */
    public function created(News $news)
    {
        //
    }

    /**
     * Handle the News "updated" event.
     *
     * @param  \App\Models\News  $News
     * @return void
     */
    public function updated(News $news)
    {
        //
    }

    /**
     * Handle the News "deleted" event.
     *
     * @param  \App\Models\News  $News
     * @return void
     */
    public function deleted(News $news)
    {
        //
    }

    /**
     * Handle the News "restored" event.
     *
     * @param  \App\Models\News  $News
     * @return void
     */
    public function restored(News $news)
    {
        //
    }

    /**
     * Handle the News "force deleted" event.
     *
     * @param  \App\Models\News  $News
     * @return void
     */
    public function forceDeleted(News $news)
    {
        //
    }
}
