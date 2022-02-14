<?php

namespace App\Repositories;

use App\Models\Statistic;
use App\Repositories\QuestionRepository;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class StatisticRepository.
 */
class StatisticRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Statistic::class;
    }

    public function updateOrCreateStat($request)
    {
        $choseAnswer = $request->chose_answer ?? '';
        $regCon = $request->registered_contest ?? '';
        $question = $request->question ?? '';
        $isCorrect = resolve(QuestionRepository::class)->checkCorrectAnswer($question, $choseAnswer);
        return $this->model->updateOrCreate(
            ['registered_contest_id' => $regCon, 'question_id' => $question],
            ['chose_answer_id' => $choseAnswer, 'is_correct' => $isCorrect],
        );
    }

    public function getChose($regCon, $question)
    {
        return $this->model
            ->where('registered_contest_id', $regCon)
            ->where('question_id', $question)
            ->first();
    }

    public function getRegContestStat($regCon)
    {
        return $this->model
            ->where('registered_contest_id', $regCon)
            ->get();
    }
}
