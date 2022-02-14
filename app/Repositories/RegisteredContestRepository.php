<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\RegisteredContest;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class RegisteredContestRepository.
 */
class RegisteredContestRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return RegisteredContest::class;
    }

    public function updateRegContestDate($id)
    {
        $entry = $this->model->find($id);
        if (!$entry) {
            return false;
        }
        $now = Carbon::now();
        $startDate = $now->toDateTimeString();
        $contest = optional($entry->contest);
        $endDate = $now->addMinutes($contest->duration);
        $entry->start_date = $startDate;
        $entry->end_date = $endDate > $contest->end_at ? $contest->end_at : $endDate;
        return $entry->update();
    }

    public function checkIfUserAlreadyRegContest($id, $userId)
    {
        return $this->model
            ->where('contest_id', $id)
            ->where('user_id', $userId)
            ->first();
    }
}
