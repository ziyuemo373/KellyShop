<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        @foreach ($menu->items as $menuItem)
            <dl id="menu-article">
                {{--pending: active的判断可能移到前端JS做会好一点--}}
                <dt class="{{ $menu->getActive($menuItem)==='active' ? 'selected' : '' }}">{{ __($menuItem['name']) }}<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
                <dd style="{{ $menu->getActive($menuItem)==='active' ? 'display: block;' : '' }}">
                    <ul>
                        @foreach ($menuItem['children'] as $item)
                            <li class="{{ $menu->getActive($item)==='active' ? 'current' : '' }}">
                                <a href="{{ $item['url'] }}">
                                    {{ __($item['name']) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </dd>
            </dl>
        @endforeach
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onclick="displaynavbar(this)"></a></div>