<?php

namespace App\Observers;

use App\Models\Answer;

class AnswerObserver
{
    public function creating(Answer $answer)
    {
        $answer->status = 'waiting';
    }

    public function updating(Answer $answer)
    {
        if ($answer->getOriginal('status') == config('const.answer_status.rejected')) {
            $answer->status = 'waiting';
        }
    }

    /**
     * Handle the Answer "created" event.
     *
     * @param  \App\Models\Answer  $answer
     * @return void
     */
    public function created(Answer $answer)
    {
        //
    }

    /**
     * Handle the Answer "updated" event.
     *
     * @param  \App\Models\Answer  $answer
     * @return void
     */
    public function updated(Answer $answer)
    {
        //
    }

    /**
     * Handle the Answer "deleted" event.
     *
     * @param  \App\Models\Answer  $answer
     * @return void
     */
    public function deleted(Answer $answer)
    {
        //
    }

    /**
     * Handle the Answer "restored" event.
     *
     * @param  \App\Models\Answer  $answer
     * @return void
     */
    public function restored(Answer $answer)
    {
        //
    }

    /**
     * Handle the Answer "force deleted" event.
     *
     * @param  \App\Models\Answer  $answer
     * @return void
     */
    public function forceDeleted(Answer $answer)
    {
        //
    }
}
