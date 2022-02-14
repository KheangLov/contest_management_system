<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class SettingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }

    public function setup()
    {
        CRUD::setModel(Setting::class);
        CRUD::setEntityNameStrings(trans('backpack::settings.setting_singular'), trans('backpack::settings.setting_plural'));
        CRUD::setRoute(backpack_url(config('backpack.settings.route')));
    }

    public function setupListOperation()
    {
        // only show settings which are marked as active
        CRUD::addClause('where', 'active', 1);

        // columns to show in the table view
        CRUD::setColumns([
            [
                'name'  => 'name',
                'label' => trans('backpack::settings.name'),
            ],
            [
                'name'  => 'key',
                'label' => trans('custom.key'),
            ],
            [
                'name'  => 'value',
                'label' => trans('backpack::settings.value'),
            ],
            [
                'name'  => 'description',
                'label' => trans('backpack::settings.description'),
            ],
        ]);
    }

    public function setupUpdateOperation()
    {
        CRUD::addField([
            'name'       => 'key',
            'label'      => trans('custom.key'),
            'type'       => 'text',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);

        CRUD::addField([
            'name'       => 'name',
            'label'      => trans('backpack::settings.name'),
            'type'       => 'text',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);

        CRUD::addField([
            'name'       => 'description',
            'label'      => trans('backpack::settings.description'),
            'type'       => 'textarea',
        ]);

        CRUD::addField(json_decode(CRUD::getCurrentEntry()->field, true));
    }

    public function update()
    {
        return $this->traitUpdate();
    }
}
