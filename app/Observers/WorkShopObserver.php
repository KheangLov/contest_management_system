<?php

namespace App\Observers;

use App\Models\WorkShop;

class WorkShopObserver
{
    /**
     * Handle the WorkShop "created" event.
     *
     * @param  \App\Models\WorkShop  $workShop
     * @return void
     */
    public function creating(WorkShop $workShop)
    {
        $workShop->status = 'waiting';
    }

    public function updating(WorkShop $workShop)
    {
        if ($workShop->getOriginal('status') == config('const.answer_status.rejected')) {
            $workShop->status = 'waiting';
        }
    }

    /**
     * Handle the WorkShop "created" event.
     *
     * @param  \App\Models\WorkShop  $workShop
     * @return void
     */
    public function created(WorkShop $workShop)
    {
        //
    }

    /**
     * Handle the WorkShop "updated" event.
     *
     * @param  \App\Models\WorkShop  $workShop
     * @return void
     */
    public function updated(WorkShop $workShop)
    {
        //
    }

    /**
     * Handle the WorkShop "deleted" event.
     *
     * @param  \App\Models\WorkShop  $workShop
     * @return void
     */
    public function deleted(WorkShop $workShop)
    {
        //
    }

    /**
     * Handle the WorkShop "restored" event.
     *
     * @param  \App\Models\WorkShop  $workShop
     * @return void
     */
    public function restored(WorkShop $workShop)
    {
        //
    }

    /**
     * Handle the WorkShop "force deleted" event.
     *
     * @param  \App\Models\WorkShop  $workShop
     * @return void
     */
    public function forceDeleted(WorkShop $workShop)
    {
        //
    }
}
