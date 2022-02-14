<?php

namespace App\Repositories;

use App\Models\WorkShop;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class WorkshopRepository.
 */
class WorkshopRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return WorkShop::class;
    }


    public function setScopesAttr($args = [])
    {
        $this->scopes = $args;
    }
}
