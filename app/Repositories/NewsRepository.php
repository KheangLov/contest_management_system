<?php

namespace App\Repositories;

use App\Models\News;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class NewsRepository.
 */
class NewsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return News::class;
    }
}
