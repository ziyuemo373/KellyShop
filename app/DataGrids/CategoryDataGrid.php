<?php

namespace App\DataGrids;

use Illuminate\Support\Facades\DB;

class CategoryDataGrid extends DataGrid
{
    protected $index = 'category_id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('categories as cat')
            ->select('cat.id as category_id', 'cat.name', 'cat.position', 'cat.status')
            ->groupBy('cat.id');

        $this->addFilter('category_id', 'cat.id');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'category_id',
            'label' => trans('admin.datagrid.id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('admin.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'position',
            'label' => trans('admin.datagrid.position'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('admin.datagrid.status'),
            'type' => 'boolean',
            'sortable' => true,
            'searchable' => true,
            'filterable' => true,
            'wrapper' => function($value) {
                if ($value->status == 1)
                    return 'Active';
                else
                    return 'Inactive';
            }
        ]);
    }

    public function prepareMassActions() {
        $this->addMassAction([
            'type' => 'add',
            'label' => __('admin.catalog.categories.add-title'),
            'action' => route('admin.catalog.categories.create'),
            'icon' => 'Hui-iconfont-add',
        ]);

        $this->enableMassAction = false;
    }

    public function prepareActions() {
        $this->addAction([
            'type' => 'Delete',
            'route' => 'admin.catalog.categories.delete',
            'confirm_text' => __('ui.datagrid.massaction.delete', ['resource' => 'product']),
            'icon' => 'Hui-iconfont-del3'
        ]);
    }
}