<!-- =================================================== -->
<!-- ========== Top menu items (ordered left) ========== -->
<!-- =================================================== -->
<ul class="nav navbar-nav d-md-down-none">

    @if (backpack_auth()->check())
        <!-- Topbar. Contains the left part -->
        @include(backpack_view('inc.topbar_left_content'))
    @endif

</ul>
<!-- ========== End of top menu left items ========== -->



<!-- ========================================================= -->
<!-- ========= Top menu right items (ordered right) ========== -->
<!-- ========================================================= -->
<ul class="nav navbar-nav ml-auto @if(config('backpack.base.html_direction') == 'rtl') mr-0 @endif">
    @if (backpack_auth()->guest())
        <li class="nav-item"><a class="nav-link" href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a>
        </li>
        @if (config('backpack.base.registration_open'))
            <li class="nav-item"><a class="nav-link" href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></li>
        @endif
    @else
        <!-- Topbar. Contains the right part -->
        @include(backpack_view('inc.topbar_right_content'))
        @if (request()->segment(2) != 'languages')
            <li class="nav-item dropdown pr-0">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    @php
                        $locale = App::getLocale();
                    @endphp
                    @if(App::isLocale('kh'))
                        <img src="{{ asset('assets/flag/kh-lang.png') }}" />
                    @else
                        <img src="{{ asset('assets/flag/en-lang.png') }}"/>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right mr-4 pb-1 pt-1">
                    <a class="dropdown-item" href="{{ url('lang/en') }}">
                        <img src="{{ asset('assets/flag/en-lang.png') }}" class="mr-2" />
                        @lang('custom.langenglish')
                    </a>
                    <div class="dropdown-divider m-0"></div>
                    <a class="dropdown-item" href="{{ url('lang/kh') }}">
                        <img src="{{ asset('assets/flag/kh-lang.png') }}" class="mr-2" />
                        @lang('custom.langkhmer')
                    </a>
                </div>
            </li>
        @endif
        @include(backpack_view('inc.menu_user_dropdown'))
    @endif
</ul>
<!-- ========== End of top menu right items ========== -->
