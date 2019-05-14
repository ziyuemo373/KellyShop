<?php

namespace App\DataGrids;

use Illuminate\Support\Facades\DB;

class CustomerDataGrid extends DataGrid
{
    protected $index = 'customer_id'; //the column that needs to be treated as index column

    protected $sortOrder = 'desc'; //asc or desc

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('customers as custs')
            ->addSelect('custs.id as customer_id', 'custs.email')
            ->addSelect(DB::raw('CONCAT(custs.first_name, " ", custs.last_name) as full_name'));

        $this->addFilter('customer_id', 'custs.id');
        $this->addFilter('full_name', DB::raw('CONCAT(custs.first_name, " ", custs.last_name)'));

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'customer_id',
            'label' => __('admin.datagrid.id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'full_name',
            'label' => __('admin.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'email',
            'label' => __('admin.datagrid.email'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

    }

    public function prepareMassActions() {
//        $this->enableMassAction = true;
    }

    public function prepareActions() {
//        $this->addAction([
//            'type' => 'Edit',
//            'route' => 'admin.customer.edit',
//            'icon' => 'Hui-iconfont-edit'
//        ]);
//
//        $this->addAction([
//            'type' => 'Delete',
//            'route' => 'admin.customer.delete',
//            'icon' => 'Hui-iconfont-del3'
//        ]);
    }
}