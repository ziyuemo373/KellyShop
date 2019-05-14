<header class="navbar-wrapper">
<div class="navbar navbar-black navbar-fixed-top">
    <div class="container cl">
        <a class="logo navbar-logo hidden-xs" href="{{ route('shop.home.index') }}">KellyShop</a>
        <div class="nav navbar-nav nav-collapse f-r" role="navigation" id="Hui-navbar">
            <ul class="cl">
                <li class="dropDown dropDown_hover">
                    <a href="javascript:;" class="dropDown_A">
                        @guest('customer')
                            {{ __('shop.header.title') }}
                        @endguest
                        @auth('customer')
                            {{ auth()->guard('customer')->user()->first_name }}
                        @endauth
                            <i class="Hui-iconfont Hui-iconfont-arrow2-bottom"></i>
                    </a>
                    <ul class="dropDown-menu menu radius box-shadow">
                        @guest('customer')
                            <li>
                                <a href="{{ route('customer.session.index') }}">{{ __('shop.header.sign-in') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('customer.register.index') }}">{{ __('shop.header.sign-up') }}</a>
                            </li>
                        @endguest
                        @auth('customer')
                            <li>
                                {{--{{ route('customer.profile.index') }}--}}
                                <a href="" target="_blank">{{ __('shop.header.profile') }}</a>
                            </li>
                            <li>
                                {{--{{ route('customer.wishlist.index') }}--}}
                                <a href="" target="_blank">{{ __('shop.header.wishlist') }}</a>
                            </li>
                            <li>
                                {{--{{ route('shop.checkout.cart.index') }}--}}
                                <a href="" target="_blank">{{ __('shop.header.cart') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('customer.session.destroy') }}">{{ __('shop.header.logout') }}</a>
                            </li>
                        @endauth
                    </ul>
                </li>
                <li class="dropDown dropDown_hover">
                    <?php $cart = cart()->getCart(); ?>
                    <a href="javascript:;" class="dropDown_A">
                        {{ __('shop.header.cart') }}
                        <span class="count">
                            @if(!empty($cart->items))
                                ({{ $cart->items->count() }})
                            @else
                                (0)
                            @endif
                        </span>
                    </a>
                    @auth('customer')
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li>
                                <a href="{{ route('shop.checkout.cart.index') }}">{{ __('shop.minicart.view-cart') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('shop.checkout.onepage.index') }}">{{ __('shop.minicart.checkout') }}</a>
                            </li>
                        </ul>
                    @endauth
                </li>
            </ul>
        </div>
        <nav class="navbar-userbar hidden-xs"></nav>
    </div>

</div>
</header>

