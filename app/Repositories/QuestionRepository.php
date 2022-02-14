<?php

namespace App\Repositories;

use App\Models\Question;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class QuestionRepository.
 */
class QuestionRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Question::class;
    }

    public function linkToContest($questions, $contestId)
    {
        $this->model->where('contest_id', $contestId)->update([
            'contest_id' => null
        ]);

        return $this->model->whereIn('id', $questions)->update([
            'contest_id' => $contestId
        ]);
    }

    public function checkCorrectAnswer($id, $answer)
    {
        return $this->model->find($id)->answer_id == $answer;
    }
}
