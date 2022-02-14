<?php

namespace App\Repositories;

use App\Models\Student;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class StudentRepository.
 */
class StudentRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Student::class;
    }

    public function getStudentByUser($suId)
    {
        $query = $this->model->where('created_by', $suId);
        if (!$query->count()) {
            return false;
        }
        return $query->get();
    }

    public function updateStudentUserId($id, $userId)
    {
        return $this->model->find($id)->update(['user_id' => $userId]);
    }
}
