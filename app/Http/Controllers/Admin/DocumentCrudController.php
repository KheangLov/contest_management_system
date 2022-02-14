<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Document;
use App\Traits\SetPermissionTrait;
use App\Http\Requests\DocumentRequest;
use App\Traits\ForceDeleteActionsTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DocumentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DocumentCrudController extends CrudController
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
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Document::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/document');
        CRUD::setEntityNameStrings(trans('custom.document'), trans('custom.documents'));
        $this->setPermission();
    }

    public function approve($id)
    {
        return $this->crud->model->find($id)->update([
            'auth_by' => backpack_user()->id,
            'auth_at' => Carbon::now(),
            'status' => config('const.contest_status.approved')
        ]);
    }

    public function reject($id)
    {
        return $this->crud->model->find($id)->update([
            'auth_by' => null,
            'auth_at' => null,
            'status' => config('const.contest_status.rejected')
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

        $user = backpack_user();
        $this->crud->addButtonFromModelFunction('line', 'btnForceRestoreDelete', 'btnForceRestoreDelete', 'end');

        if ($user->canContestReject()) {
            $this->crud->addButtonFromView('line', 'reject', 'reject', 'beginning');
        }
        if ($user->canContestApprove()) {
            $this->crud->addButtonFromView('line', 'approve', 'approve', 'beginning');
        }

        $this->crud->addColumns([
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
            [
                'name'  => 'NameLang',
                'label' => trans('custom.name'),
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
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DocumentRequest::class);

        // CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */

        $tabEn = config('const.tab_trans.english') . ',' . trans('custom.langenglish');
        $tabKh = config('const.tab_trans.khmer') . ',' . trans('custom.langkhmer');
        $colMd6 = ['class' => 'form-group col-md-6'];

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => "Name",
                'type'  => 'text',
                'tab' => $tabEn
            ],
            [
                'name'        => 'type',
                'label'       => "Type",
                'type'        => 'select2_from_array',
                'options'     => ['General' => 'General', 'Technical' => 'Technical', 'Copy Right' => 'Copy Right'],
                'allows_null' => false,
                'default'     => 'General',
                'tab' => $tabEn,
            ],
            [
                'name'  => 'description',
                'label' => "Description",
                'type'  => 'tinymce',
                'tab' => $tabEn
            ],
            // [   // Upload
            //     'name'      => 'path',
            //     'label'     => 'File',
            //     'type'      => 'upload',
            //     'upload'    => true,
            //     'tab' => $tabEn,
            //     'disk'      => 'uploads', // if you store files in the /public folder, please omit this; if you store them in /storage or S3, please specify it;
            //     // optional:
            //     // 'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified
            // ],
            [
                'name'      => 'path',
                'label'     => 'File',
                'type'      => 'upload_multiple',
                'upload'    => true,
                'disk'      => 'public',
                'tab' => $tabEn,
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'name_kh',
                'label' => "Name Kh",
                'type'  => 'text',
                'tab' => $tabKh
            ],
            [
                'name'  => 'description_kh',
                'label' => "Description",
                'type'  => 'tinymce',
                'tab' => $tabKh
            ],
        ]);
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
