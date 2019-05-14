@if (count($results['massActions']))
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            @foreach($results['massActions'] as $action)
                {{--pending: 需要支持更多的type，要支持处理批量操作--}}
                @if($action['type'] == 'add')
                    <a class="btn btn-primary radius" href="{{ $action['action'] }}"><i class="icon Hui-iconfont {{ $action['icon'] }}"></i> {{ $action['label'] }}</a>
                @endif
            @endforeach
            {{--pending: 允许加入特别的action（如果有）--}}
            @yield('data-mass-action')
        </span>
    </div>
@endif

<div class="mt-20">
<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
    {{--pending: 有待完善--}}
    <table class="table table-border table-bordered table-bg table-hover table-sort dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
        <thead>
        <tr class="text-c" role="row">
            @if (count($results['records']) && $results['enableMassActions'])
                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 40px;" aria-label="" width="40">
                    <input name="" type="checkbox" value="">
                </th>
            @endif
            @foreach($results['columns'] as $key => $column)
                <th rowspan="1" colspan="1"
                    @if(isset($column['width']))
                        style="width: {{ $column['width'] }}"
                    @endif

                    @if(isset($column['sortable']) && $column['sortable'])
                        class="sorting"
                        @endif
                >
                    {{ $column['label'] }}
                </th>
            @endforeach
            @if ($results['enableActions'])
                <th>
                    {{ __('ui.datagrid.actions') }}
                </th>
            @endif
        </tr>
        </thead>
        <tbody>

        @if (count($results['records']))
            @foreach ($results['records'] as $key => $record)
                <tr class="text-c" role="row">
                    @if ($results['enableMassActions'])
                        <td><input name="" type="checkbox" value="{{ $record->{$results['index']} }}"></td>
                    @endif
                    @foreach($results['columns'] as $column)
                        @php
                            $columnIndex = explode('.', $column['index']);
                            $columnIndex = end($columnIndex);
                        @endphp
                        @if (isset($column['wrapper']))
                            @if (isset($column['closure']) && $column['closure'] == true)
                                <td>{!! $column['wrapper']($record) !!}</td>
                            @else
                                <td>{{ $column['wrapper']($record) }}</td>
                            @endif
                        @else
                            <td>{{ $record->{$columnIndex} }}</td>
                        @endif
                    @endforeach

                    @if ($results['enableActions'])
                        <td class="td-manage">
                            <div>
                                @foreach ($results['actions'] as $action)
                                    <a href="{{ route($action['route'], $record->{$results['index']}) }}">
                                        <span class="icon Hui-iconfont {{ $action['icon'] }}" onclick="return confirm('{{ __('ui.datagrid.click_on_action') }}')"></span>
                                    </a>
                                @endforeach
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="100" style="text-align: center;">{{ $results['norecords'] }}</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
</div>
