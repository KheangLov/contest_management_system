<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\StudentRepository;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function setScopesAttr($args = [])
    {
        $this->scopes = $args;
    }

    public function createUsersFromStudent($students)
    {
        request()->user_from_student = true;
        $cc = $this;
        $students->each(function ($v) use ($cc) {
            $name = trim($v->first_name) . trim($v->last_name);
            if ($cc->model->CheckNameExist($name)->count()) {
                $name .= $cc->model->CheckNameExist($name)->count();
            }
            $entry = $cc->model->where('email', $v->email)->first();
            $v->login_token = Hash::make($v->email . $v->password);
            $v->name = $name;
            $v->status = 'active';
            $v->password = Hash::make(str_replace('-', '', $v->dob));
            $data = $v->only([
                'address',
                'dob',
                'email',
                'first_name',
                'gender',
                'last_name',
                'phone',
                'profile',
                'school',
                'status',
                'password',
                'login_token',
                'name'
            ]);
            if ($entry) {
                $entry->update($data);
            } else {
                $entry = $cc->model->create($data);
            }
            $entry->roles()->syncWithoutDetaching([3]);
            resolve(StudentRepository::class)->updateStudentUserId($v->id, $entry->id);
        });
        // $dataStudents = $students->toArray();
        // $this->model->upsert($dataStudents, [array_keys($dataStudents[0])], ['email']);
        // $users = $this->model
        //     ->whereIn('name', $dataStudents->pluck('name'))
        //     ->get();

        // $users->each(function ($user) {
        //     $user->roles()->syncWithoutDetaching([3]);
        //     $user->update([
        //         'login_token' => Hash::make($user->email . $user->password)
        //     ]);
        //     $user->student->update([

        //     ]);
        // });

        // return true;
    }

    public function getUserByCreatedBy($id)
    {
        return $this->model->where('created_by', $id)->get();
    }

    public function getUserRegContests()
    {
        return backpack_user()->userRegContests;
    }

    public function findUserByToken($token)
    {
        $entry = $this->model->where('login_token', $token)->first();

        if (!$entry || !$entry->login_token) {
            return false;
        }

        return $entry;
    }
}
