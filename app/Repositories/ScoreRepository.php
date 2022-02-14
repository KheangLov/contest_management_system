<?php

namespace App\Repositories;

use App\Models\Score;
use App\Repositories\StatisticRepository;
use App\Repositories\RegisteredContestRepository;
use Carbon\Carbon;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class ScoreRepository.
 */
class ScoreRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Score::class;
    }

    public function setScoreAfterExam($request)
    {
        $regConId = $request->registered_contest ?? '';
        $regContest = resolve(RegisteredContestRepository::class)->getById($regConId);

        $now = Carbon::now();
        $regContest->duration = Carbon::parse($regContest->start_date)->diffInMinutes($now);
        $regContest->update();

        return $this->model->create([
            'score' => resolve(StatisticRepository::class)->getRegContestStat($regConId)->sum('answer.score'),
            'registered_contest_id' => $regContest->id,
            'user_id' => $regContest->user_id,
        ]);
    }
}
