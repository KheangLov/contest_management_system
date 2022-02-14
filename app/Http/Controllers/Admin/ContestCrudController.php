<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Level;
use App\Models\Contest;
use App\Models\Question;
use App\Traits\SetPermissionTrait;
use App\Http\Requests\ContestRequest;
use App\Repositories\LevelRepository;
use App\Traits\ApprovedRejectedTrait;
use App\Traits\ForceDeleteActionsTrait;
use App\Repositories\QuestionRepository;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ContestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContestCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use ForceDeleteActionsTrait;
    use SetPermissionTrait;
    use ApprovedRejectedTrait;

    protected $questionRepository;
    protected $levelRepository;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Contest::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contest');
        CRUD::setEntityNameStrings(trans('custom.contest'), trans('custom.contests'));
        $this->crud->setShowView('backpack.contests.show');
        $this->setPermission();
        $this->questionRepository = resolve(QuestionRepository::class);
        $this->levelRepository = resolve(LevelRepository::class);
    }

    protected function setupShowOperation()
    {
        $this->crud->removeButtons(['approve', 'clone', 'delete']);
        $this->crud->addButtonFromView('line', 'register_contest', 'register_contest', 'beginning');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $user = backpack_user();

        if ($user->canContestUpdate()) {
            $this->crud->addButtonFromModelFunction('line', 'match_question', 'matchQuestion', 'beginning');
        }
        $this->crud->addButtonFromModelFunction('line', 'btnForceRestoreDelete', 'btnForceRestoreDelete', 'end');
        if ($user->canContestReject()) {
            $this->crud->addButtonFromView('line', 'reject', 'reject', 'beginning');
        }
        if ($user->canContestApprove()) {
            $this->crud->addButtonFromView('line', 'approve', 'approve', 'beginning');
        }

        $this->crud->addColumns([
            [
                'label'     => trans('custom.level'),
                'type'      => 'closure',
                'name'      => 'level',
                'function' => function ($entry) {
                    $level = optional($entry->level)->TitleLang;
                    return "<span class=\"badge badge-primary py-2\">$level</span>";
                }
            ],
            // [
            //     // any type of relationship
            //     'name'         => 'level', // name of relationship method in the model
            //     'type'         => 'relationship',
            //     'label'        => trans('custom.level'), // Table column heading
            //     // OPTIONAL
            //     // 'entity'    => 'tags', // the method that defines the relationship in your Model
            //     // 'attribute' => 'name', // foreign key attribute that is shown to user
            //     // 'model'     => App\Models\Category::class, // foreign key model
            // ],
            [
                'label'     => trans('custom.status'),
                'type'      => 'closure',
                'name'      => 'status',
                'function' => function ($entry) {
                    switch ($entry->status) {
                        case config('const.contest_status.approved'):
                            $color = 'success';
                            break;
                        case config('const.contest_status.waiting'):
                            $color = 'warning';
                            break;
                        default:
                            $color = 'danger';
                            break;
                    }
                    $status = strtoupper($entry->status);
                    return "<span class=\"badge badge-$color py-2\">$status</span>";
                }
            ],
            // [
            //     'label'     => trans('custom.is_active'),
            //     'type'      => 'check',
            //     'name'      => 'is_active',
            // ],
            [
                'name'  => 'TitleLang',
                'label' => trans('custom.title'),
                'type'  => 'text',
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('title', 'like', '%'.$searchTerm.'%')
                        ->orWhere('title_kh', 'like', '%'.$searchTerm.'%');
                }
            ],
            [
                'name'      => 'ImageOrDefault',
                'label'     => trans('custom.image'),
                'type'      => 'image',
                'height' => '35px',
                'width'  => '35px',
            ],
            [
                'name'  => 'DescriptionLang',
                'label' => trans('custom.description'),
                'type'  => 'markdown',
            ],
            [
                'label'     => trans('custom.auth_by'),
                'type'      => 'closure',
                'name'      => 'AuthByFullName',
                'function' => function ($entry) {
                    $url = backpack_url("user/$entry->auth_by/show");
                    return "<a href=\"$url\">$entry->AuthByFullName</a>";
                }
            ],
            [
                'label'     => trans('custom.auth_at'),
                'type'      => 'datetime',
                'name'      => 'auth_at',
            ],
            [
                'label'     => trans('custom.start_at'),
                'type'      => 'datetime',
                'name'      => 'start_at',
            ],
            [
                'label'     => trans('custom.end_at'),
                'type'      => 'datetime',
                'name'      => 'end_at',
            ],
            [
                'label'     => trans('custom.created_at'),
                'type'      => 'datetime',
                'name'      => 'created_at',
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

        // $this->crud->addFilter(
        //     ['type' => 'simple', 'name' => 'is_active', 'label' => trans('custom.is_active')],
        //     false,
        //     function () {
        //         $this->crud->query->IsActive()->get();
        //     }
        // );

        $this->crud->addFilter(
            [
                'name'  => 'level',
                'type'  => 'dropdown',
                'label' => trans('custom.level'),
            ],
            $this->levelRepository->all()->pluck('TitleLang', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'level', function ($query) use ($value) {
                    $query->where('level_id', '=', $value);
                });
            }
        );

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
        CRUD::setValidation(ContestRequest::class);

        $tabEn = config('const.tab_trans.english') . ',' . trans('custom.langenglish');
        $tabKh = config('const.tab_trans.khmer') . ',' . trans('custom.langkhmer');
        $colMd6 = ['class' => 'form-group col-md-6'];
        $colMd12 = ['class' => 'form-group col-md-12'];
        $entry = $this->crud->model->find(request()->id);

        // dd($entry->EndAtDate);
        $this->crud->addFields([
            [
                'name'  => 'title',
                'label' => trans('custom.title'),
                'type'  => 'text',
                'tab' => $tabEn
            ],
            [
                'name'  => 'description',
                'label' => trans('custom.description'),
                'type'  => 'tinymce',
                'tab' => $tabEn
            ],
            // [
            //     'name'  => 'is_active',
            //     'label' => "Is Active",
            //     'type'  => 'checkbox',
            //     'tab' => $tabEn,
            // ],
            [
                'name'  => 'start_at',
                'label' => trans('custom.start_date'),
                'type'  => 'date_picker',
                'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format' => 'yyyy-mm-dd',
                ],
                'default' => Carbon::now()->toDateString(),
                'value' => $entry && $entry->StartAtDate ? $entry->StartAtDate : Carbon::now()->toDateString(),
                'wrapper' =>  $colMd6,
                'tab' => $tabEn,
            ],
            [
                'name'  => 'end_at',
                'label' => trans('custom.end_date'),
                'type'  => 'date_picker',
                'date_picker_options' => [
                    'format' => 'yyyy-mm-dd',
                ],
                'default' => Carbon::now()->toDateString(),
                'value' => $entry && $entry->EndAtDate ? $entry->EndAtDate : Carbon::now()->toDateString(),
                'wrapper' =>  $colMd6,
                'tab' => $tabEn,
            ],
            [
                'type' => 'relationship',
                'name' => 'level',
                'label' => trans('custom.level'),
                'tab' => $tabEn,
                'inline_create' => true,
                'ajax'          => true,
                'data_source' => backpack_url("level/fetch/level"),
                'minimum_input_length' => -1,
                'wrapper' => $colMd6,
                // 'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                // 'entity' => 'category', // the method that defines the relationship in your Model
                // 'model' => "App\Models\Category", // foreign key Eloquent model
                // 'placeholder' => "Select a category", // placeholder for the select2 input
            ],
            [
                'type' => 'number',
                'name' => 'duration',
                'label' => trans('custom.duration'),
                'tab' => $tabEn,
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'image',
                'label' => trans('custom.image'),
                'type'  => 'image',
                'tab' => $tabEn,
                'wrapper' => $colMd12,
            ],
            [
                'name'  => 'title_kh',
                'label' => trans('custom.title'),
                'type'  => 'text',
                'tab' => $tabKh
            ],
            [
                'name'  => 'description_kh',
                'label' => trans('custom.description'),
                'type'  => 'tinymce',
                'tab' => $tabKh
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
        $tabEn = config('const.tab_trans.english') . ',' . trans('custom.langenglish');
        $colMd6 = ['class' => 'form-group col-md-6'];
        $this->setupCreateOperation();
        $this->crud->removeFields(['status', 'level']);

        if (backpack_user()->isAdminRole()) {
            $this->crud->addField([
                'name'        => 'status',
                'label'       => trans('custom.status'),
                'type'        => 'select2_from_array',
                'options'     => [
                    config('const.contest_status.waiting') => trans('custom.waiting'),
                    config('const.contest_status.approved') => trans('custom.approved'),
                    config('const.contest_status.rejected') => trans('custom.rejected'),
                ],
                'allows_null' => false,
                'default'     => 'active',
                'wrapper' => $colMd6,
                'tab' => $tabEn,
            ]);
        }
        $this->crud->addFields([
            // [
            //     'name'      => 'col_hide',
            //     'type'      => 'hidden',
            //     'wrapper' => $colMd6,
            //     'tab' => $tabEn,
            // ],
            [
                'type' => 'relationship',
                'name' => 'level',
                'label' => "Level",
                'tab' => $tabEn,
                'wrapper' => $colMd6,
                'inline_create' => true,
                'ajax'          => true,
                'data_source' => backpack_url("level/fetch/level"),
                'minimum_input_length' => -1
                // 'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                // 'entity' => 'category', // the method that defines the relationship in your Model
                // 'model' => "App\Models\Category", // foreign key Eloquent model
                // 'placeholder' => "Select a category", // placeholder for the select2 input
            ],
        ]);

        if (request()->has('match_question') && request()->match_question) {
            $this->crud->removeAllFields();
            $this->crud->addFields([
                [
                    'label'     => trans('custom.questions'),
                    'type'      => 'custom.checklist',
                    'name'      => 'questions',
                    'entity'    => 'questions',
                    'scope'     => 'NotLinkedQuestions',
                    'attribute' => 'title',
                    'model'     => Question::class,
                    'pivot'     => false,
                    'class_col' => 'col-sm-12',
                    'collapse_relation' => 'answers',
                ],
                [
                    'type'      => 'hidden',
                    'name'      => 'ignore_validation',
                    'value'      => 'true',
                ]
            ]);
        }

    }

    // public function create()
    // {
    //     $this->questionRepository->linkToContest(json_decode(request()->questions), request()->id);
    //     return $this->traitCreate();
    // }

    public function update()
    {
        if (request()->has('questions') && request()->questions) {
            $this->questionRepository->linkToContest(json_decode(request()->questions), request()->id);
        }
        return $this->traitUpdate();
    }
}
