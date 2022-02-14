<?php

namespace App\Observers;

use App\Models\Contest;

class ContestObserver
{
    /**
     * Handle the Contest "created" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function creating(Contest $contest)
    {
        $contest->status = 'waiting';
    }

    public function updating(Contest $contest)
    {
        if ($contest->getOriginal('status') == config('const.answer_status.rejected')) {
            $contest->status = 'waiting';
        }
    }

    /**
     * Handle the Contest "created" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function created(Contest $contest)
    {
        //
    }

    /**
     * Handle the Contest "updated" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function updated(Contest $contest)
    {
        //
    }

    /**
     * Handle the Contest "deleted" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function deleted(Contest $contest)
    {
        //
    }

    /**
     * Handle the Contest "restored" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function restored(Contest $contest)
    {
        //
    }

    /**
     * Handle the Contest "force deleted" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function forceDeleted(Contest $contest)
    {
        //
    }
}
