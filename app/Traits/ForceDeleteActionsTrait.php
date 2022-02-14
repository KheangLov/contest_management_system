<?php

namespace App\Traits;

use Throwable;

trait ForceDeleteActionsTrait
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as taitDestroy; }

    public function restore($id)
    {
        $entry = $this->crud->query->withTrashed()->findOrFail($id);
        if ($entry->deleted_by) {
            $entry->deleted_by = null;
            $entry->save();
        }
        return (string)$entry->restore();
    }

    public function destroy($id)
    {
        try {
            $this->crud->hasAccessOrFail('delete');
            $this->crud->setOperation('delete');
            $entry = $this->crud->query->withTrashed()->findOrFail($id);

            if (request()->force_delete == 1) {
                $isDeleted = $entry->forceDelete();
            } else {
                $isDeleted = $entry->delete();
                if ($entry->hasAttribute('deleted_by')) {
                    $entry->deleted_by = backpack_user()->id;
                    $entry->save();
                }
            }

            if (!$isDeleted) {
                return response()->json(request()->event_error_msg, 422);
            }

            return (string)$isDeleted;
        } catch (Throwable $th) {
            return response()->json($th, 422);
        }
    }
}
