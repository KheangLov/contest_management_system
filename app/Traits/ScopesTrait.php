<?php

namespace App\Traits;

trait ScopesTrait
{
    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeStatusApproved($query)
    {
        return $query->where('status', config('const.answer_status.approved'));
    }
}
