<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Http\Requests\StudentRequest;
use App\Traits\ForceDeleteActionsTrait;
use App\Traits\SetPermissionTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ForceDeleteActionsTrait;
    use SetPermissionTrait;
    // use ApprovedRejectedTrait;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Student::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student');
        CRUD::setEntityNameStrings(trans('custom.student'), trans('custom.students'));
        $this->setPermission();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addButtonFromModelFunction('line', 'btnForceRestoreDelete', 'btnForceRestoreDelete', 'end');
        $this->crud->addColumns([
            [
                'name'      => 'ProfileOrDefault',
                'label'     => trans('custom.profile'),
                'type'      => 'image',
                'height' => '35px',
                'width'  => '35px',
            ],
            [
                'name'  => 'FullName',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
                'orderable'  => true,
                'orderLogic' => function ($query, $column, $columnDirection) {
                    return $query->orderBy('first_name', $columnDirection);
                }
            ],
            [
                'name'  => 'HasUser',
                'label' => trans('custom.registered'),
                'type' => 'check',
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [
                'label'     => trans('custom.created_by'),
                'type'      => 'closure',
                'name'      => 'CreatedByFullName',
                'function' => function ($entry) {
                    $url = backpack_url("user/$entry->created_by/show");
                    return "<a href=\"$url\">$entry->CreatedByFullName</a>";
                }
            ],
            [
                'label'     => trans('custom.created_at'),
                'type'      => 'datetime',
                'name'      => 'created_at',
            ],
            [
                'label'     => trans('custom.updated_by'),
                'type'      => 'closure',
                'name'      => 'UpdatedByFullName',
                'function' => function ($entry) {
                    $url = backpack_url("user/$entry->updated_by/show");
                    return "<a href=\"$url\">$entry->UpdatedByFullName</a>";
                }
            ],
            [
                'label'     => trans('custom.updated_at'),
                'type'      => 'datetime',
                'name'      => 'updated_at',
            ],
            [
                'label'     => trans('custom.deleted_by'),
                'type'      => 'closure',
                'name'      => 'DeletedByFullName',
                'function' => function ($entry) {
                    $url = backpack_url("user/$entry->deleted_by/show");
                    return "<a href=\"$url\">$entry->DeletedByFullName</a>";
                }
            ],
            [
                'label'     => trans('custom.deleted_at'),
                'type'      => 'datetime',
                'name'      => 'deleted_at',
            ],
        ]);

        $this->crud->addFilter(
            ['type' => 'simple', 'name' => 'trashed', 'label' => trans('custom.trashed')],
            false,
            function () {
                $this->crud->query->onlyTrashed();
            }
        );
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(StudentRequest::class);

        $colMd6 = ['class' => 'form-group col-md-6'];
        $this->crud->addFields([
            [
                'name'  => 'first_name',
                'label' => trans('custom.first_name'),
                'type'  => 'text',
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'last_name',
                'label' => trans('custom.last_name'),
                'type'  => 'text',
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'dob',
                'type'  => 'date_picker',
                'label' => trans('custom.date_of_birth'),
                'date_picker_options' => [
                   'format'   => 'yyyy-mm-dd',
                ],
                'wrapper' => $colMd6,
            ],
            [
                'name'        => 'gender',
                'label'       => trans('custom.gender'),
                'type'        => 'select2_from_array',
                'options'     => ['male' => trans('custom.male'), 'female' => trans('custom.female')],
                'allows_null' => false,
                'default'     => 'male',
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'school',
                'label' => trans('custom.school'),
                'type'  => 'text',
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'address',
                'label' => trans('custom.address'),
                'type'  => 'text',
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'phone',
                'label' => trans('custom.phone'),
                'type'  => 'text',
                'wrapper' => $colMd6,
            ],
            [
                'label' => trans('custom.profile'),
                'name' => "profile",
                'type' => 'image',
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            ],
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
