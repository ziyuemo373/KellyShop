<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe625;</i> {{__('admin.layouts.home-page')}}
    {{--pending: active的判断可能移到前端JS做会好一点--}}
    <?php $items = $menu->items;  ?>
    @while (!empty($items))
        @foreach($items as $menuItem)
            @if($menu->getActive($menuItem)==='active')
                <span class="c-gray en">&gt;</span> {{ __($menuItem['name']) }}
                <?php $items = $menuItem['children'];  ?>
            @endif
        @endforeach
    @endwhile
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>