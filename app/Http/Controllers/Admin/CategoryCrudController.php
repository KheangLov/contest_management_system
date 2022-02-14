<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Traits\SetPermissionTrait;
use App\Http\Requests\CategoryRequest;
use App\Traits\ForceDeleteActionsTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use ForceDeleteActionsTrait;
    use SetPermissionTrait;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings(trans('custom.category'), trans('custom.categories'));
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
        $this->crud->query->withCount('levels');
        $this->crud->addColumns([
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
                'label'     => trans('custom.is_active'),
                'type'      => 'check',
                'name'      => 'is_active',
            ],
            [
                'label'     => trans('custom.levels'),
                'type'      => 'text',
                'name'      => 'levels_count',
                'wrapper'   => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('level?category='.$entry->getKey());
                    },
                ],
                'suffix'    => ' ' . strtolower(trans('custom.levels')),
            ]
        ]);

        $this->crud->addFilter(
            ['type' => 'simple', 'name' => 'is_active', 'label' => trans('custom.is_active')],
            false,
            function () {
                $this->crud->query->where('is_active', true)->get();
            }
        );
        $this->crud->addFilter(
            [
                'type'  => 'text',
                'name'  => 'title',
                'label' => trans('custom.title'),
            ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'title', 'LIKE', "%$value%");
                $this->crud->addClause('orWhere', 'title_kh', 'LIKE', "%$value%");
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
        CRUD::setValidation(CategoryRequest::class);

        $colMd6 = ['class' => 'form-group col-md-6'];
        $this->crud->addFields([
            [
                'name'  => 'is_active',
                'label' => trans('custom.is_active'),
                'type'  => 'checkbox',
            ],
            [
                'name'  => 'title',
                'label' => trans('custom.title'),
                'type'  => 'text',
                'wrapper' => $colMd6,
            ],
            [
                'name'  => 'title_kh',
                'label' => trans('custom.title_kh'),
                'type'  => 'text',
                'wrapper' => $colMd6,
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

    public function fetchCategory()
    {
        return ['data' => $this->crud->model
            ->IsActive()
            ->paginate(10)
            ->map(function ($v) {
                return [
                    'id' => $v->id,
                    'title' => $v->TitleLang
                ];
            })
        ];
    }

}
