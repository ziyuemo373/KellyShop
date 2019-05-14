<?php

namespace App\DataGrids;

use Illuminate\Support\Facades\DB;

class ProductDataGrid extends DataGrid
{
    protected $sortOrder = 'desc'; //asc or desc

    protected $index = 'product_id';

    protected $itemsPerPage = 20;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('products')
            ->select('products.id as product_id', 'products.sku as product_sku', 'products.text as productname', 'products.type as product_type', 'products.price', 'products.qty as quantity');

        $this->addFilter('product_id', 'products.product_id');
        $this->addFilter('productname', 'products.name');
        $this->addFilter('product_sku', 'products.sku');
        $this->addFilter('product_type', 'products.type');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'product_id',
            'label' => trans('admin.datagrid.id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'product_sku',
            'label' => trans('admin.datagrid.sku'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'productname',
            'label' => trans('admin.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'product_type',
            'label' => trans('admin.datagrid.type'),
            'type' => 'string',
            'sortable' => true,
            'searchable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'price',
            'label' => trans('admin.datagrid.price'),
            'type' => 'price',
            'sortable' => true,
            'searchable' => false,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'quantity',
            'label' => trans('admin.datagrid.qty'),
            'type' => 'number',
            'sortable' => true,
            'searchable' => false,
            'filterable' => false
        ]);

    }

    public function prepareMassActions() {
        $this->addMassAction([
            'type' => 'add',
            'label' => __('admin.catalog.products.add-title'),
            'action' => route('admin.catalog.products.create'),
            'icon' => 'Hui-iconfont-add',
        ]);

        $this->enableMassAction = false;
    }

    public function prepareActions() {
        $this->addAction([
            'type' => 'Delete',
            'route' => 'admin.catalog.products.delete',
            'confirm_text' => __('ui.datagrid.massaction.delete', ['resource' => 'product']),
            'icon' => 'Hui-iconfont-del3'
        ]);
        $this->enableAction = true;
    }
}