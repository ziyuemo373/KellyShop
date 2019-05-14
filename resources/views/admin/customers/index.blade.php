@extends('admin.layouts.master')

@section('page_title')
    {{ __('admin.customers.customers.title') }}
@endsection

@section('content-wrapper')
    @inject('customerGrid','App\DataGrids\CustomerDataGrid')
    {!! $customerGrid->render() !!}
@endsection

