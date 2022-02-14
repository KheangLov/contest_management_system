<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Answer;
use App\Repositories\ContestRepository;
use App\Repositories\QuestionRepository;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class AnswerRepository.
 */
class AnswerRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Answer::class;
    }

    public function linkToQuestion($answers, $questionId)
    {
        $this->model->where('question_id', $questionId)->update([
            'question_id' => null
        ]);

        return $this->model->whereIn('id', $answers)->update([
            'question_id' => $questionId
        ]);
    }

    public function approveFromQuestion($questionId)
    {
        return $this->model->where('question_id', $questionId)->update([
            'auth_by' => backpack_user()->id,
            'auth_at' => Carbon::now(),
            'status' => config('const.contest_status.approved')
        ]);
    }

    public function rejectFromQuestion($questionId)
    {
        return $this->model->where('question_id', $questionId)->update([
            'auth_by' => null,
            'auth_at' => null,
            'status' => config('const.contest_status.rejected')
        ]);
    }

    public function updateScore($id, $request)
    {
        $score = $request->score ?? 0;
        $contest = $request->contest ?? '';
        $question = $request->question ?? '';
        $answer = $this->model->find($id);
        if (!$answer || !$contest) {
            return false;
        }

        $oldScore = $answer->score ?? 0;
        $totalScore = resolve(ContestRepository::class)->getTotalContestScore($contest) - $oldScore + $score;

        if (resolve(QuestionRepository::class)->checkCorrectAnswer($question, $answer->id)) {
            $maxScore = 100;
            if ($totalScore > $maxScore) {
                $score = $oldScore;
                $maxCal = $totalScore - $maxScore;
                if ($maxCal < 0) {
                    $score += $maxCal;
                }
                $totalScore -= $score;
            }
        }

        $answer->update([
            'score' => $score,
        ]);

        return [
            'total_score' => $totalScore,
            'current_score' => $score,
        ];
    }
}
