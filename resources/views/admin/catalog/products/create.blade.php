@extends('admin.layouts.master')

@section('page_title')
    {{ __('admin.catalog.products.title') }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('lib/zTree/v3/css/zTreeStyle/zTreeStyle.css') }}">
@endpush

@section('content-wrapper')
    <form class="form form-horizontal responsive" action="{{ route('admin.catalog.products.store') }}" method="post" id="createform" enctype="multipart/form-data">
        @csrf()
        {{--返回，保存--}}
        <div class="cl pd-5 mt-20">
            <span class="l">
                <h3>
                    <a onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';" class="btn btn-link radius"><i class="Hui-iconfont Hui-iconfont-slider-left"></i></a>
                    Add Category
                </h3>
            </span>
            <span class="r">
                <h3>
                    <input class="btn btn-primary" value="{{ __('admin.catalog.products.save-btn-title') }}" type="submit">
                </h3>
            </span>
        </div>

        {{--常规--}}
        <div class="panel panel-default">
            <div class="panel-header selected">{{ __('admin.catalog.products.general') }}</div>
            <div class="panel-body" style="display: block;">
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('admin.catalog.products.sku') }}</label>
                    <div class="formControls col-xs-2">
                        <input type="text" class="input-text" datatype="*" name="sku" id="sku" autocomplete="off"">
                    </div>
                    <div class="col-xs-2 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('admin.catalog.products.name') }}</label>
                    <div class="formControls col-xs-2">
                        <input type="text" class="input-text" datatype="*" name="text" id="text" autocomplete="off"">
                    </div>
                    <div class="col-xs-2 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row clearfix">
                    <label class="form-label col-xs-3">{{ __('admin.catalog.products.product-type') }}：</label>
                    <div class="formControls col-xs-4">
                        <div class="row clearfix" style="margin-top:0">
                            <div class="col-xs-6">
                                <span class="select-box">
                                    <select class="select" size="1" name="type" id="type">
                                        <option value="simple">
                                            {{ __('admin.catalog.products.simple') }}
                                        </option>
                                        <option value="configurable">
                                            {{ __('admin.catalog.products.configurable') }}
                                        </option>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('admin.catalog.products.price') }}</label>
                    <div class="formControls col-xs-2">
                        {{--pending: 输入格式的前端验证有待完善，当前只是简单检查非空--}}
                        <input type="text" class="input-text" datatype="*" name="price" id="price" autocomplete="off"">
                    </div>
                    <div class="col-xs-2 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('admin.catalog.products.qty') }}</label>
                    <div class="formControls col-xs-2">
                        {{--pending: 输入格式的前端验证有待完善，当前只是简单检查数字--}}
                        <input type="text" class="input-text" datatype="n" name="qty" id="qty" autocomplete="off"">
                    </div>
                    <div class="col-xs-2 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
            </div>
        </div>

        {{--描述与图片--}}
        {{--pending: 有待补充--}}

        {{--父分类--}}
        @if ($categories->count())
            <div class="panel panel-default mt-20">
                <div class="panel-header selected">{{ __('admin.catalog.products.categories') }}</div>
                <div class="panel-body" style="display: block;">
                    <ul id="category-tree" class="ztree"></ul>
                    <input type="hidden" name="category_id" id="category_id">
                </div>
            </div>
        @endif
    </form>
@stop

@push('scripts')
    <script type="text/javascript" src="{{ asset('lib/zTree/v3/js/jquery.ztree.core-3.5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/zTree/v3/js/jquery.ztree.excheck-3.5.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(".panel-default").Huifold({
                titCell:'.panel-header',
                mainCell:'.panel-body',
            });

            function zTreeOnCheck(event, treeId, treeNode) {
                // alert(treeId + ", " + treeNode.name);
                if(treeNode.checked){
                    $("#category_id").val(treeNode.id);
                } else {
                    $("#category_id").val('');
                }
            };

            var setting = {
                view: {
                    selectedMulti: false,
                    showIcon: false,
                    showLine: false,
                },
                check: {
                    chkStyle: "radio",//复选框类型
                    enable: true, //每个节点上是否显示 CheckBox
                    radioType: "all"
                },
                callback: {
                    onCheck: zTreeOnCheck,
                },
            };
            //构造节点数据
            var zNodes = @json($categories);
            //调用API初始化ztree
            $.fn.zTree.init($("#category-tree"), setting, zNodes).expandAll(true);

            $("#createform").Validform({
                tiptype: 2,
            });
        });
    </script>
@endpush
