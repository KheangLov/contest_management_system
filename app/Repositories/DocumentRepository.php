<?php

namespace App\Repositories;

use App\Models\Document;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class DocumentRepository.
 */
class DocumentRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Document::class;
    }

    public function getModelByType()
    {
        $requestType = 'General';
        if (isset(request()->general)) {
            $requestType = 'General';
        } elseif (isset(request()->technical)) {
            $requestType = 'Technical';
        } elseif (isset(request()->copy_right)) {
            $requestType = 'Copy Right';
        }
        return $this->model->where('status', 'approved')->where('type', $requestType)->get();
    }


}
