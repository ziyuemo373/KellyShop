@extends('admin.layouts.master')

@section('page_title')
    {{ __('admin.catalog.categories.title') }}
@endsection

@section('content-wrapper')
    @inject('categoryGrid','App\DataGrids\CategoryDataGrid')
    {!! $categoryGrid->render() !!}
@endsection

