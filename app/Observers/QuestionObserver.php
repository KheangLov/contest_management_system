<?php

namespace App\Observers;

use App\Models\Question;
use App\Repositories\AnswerRepository;

class QuestionObserver
{
    /**
     * Handle the Contest "created" event.
     *
     * @param  \App\Models\Question  $contest
     * @return void
     */
    public function creating(Question $question)
    {
        $question->status = 'waiting';
    }

    public function updating(Question $question)
    {
        if ($question->getOriginal('status') == config('const.question_status.rejected')) {
            $question->status = 'waiting';
        }
    }
}
