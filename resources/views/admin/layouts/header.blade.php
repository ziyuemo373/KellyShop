<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl">
            <a class="logo navbar-logo f-l mr-10 hidden-xs" href="{{ route('admin.dashboard.index') }}">KellyShop - Admin</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    {{--pending: 有待补充角色相关的逻辑--}}
                    {{--<li>超级管理员</li>--}}
                    <li class="dropDown dropDown_hover">
                        <a href="#" class="dropDown_A">
                            @auth('admin')
                                {{ auth()->guard('admin')->user()->name }}
                            @endauth
                                <i class="Hui-iconfont">&#xe6d5;</i>
                        </a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            @auth('admin')
                                <li>
                                    {{--{{ route('admin.account.edit') }}--}}
                                    <a href="">{{ trans('admin.layouts.my-account') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.session.destroy') }}">{{ __('admin.layouts.logout') }}</a>
                                </li>
                            @endauth
                        </ul>
                    </li>
                    {{--pending: 有待完善--}}
                    <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>