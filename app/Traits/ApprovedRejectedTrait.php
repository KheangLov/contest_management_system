<?php

namespace App\Traits;

use Carbon\Carbon;

trait ApprovedRejectedTrait
{
    public function approve($id)
    {
        $entry = $this->crud->model->find($id);
        if ($entry->status === config('const.contest_status.approved') || $entry->status === config('const.contest_status.rejected')) {
            return false;
        }
        return $entry->update([
            'auth_by' => backpack_user()->id,
            'auth_at' => Carbon::now(),
            'status' => config('const.contest_status.approved')
        ]);
    }

    public function reject($id)
    {
        $entry = $this->crud->model->find($id);
        if ($entry->status === config('const.contest_status.rejected')) {
            return false;
        }
        return $entry->update([
            'auth_by' => null,
            'auth_at' => null,
            'status' => config('const.contest_status.rejected')
        ]);
    }
}
