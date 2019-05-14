@extends('admin.layouts.master')

@section('page_title')
    {{ __('admin.catalog.products.title') }}
@endsection

@section('content-wrapper')
    @inject('productGrid','App\DataGrids\ProductDataGrid')
    {!! $productGrid->render() !!}
@endsection

