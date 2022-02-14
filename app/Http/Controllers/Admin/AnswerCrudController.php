<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Traits\ApprovedRejectedTrait;
use App\Traits\ForceDeleteActionsTrait;
use App\Traits\SetPermissionTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AnswerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AnswerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use ForceDeleteActionsTrait;
    use SetPermissionTrait;
    use ApprovedRejectedTrait;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Answer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/answer');
        CRUD::setEntityNameStrings(trans('custom.answer'), trans('custom.answers'));
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
        $user = backpack_user();
        $this->crud->addButtonFromModelFunction('line', 'btnForceRestoreDelete', 'btnForceRestoreDelete', 'end');
        if ($user->canAnswerReject()) {
            $this->crud->addButtonFromView('line', 'reject', 'reject', 'beginning');
        }
        if ($user->canAnswerApprove()) {
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
            // [
            //     'label'     => trans('custom.is_active'),
            //     'type'      => 'check',
            //     'name'      => 'is_active',
            // ],
            [
                'label'     => trans('custom.status'),
                'type'      => 'closure',
                'name'      => 'status',
                'function' => function ($entry) {
                    switch ($entry->status) {
                        case config('const.answer_status.approved'):
                            $color = 'success';
                            break;
                        case config('const.answer_status.waiting'):
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
        CRUD::setValidation(AnswerRequest::class);

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
            // [
            //     'label'       => "Questions",
            //     'type'        => "select2_from_ajax",
            //     'name'        => 'question_id',
            //     'entity'      => 'question',
            //     'attribute'   => 'title',
            //     'data_source' => route('web-ajax-call', [
            //         'table' => 'questions',
            //     ]),
            //     'minimum_input_length' => -1,
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
