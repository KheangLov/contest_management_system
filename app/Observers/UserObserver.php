<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        $user->update([
            'created_by' => optional(backpack_user())->id,
        ]);
    }
}
