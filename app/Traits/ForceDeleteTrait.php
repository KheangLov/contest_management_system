<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ForceDeleteTrait
{
    public function btnForceRestoreDelete()
    {
        $user = backpack_user();
        $delete = '';
        $entityName = $this->entityName ? $this->entityName : '';
        $cmCaseEtName = Str::studly($entityName);
        $permissionRestore = 'can' . $cmCaseEtName . 'Restore';
        $permissionFDelete = 'can' . $cmCaseEtName . 'ForceDelete';

        if ($this->deleted_at && $user->{$permissionRestore}()) {
            $delete .= view('partials.btn_force_delete', [
                'url' => route($entityName . '.restore', $this->id),
                'props' => ['button', 'restore_delete'],
            ]);
        }

        if ($user->{$permissionFDelete}()) {
            $delete .= view('partials.btn_force_delete', [
                'url' => route($entityName . '.destroy', $this->id),
                'props' => ['button', 'force_delete'],
            ]);
        }

        return $delete;
    }
}
