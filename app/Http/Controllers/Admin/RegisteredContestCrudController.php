<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RegisteredContest;
use App\Traits\SetPermissionTrait;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ContestRepository;
use App\Repositories\StudentRepository;
use App\Traits\ForceDeleteActionsTrait;
use App\Http\Requests\RegisteredContestRequest;
use App\Repositories\RegisteredContestRepository;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RegisteredContestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RegisteredContestCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use SetPermissionTrait;
    use ForceDeleteActionsTrait;

    protected $studentRepository;
    protected $userRepository;
    protected $registeredContestRepository;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(RegisteredContest::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/registered_contest');
        CRUD::setEntityNameStrings(trans('custom.registered_contest'), trans('custom.registered_contests'));
        $this->setPermission();
        $this->studentRepository = resolve(StudentRepository::class);
        $this->userRepository = resolve(UserRepository::class);
        $this->registeredContestRepository = resolve(RegisteredContestRepository::class);
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
                'name' => 'ContestTitle',
                'type'      => 'text',
                'label' => trans('custom.contest'),
            ],
            [
                'name' => 'duration',
                'type' => 'number',
                'label' => trans('custom.duration'),
            ],
            [
                'name' => 'start_date',
                'type'      => 'date',
                'label' => trans('custom.date'),
            ],
            // [
            //     'name' => 'end_date',
            //     'type'      => 'datetime',
            //     'label' => trans('custom.end_date'),
            // ],
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
        CRUD::setValidation(RegisteredContestRequest::class);
        $colMd6 = ['class' => 'form-group col-md-6'];
        $contestId = request()->contest_id ?? '';
        $contest = '';
        if ($contestId) {
            $contest = resolve(ContestRepository::class)->getById($contestId);
        }

        $this->crud->addFields([
            // [
            //     'name'  => 'start_date',
            //     'label' => trans('custom.start_date'),
            //     'type'  => 'datetime_picker',
            //     'datetime_picker_options' => [
            //         'format' => 'DD/MM/YYYY HH:mm',
            //     ],
            //     'default' => Carbon::now()->toDateString(),
            //     'wrapper' =>  $colMd6
            // ],
            // [
            //     'name'  => 'time',
            //     'label' => trans('custom.time'),
            //     'type'  => 'time',
            //     'wrapper' =>  $colMd6
            // ],
            // [
            //     'name'  => 'end_date',
            //     'label' => trans('custom.end_date'),
            //     'type'  => 'datetime_picker',
            //     'datetime_picker_options' => [
            //         'format' => 'DD/MM/YYYY HH:mm',
            //     ],
            //     'wrapper' =>  $colMd6
            // ],
            // [
            //     'name'  => 'duration',
            //     'label' => trans('custom.duration'),
            //     'type'  => 'number',
            //     'wrapper' =>  $colMd6,
            //     'default' => $contest && $contest->duration ? $contest->duration : ''
            // ],
            [   // 1-n relationship
                'label'       => trans('custom.contests'), // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'contest_id', // the column that contains the ID of that connected entity
                'entity'      => 'contest', // the method that defines the relationship in your Model
                'attribute'   => 'title', // foreign key attribute that is shown to user
                'data_source' => route('web-ajax-call', [
                    'table' => 'contests',
                ]), // url to controller search function (with /{id} should return model)
                'minimum_input_length'    => -1, // minimum characters to type before querying results
                'placeholder' => '-',
                'wrapper' =>  $colMd6,
                'default' => $contest && $contest->id ? $contest->id : ''
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

    public function store()
    {
        $user = backpack_user();
        $userId = $user->id;
        $userIds = [$userId];
        if ($user->isSchoolRole()) {
            $students = $this->studentRepository->getStudentByUser($userId);
            $this->userRepository->createUsersFromStudent($students);
            $userIds = $this->userRepository->getUserByCreatedBy($userId)->pluck('id')->toArray();
        }

        foreach ($userIds as $id) {
            if ($this->registeredContestRepository->checkIfUserAlreadyRegContest(request()->contest_id, $id)) {
                continue;
            }
            request()->request->add(['user_id' => $id]);
            $this->crud->addField(['type' => 'hidden', 'name' => 'user_id']);
            $res = $this->traitStore();
        }

        if (request()->has('register_from_frontend') && request()->register_from_frontend) {
            return redirect()->back();
        }
        return $res;
    }

    public function update()
    {
        return $this->traitUpdate();
    }
}
