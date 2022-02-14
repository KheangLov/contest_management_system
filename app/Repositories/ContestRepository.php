<?php

namespace App\Repositories;

use App\Models\Contest;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class ContestRepository.
 */
class ContestRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Contest::class;
    }

    public function setScopesAttr($args = [])
    {
        $this->scopes = $args;
    }

    public function getTotalContestScore($id)
    {
        return $this->model->find($id)->questions->sum('answer.score');
    }

    public function getExamQuestionIds($id)
    {
        return $this->model->find($id)
            ->questions
            ->pluck('id')
            ->toArray();
    }
}
