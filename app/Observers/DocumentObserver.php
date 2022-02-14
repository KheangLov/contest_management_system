<?php

namespace App\Observers;

use App\Models\Document;

class DocumentObserver
{
    /**
     * Handle the Contest "created" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function creating(Document $document)
    {
        $document->status = 'waiting';
    }

    public function updating(Document $document)
    {
        if ($document->getOriginal('status') == config('const.answer_status.rejected')) {
            $document->status = 'waiting';
        }
    }

    /**
     * Handle the Document "created" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function created(Document $document)
    {
        //
    }

    /**
     * Handle the Document "updated" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function updated(Document $document)
    {
        //
    }

    /**
     * Handle the Document "deleted" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function deleted(Document $document)
    {
        //
    }

    /**
     * Handle the Document "restored" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function restored(Document $document)
    {
        //
    }

    /**
     * Handle the Document "force deleted" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function forceDeleted(Document $document)
    {
        //
    }
}
