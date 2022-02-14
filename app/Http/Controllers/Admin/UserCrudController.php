<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Users\UserStoreCrudRequest as StoreRequest;
use App\Http\Requests\Users\UserUpdateCrudRequest as UpdateRequest;
use App\Traits\ForceDeleteActionsTrait;
use App\Traits\SetPermissionTrait;
use Illuminate\Support\Facades\Hash;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation { bulkDelete as traitBulkDelete; }
    use ForceDeleteActionsTrait;
    use SetPermissionTrait;

    public function setup()
    {
        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(backpack_url('user'));
        $this->setPermission();
    }

    public function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->crud->addColumns([
            [
                'name'      => 'profile', // The db column name
                'label'     => trans('custom.profile'), // Table column heading
                'type'      => 'image',
                'height' => '300px',
                'width'  => '300px',
            ],
            [
                'name'     => 'status',
                'label'    => trans('custom.status'),
                'type'     => 'closure',
                'function' => function ($entry) {
                    $color = $entry->StatusUC == strtoupper(config('const.user_status.active')) ? 'success' : 'danger';
                    return "<span class=\"badge py-2 badge-$color\">$entry->StatusUC</span>";
                }
            ],
            [
                'name' => 'first_name',
                'label' => trans('custom.first_name'),
                'type' => 'text',
            ],
            [
                'name' => 'last_name',
                'label' => trans('custom.last_name'),
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type' => 'text',
            ],
            [
                'name' => 'phone',
                'label' => trans('custom.phone'),
                'type' => 'text',
            ],
            [
                'name' => 'GenderCL',
                'label' => trans('custom.gender'),
                'type' => 'text',
            ],
            [
                'name' => 'dob',
                'label' => trans('custom.date_of_birth'),
                'type' => 'date',
            ],
            [
                'name' => 'address',
                'label' => trans('custom.address'),
                'type' => 'text',
            ],
            [
                'name' => 'school',
                'label' => trans('custom.school'),
                'type' => 'text',
            ],
            [
                'name' => 'CreatedByFullName',
                'label' => trans('custom.created_by'),
                'type' => 'closure',
                'function' => function ($entry) {
                    $url = backpack_url("user/$entry->created_by/show");
                    return "<a href=\"$url\">$entry->CreatedByFullName</a>";
                }
            ],
            [
                'name' => 'created_at',
                'label' => trans('custom.created_at'),
                'type' => 'datetime',
            ],
            [
                'name' => 'UpdatedByFullName',
                'label' => trans('custom.updated_by'),
                'type' => 'closure',
                'function' => function ($entry) {
                    $url = backpack_url("user/$entry->updated_by/show");
                    return "<a href=\"$url\">$entry->UpdatedByFullName</a>";
                }
            ],
            [
                'name' => 'updated_at',
                'label' => trans('custom.updated_at'),
                'type' => 'datetime',
            ],
        ]);
        $this->crud->removeAllButtons();
    }

    public function setupListOperation()
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
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [
                'name'     => 'status',
                'label'    => trans('custom.status'),
                'type'     => 'closure',
                'function' => function ($entry) {
                    $color = $entry->StatusUC == strtoupper(config('const.user_status.active')) ? 'success' : 'danger';
                    return "<span class=\"badge py-2 badge-$color\">$entry->StatusUC</span>";
                }
            ],
            [
                'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'roles', // the method that defines the relationship in your Model
                'entity'    => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.role'), // foreign key model
            ],
            [
                'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'permissions', // the method that defines the relationship in your Model
                'entity'    => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.permission'), // foreign key model
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

        // Role Filter
        $this->crud->addFilter(
            [
                'name'  => 'role',
                'type'  => 'dropdown',
                'label' => trans('backpack::permissionmanager.role'),
            ],
            config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
                    $query->where('role_id', '=', $value);
                });
            }
        );

        // Extra Permission Filter
        $this->crud->addFilter(
            [
                'name'  => 'permissions',
                'type'  => 'select2',
                'label' => trans('backpack::permissionmanager.extra_permissions'),
            ],
            config('permission.models.permission')::all()->pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'permissions', function ($query) use ($value) {
                    $query->where('permission_id', '=', $value);
                });
            }
        );

        $this->crud->addFilter(
            ['type' => 'simple', 'name' => 'trashed', 'label' => trans('custom.trashed')],
            false,
            function () {
                $this->crud->query = $this->crud->query->onlyTrashed();
            }
        );
    }

    public function setupCreateOperation()
    {
        $this->addUserFields();
        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->addUserFields();
        $this->crud->setValidation(UpdateRequest::class);
        $this->crud->removeFields(['name']);
        $this->crud->addField([
            'name'  => 'name',
            'label' => trans('custom.name'),
            'type'  => 'text',
        ])->afterField('last_name');
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitStore();
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitUpdate();
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }

    protected function addUserFields()
    {
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
                'name'        => 'gender',
                'label'       => trans('custom.gender'),
                'type'        => 'select2_from_array',
                'options'     => ['male' => trans('custom.male'), 'female' => trans('custom.female')],
                'allows_null' => false,
                'default'     => 'male',
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
                'name'  => 'school',
                'label' => trans('custom.school'),
                'type'  => 'text',
                'wrapper' => $colMd6,
            ],
            [
                'name'        => 'status',
                'label'       => trans('custom.status'),
                'type'        => 'select2_from_array',
                'options'     => ['active' => trans('custom.active'), 'inactive' => trans('custom.inactive')],
                'allows_null' => false,
                'default'     => 'active',
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'address',
                'label' => trans('custom.address'),
                'type'  => 'text',
            ],
            [
                'name'  => 'phone',
                'label' => trans('custom.phone'),
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
                'name'  => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type'  => 'password',
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'name',
                'type'  => 'hidden',
            ],
            [
                'label' => trans('custom.profile'),
                'name' => "profile",
                'type' => 'image',
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            ],
            [
                // two interconnected entities
                'label'             => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type'              => 'checklist_dependency',
                'name'              => ['roles', 'permissions'],
                'subfields'         => [
                    'primary' => [
                        'label'            => trans('backpack::permissionmanager.roles'),
                        'name'             => 'roles', // the method that defines the relationship in your Model
                        'entity'           => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute'        => 'name', // foreign key attribute that is shown to user
                        'model'            => config('permission.models.role'), // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'name', // foreign key attribute that is shown to user
                        'model'          => config('permission.models.permission'), // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],
        ]);
    }

    public function bulkDelete()
    {
        $this->crud->hasAccessOrFail('bulkDelete');

        $entries = request()->input('entries', []);
        $deletedEntries = [];

        foreach ($entries as $id) {
            if (backpack_user()->id == $id) {
                continue;
            }

            if ($entry = $this->crud->model->find($id)) {
                $deletedEntries[] = $entry->delete();
            }
        }

        return $deletedEntries;
    }
}
