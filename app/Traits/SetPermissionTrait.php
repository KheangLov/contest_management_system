<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait SetPermissionTrait
{
    public function setPermission()
    {
        $entityName = Str::studly($this->crud->model->entityName);
        $user = backpack_user();
        $actions = [
            'list',
            'create',
            'update',
            'show',
            'delete',
            'clone',
            'bulkClone',
            'bulkDelete',
        ];

        $this->crud->denyAccess($actions);

        foreach ($actions as $action) {
            if ($action == 'clone' || $action == 'bulkClone') {
                $action = 'create';
            }
            if ($action == 'bulkDelete') {
                $action = 'delete';
            }

            if ($user->{'can' . $entityName . ucfirst($action)}()) {
                $this->crud->allowAccess($action);
                if ($action == 'create') {
                    $this->crud->allowAccess('clone');
                    $this->crud->allowAccess('bulkClone');
                }
                if ($action == 'delete') {
                    $this->crud->allowAccess('bulkDelete');
                }
            }
        }
    }
}
