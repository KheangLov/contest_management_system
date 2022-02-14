<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use App\Models\Question;
use App\Traits\SetPermissionTrait;
use App\Http\Requests\QuestionRequest;
use App\Repositories\AnswerRepository;
use App\Traits\ApprovedRejectedTrait;
use App\Traits\ForceDeleteActionsTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class QuestionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QuestionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use ForceDeleteActionsTrait;
    use SetPermissionTrait;
    use ApprovedRejectedTrait {
        approve as traitApprove;
        reject as traitReject;
    }

    protected $answerRepository;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Question::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/question');
        CRUD::setEntityNameStrings(trans('custom.question'), trans('custom.questions'));
        $this->setPermission();
        $this->answerRepository = resolve(AnswerRepository::class);
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
        $this->crud->addButtonFromModelFunction('line', 'btnForceRestoreDelete', 'btnForceRestoreDelete', 'end');
        if ($user->canQuestionReject()) {
            $this->crud->addButtonFromView('line', 'reject', 'reject', 'beginning');
        }
        if ($user->canQuestionApprove()) {
            $this->crud->addButtonFromView('line', 'approve', 'approve', 'beginning');
        }
        $this->crud->addColumns([
            [
                'name'      => 'ImageOrDefault',
                'label'     => trans('custom.image'),
                'type'      => 'image',
                'height' => '35px',
                'width'  => '35px',
            ],
            [
                'label'     => trans('custom.status'),
                'type'      => 'closure',
                'name'      => 'status',
                'function' => function ($entry) {
                    switch ($entry->status) {
                        case config('const.question_status.approved'):
                            $color = 'success';
                            break;
                        case config('const.question_status.waiting'):
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
        CRUD::setValidation(QuestionRequest::class);

        $tabEn = config('const.tab_trans.english') . ',' . trans('custom.langenglish');
        $tabKh = config('const.tab_trans.khmer') . ',' . trans('custom.langkhmer');
        $colMd6 = ['class' => 'form-group col-md-6'];

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
                'name'  => 'image',
                'label' => trans('custom.image'),
                'type'  => 'image',
                'tab' => $tabEn,
                'wrapper' => $colMd6
            ],
            // [   // 1-n relationship
            //     'label'       => "Contests", // Table column heading
            //     'type'        => "select2_from_ajax",
            //     'name'        => 'contest_id', // the column that contains the ID of that connected entity
            //     'entity'      => 'contest', // the method that defines the relationship in your Model
            //     'attribute'   => 'title', // foreign key attribute that is shown to user
            //     'data_source' => route('web-ajax-call', [
            //         'table' => 'contests',
            //     ]), // url to controller search function (with /{id} should return model)
            //     'minimum_input_length'    => -1, // minimum characters to type before querying results
            //     'placeholder' => '-',
            //     'tab' => $tabEn,
            // ],
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
            [
                'name'  => 'status',
                'type'  => 'hidden',
                'value' => 'inactive',
            ],
        ]);

        $this->crud->addField([
            'label'     => trans('custom.answers'),
            'type'      => 'custom.checklist',
            'name'      => 'answers',
            'entity'    => 'answers',
            'scope'     => 'NotLinkedAnswers',
            'attribute' => 'title',
            'model'     => Answer::class,
            'pivot'     => false,
            'dialog_form' => true,
            'class_col' => 'col-sm-12',
            'relate_key' => 'answer',
            'dialog_label' => trans('custom.answer_form_action'),
            'tab' => $tabEn,
            'wrapper' => [
                'data-max-check' => config('settings.checklist_item_limit'),
            ]
            // 'custom_relationship' => [
            //     'label' => trans('custom.is_correct_answer'),
            //     'class_col' => 'col-sm-12',
            //     'name' => 'answer',
            //     'max_check' => 1,
            // ]
        ]);
        $dNone = '';
        $entry = $this->crud->model->find(request()->id);
        $val = [];
        $showLists = [];
        if ($entry) {
            if (!optional($entry->answers)->count() && !$entry->answer_id) {
                $dNone = ' d-none';
            }
            $val[] = $entry->answer_id;
            $showLists = optional($entry->answers)->pluck('id')->toArray();
        }
        $this->crud->addField([
            'label'     => trans('custom.correct_answers'),
            'type'      => 'custom.checklist',
            'name'      => 'answer',
            'entity'    => 'answers',
            'scope'     => 'NotLinkedAnswers',
            'attribute' => 'title',
            'model'     => Answer::class,
            'pivot'     => false,
            'class_col' => 'col-sm-12' . $dNone,
            'tab' => $tabEn,
            'wrapper' => [
                'data-max-check' => config('settings.relation_checklist_item_limit'),
            ],
            'value' => json_encode($val),
            'show_list' => $showLists,
            // 'custom_relationship' => [
            //     'label' => trans('custom.is_correct_answer'),
            //     'class_col' => 'col-sm-12',
            //     'name' => 'answer',
            //     'max_check' => 1,
            // ]
        ]);
        $this->crud->addField([
            'type'      => 'custom.checklist_script',
            'name'      => 'answer_script',
            'tab' => trans('custom.langenglish'),
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
        $this->setupCreateOperation();
        $this->crud->removeFields(['status', 'answers', 'answer', 'answer_script']);
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
                'wrapper' => [
                    'class' => 'col-sm-6'
                ],
                'tab' => $tabEn,
            ]);
        }
        $this->crud->addField([
            'label'     => trans('custom.answers'),
            'type'      => 'custom.checklist',
            'name'      => 'answers',
            'entity'    => 'answers',
            'scope'     => 'NotLinkedAnswers',
            'attribute' => 'title',
            'model'     => Answer::class,
            'pivot'     => false,
            'dialog_form' => true,
            'class_col' => 'col-sm-12',
            'tab' => $tabEn,
            'relate_key' => 'answer',
            'wrapper' => [
                'data-max-check' => config('settings.checklist_item_limit'),
            ]
            // 'custom_relationship' => [
            //     'label' => trans('custom.is_correct_answer'),
            //     'class_col' => 'col-sm-12',
            //     'name' => 'answer',
            //     'max_check' => 1,
            // ]
        ]);
        $dNone = '';
        $entry = $this->crud->model->find(request()->id);
        $val = [];
        $showLists = [];
        if ($entry) {
            if (!optional($entry->answers)->count() && !$entry->answer_id) {
                $dNone = ' d-none';
            }
            $val[] = $entry->answer_id;
            $showLists = optional($entry->answers)->pluck('id')->toArray();
        }
        $this->crud->addField([
            'label'     => trans('custom.correct_answers'),
            'type'      => 'custom.checklist',
            'name'      => 'answer',
            'entity'    => 'answers',
            'scope'     => 'NotLinkedAnswers',
            'attribute' => 'title',
            'model'     => Answer::class,
            'pivot'     => false,
            'class_col' => 'col-sm-12' . $dNone,
            'tab' => $tabEn,
            'wrapper' => [
                'data-max-check' => config('settings.relation_checklist_item_limit'),
            ],
            'value' => json_encode($val),
            'show_list' => $showLists,
            // 'custom_relationship' => [
            //     'label' => trans('custom.is_correct_answer'),
            //     'class_col' => 'col-sm-12',
            //     'name' => 'answer',
            //     'max_check' => 1,
            // ]
        ]);
        $this->crud->addField([
            'type'      => 'custom.checklist_script',
            'name'      => 'answer_script',
            'tab' => trans('custom.langenglish'),
        ]);
    }

    public function store()
    {
        if (request()->has('answer') && count(json_decode(request()->answer))) {
            request()->request->add(['answer_id' => json_decode(request()->answer)[0]]);
            $this->crud->addField(['type' => 'hidden', 'name' => 'answer_id']);
        }
        $res = $this->traitStore();
        $newEntry = $this->crud->entry;
        $this->answerRepository->linkToQuestion(json_decode(request()->answers), $newEntry->id);
        return $res;
    }

    public function update()
    {
        if (request()->has('answer') && count(json_decode(request()->answer))) {
            request()->request->add(['answer_id' => json_decode(request()->answer)[0]]);
            $this->crud->addField(['type' => 'hidden', 'name' => 'answer_id']);
        }
        $res = $this->traitUpdate();
        $this->answerRepository->linkToQuestion(json_decode(request()->answers), request()->id);
        return $res;

    }

    public function approve($id)
    {
        $approved = $this->traitApprove($id);
        if ($approved) {
            $this->answerRepository->approveFromQuestion($id);
        }
        return $approved;
    }

    public function reject($id)
    {
        $rejected = $this->traitReject($id);
        if ($rejected) {
            $this->answerRepository->rejectFromQuestion($id);
        }
        return $rejected;
    }
}
