<?php

namespace App\Repositories;

use App\Models\Level;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class LevelRepository.
 */
class LevelRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Level::class;
    }

    public function getLevelHasContests()
    {
        return $this->model->whereHas('contests')->get();
    }
}
