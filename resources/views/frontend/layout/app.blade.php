<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Basic -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Site Metas -->
        <title>Welcome to Cambodia Math Society</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="author" content="">

        @stack('before_styles')

        <!-- Site Icons -->
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
        <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('packages/bootstrap-iconpicker/icon-fonts/font-awesome-5.12.0-1/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
        <!-- Site CSS -->
        <link rel="stylesheet" href="{{ asset('style.css') }}">
        <!-- ALL VERSION CSS -->
        <link rel="stylesheet" href="{{ asset('css/versions.css') }}">
        <!-- Responsive CSS -->
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        @stack('after_styles')
    </head>
    <body class="host_version">
        @php
            if(Request::segment(1) != 'workshop'){
                Session::forget('actionAuthFront');
            }

            $user = backpack_user();

            if ($user && $user->isStudentRole()) {
                $checkRegNoScores = optional($user->userRegContests)
                    ->whereNotNull('start_date')
                    ->whereNull('score')
                    ->all();
            }
        @endphp

        <!-- Modal -->
        @guest
            <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header tit-up">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">{{ trans('custom.customer_login') }}</h4>
                        </div>
                        <div class="modal-body customer-box">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li><a class="{{ Session::get('frontend_login_popup') !== 'register' ? 'active' : '' }}" href="#Login" data-toggle="tab">{{ trans('custom.login') }}</a></li>
                                <li><a class="{{ Session::get('frontend_login_popup') === 'register' ? 'active' : '' }}" href="#Registration" data-toggle="tab">{{ trans('custom.registration') }}</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane {{ Session::get('frontend_login_popup') !== 'register' ? 'active show' : '' }}" id="Login">
                                    <form role="form" class="form-horizontal" method="POST" action="{{ route('backpack.auth.login') }}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="request_type" value="{{ config('const.frontend') }}" />
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email1" placeholder="{{ trans('custom.email') }}" type="email" name="email" value="{{ old('email') }}">

                                                @if ($errors->has('email') && Session::get('frontend_login_popup') !== 'register')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="exampleInputPassword1" placeholder="{{ trans('custom.password') }}" type="password" name="password">
                                                @if ($errors->has('password') && Session::get('frontend_login_popup') !== 'register')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-light btn-radius btn-brd grd1">
                                                    {{ trans('custom.submit') }}
                                                </button>
                                                {{-- <a class="for-pwd" href="javascript:;">Forgot your password?</a> --}}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane {{ Session::get('frontend_login_popup') === 'register' ? 'active show' : '' }}" id="Registration">
                                    <form role="form" class="form-horizontal" aria-label="form" method="POST" action="{{ route('register') }}">
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="text" name="first_name" class="form-control text-dark @error('first_name') is-invalid @enderror" placeholder="{{ trans('custom.first_name') }}" autofocus="" autocomplete="off" value="{{ old('first_name') }}">
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('first_name')  }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="text" name="last_name" class="form-control text-dark @error('last_name') is-invalid @enderror" placeholder="{{ trans('custom.last_name') }}" autocomplete="off" value="{{ old('last_name') }}">
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="date" name="dob" class="form-control text-dark @error('dob') is-invalid @enderror" placeholder="{{ trans('custom.date_of_birth') }}" autocomplete="off" value="{{ old('dob') }}">
                                                @error('dob')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('dob') }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="tel" name="phone" class="form-control text-dark @error('phone') is-invalid @enderror" placeholder="{{ trans('custom.phone') }}" autocomplete="off" value="{{ old('phone') }}">
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('phone') }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="email" name="email" class="form-control text-dark @error('email') is-invalid @enderror" placeholder="{{ trans('custom.email') }}" autofocus="" autocomplete="off" value="{{ old('email') }}">
                                                @if ($errors->has('email') && Session::get('frontend_login_popup') === 'register')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="form-control text-dark {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ trans('custom.password') }}" type="password" name="password" value="{{ old('password') }}">
                                                @if ($errors->has('password') && Session::get('frontend_login_popup') === 'register')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="password" name="password_confirmation" class="form-control text-dark @error('password_confirmation') is-invalid @enderror" placeholder="{{ trans('custom.confirm_password') }}" autofocus="" value="{{ old('password_confirmation') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="text" name="school" class="form-control text-dark @error('school') is-invalid @enderror" placeholder="{{ trans('custom.school') }}" autocomplete="off" value="{{ old('school') }}">
                                                @error('school')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('school') }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="text" name="address" class="form-control text-dark @error('address') is-invalid @enderror" placeholder="{{ trans('custom.address') }}" autocomplete="off" value="{{ old('address') }}">
                                                @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('address') }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <select name="role" class="form-control text-dark">
                                                    @foreach ($frontendRoles as $id => $name)
                                                        <option value="{{ $id }}"{{ $id == 3 ? ' selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-light btn-radius btn-brd grd1">
                                                    {{ trans('custom.save_and_continue') }}
                                                </button>
                                                <button type="button" class="btn btn-light btn-radius btn-brd grd1" data-dismiss="modal" aria-hidden="true">
                                                    {{ trans('custom.cancel') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endguest

        <!-- LOADER -->
        <div id="preloader">
            <div class="loader-container">
                <div class="progress-br float shadow">
                    <div class="progress__item"></div>
                </div>
            </div>
        </div>
        <!-- END LOADER -->

        <!-- Start header -->
        <header class="top-navbar">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="images/logo.png" />
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-host" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbars-host">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/') }}">
                                    {{ trans('custom.home') }}
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('about-us') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('about_us') }}">
                                    {{ trans('custom.about_us') }}
                                </a>
                            </li>
                            <li class="nav-item dropdown {{ request()->segment(1) == 'contest' ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#"  id="dropdown-contest" data-toggle="dropdown">
                                    {{ trans('custom.contest') }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdown-contest">
                                    @forelse ($contestLevels as $level)
                                        <a class="dropdown-item" href="{{ route('contest') }}?level={{ $level->id }}">
                                            {{ $level->LevelCategory }}
                                        </a>
                                    @empty
                                        <a class="dropdown-item" href="#">
                                            {{ trans('custom.no_contests') }}
                                        </a>
                                    @endforelse
                                </div>
                            </li>
                            <li class="nav-item dropdown {{ request()->is('document') ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">
                                    {{ trans('custom.document') }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdown-a">
                                    <a class="dropdown-item" href="{{route('document',['general=1'])}}">
                                        {{ trans('custom.general') }}
                                    </a>
                                    @if ($user && ($user->isAdminRole() || $user->isMemberRole()))
                                        <a class="dropdown-item" href="{{route('document',['technical=1'])}}">
                                            {{ trans('custom.technical') }}
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{route('document',['copy_right=1'])}}">
                                        {{ trans('custom.copy_right') }}
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item {{ request()->segment(1) == 'workshop' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('workshop') }}">
                                    {{ trans('custom.workshop') }}
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('faq') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('faq')}}">
                                    {{ trans('custom.faq') }}
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('contact-us') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('contact_us') }}">
                                    {{ trans('custom.contact') }}
                                </a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            @guest
                                <li>
                                    <a class="hover-btn-new log orange" href="#" data-toggle="modal" data-target="#login">
                                        <span>{{ trans('custom.login') }}</span>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-black-50" href="#" id="dropdown-a" data-toggle="dropdown">{{ backpack_user()->FullName }}</a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown-a">
                                        @if ($user->isBackendRoles())
                                            <a class="dropdown-item" href="{{ backpack_url('dashboard') }}">
                                                {{ trans('custom.go_to_dashboard') }}
                                            </a>
                                        @else
                                            <a class="dropdown-item" href="{{ route('my_account') }}">
                                                {{ trans('backpack::base.my_account') }}
                                            </a>
                                            @if ($user->isSchoolRole())
                                                <a class="dropdown-item" href="{{ route('my_student') }}">
                                                    {{ trans('custom.my_students') }}
                                                </a>
                                            @endif
                                            @if ($user->isStudentRole())
                                                <a class="dropdown-item" href="{{ route('my_contest') }}">
                                                    {{ trans('custom.my_contests') }}
                                                </a>
                                            @endif
                                        @endif
                                        <a class="dropdown-item" href="{{ route('logout') }}">
                                            {{ trans('backpack::base.logout') }}
                                        </a>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                        <ul class="nav language">
                            <li>
                                <a href="{{ url('lang/kh') }}">
                                    <img src="{{ asset('images/kh.png') }}" alt="" title="Khmer"/>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('lang/en') }}">
                                    <img src="{{ asset('images/en.png') }}" alt="" title="English"/>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>
        </header>
        <!-- End header -->

        @includeWhen(isset($breadcrumbs), 'partials.breadcrumbs')

        @yield('content')

        <div class="section cl">
            <div class="container">
                <div class="row text-left stat-wrap">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <span data-scroll class="global-radius icon_wrap effect-1 alignleft"><i class="flaticon-study"></i></span>
                        <p class="stat_count">{{ $countStudents }}</p>
                        <h3>{{ trans('custom.students') }}</h3>
                    </div><!-- end col -->

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <span data-scroll class="global-radius icon_wrap effect-1 alignleft"><i class="flaticon-online"></i></span>
                        <p class="stat_count">{{ $countTeachers }}</p>
                        <h3>{{ trans('custom.teachers') }}</h3>
                    </div><!-- end col -->

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <span data-scroll class="global-radius icon_wrap effect-1 alignleft"><i class="flaticon-years"></i></span>
                        <p class="stat_count">{{ $countContests }}</p>
                        <h3>{{ trans('custom.contests') }}</h3>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </div><!-- end section -->

        <div class="parallax section dbcolor">
            <div class="container">
                <div class="row logos">
                    <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                        <a href="#"><img src="{{ asset('images/1a1.jpg') }}" alt="" class="img-repsonsive"></a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                        <a href="#"><img src="{{ asset('images/4a1.jpg') }}" alt="" class="img-repsonsive"></a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                        <a href="#"><img src="{{ asset('images/7a1.jpg') }}" alt="" class="img-repsonsive"></a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                        <a href="#"><img src="{{ asset('images/8a1.jpg') }}" alt="" class="img-repsonsive"></a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                        <a href="#"><img src="{{ asset('images/8a1.jpg') }}" alt="" class="img-repsonsive"></a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                        <a href="#"><img src="{{ asset('images/8a1.jpg') }}" alt="" class="img-repsonsive"></a>
                    </div>
                </div><!-- end row -->
            </div><!-- end container -->
        </div><!-- end section -->

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="widget clearfix">
                            <div class="widget-title">
                                <h3>{{ trans('custom.about_us') }}</h3>
                            </div>
                            {!! config('settings.about_us_content' . $prefix) !!}
                            @if (config('settings.social_links'))
                                <div class="footer-right">
                                    <ul class="footer-links-soi">
                                        @foreach (json_decode(config('settings.social_links')) as $socialLink)
                                            <li>
                                                <a href="{{ $socialLink->link }}">
                                                    <i class="{{ $socialLink->icon }}"></i>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul><!-- end links -->
                                </div>
                            @endif
                        </div><!-- end clearfix -->
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="widget clearfix">
                            <div class="widget-title">
                                <h3>{{ trans('custom.information_link') }}</h3>
                            </div>
                            <ul class="footer-links">
                                <li><a href="{{ url('/') }}">{{ trans('custom.home') }}</a></li>
                                <li><a href="{{ route('about_us') }}">{{ trans('custom.about') }}</a></li>
                                <li><a href="#">{{ trans('custom.faq') }}</a></li>
                                <li><a href="{{ route('contact_us') }}">{{ trans('custom.contact') }}</a></li>
                            </ul><!-- end links -->
                        </div><!-- end clearfix -->
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="widget clearfix">
                            <div class="widget-title">
                                <h3>{{ trans('custom.contact_details') }}</h3>
                            </div>

                            {!! config('settings.contact_details' . $prefix) !!}
                        </div><!-- end clearfix -->
                    </div><!-- end col -->

                </div><!-- end row -->
            </div><!-- end container -->
        </footer><!-- end footer -->

        <div class="copyrights">
            <div class="container">
                <div class="footer-distributed">
                    <div class="footer-center">
                        <p class="footer-company-name">
                            {!! trans('custom.copyright_text_footer') !!}
                        </p>
                    </div>
                </div>
            </div><!-- end container -->
        </div><!-- end copyrights -->

        <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

        @stack('before_scripts')

        <!-- Modernizer for Portfolio -->
        <script src="{{ asset('js/modernizer.js') }}"></script>
        <script src="{{ asset('js/frontend.js') }}"></script>
        <script src="{{ asset('js/popper.js') }}"></script>
        <!-- ALL JS FILES -->
        <script src="{{ asset('js/all.js') }}"></script>
        <!-- ALL PLUGINS -->
        <script src="{{ asset('js/custom.js') }}"></script>
        <script>
            @if (isset($checkRegNoScores) && count($checkRegNoScores) && request()->segment(1) != 'taking-exam')
                async function submitExamData(registered_contest) {
                    await axios.post(`{{ route('submit_exam') }}`, { registered_contest })
                        .then(({ data: { success, message: text } }) => {
                            if (success) {
                                new Noty({
                                    type: "success",
                                    text,
                                    timeout: 3000,
                                }).show();
                                localStorage.setItem('active_question', '');
                                localStorage.setItem('data_questions', '');
                            }
                        })
                        .catch(err => console.error(err));
                }
                @foreach ($checkRegNoScores as $val)
                    submitExamData('{{ $val["id"] }}');
                @endforeach
            @endif

            @if (Session::get('frontend_login_popup'))
                @guest
                    $('#login').modal('show');
                @else
                    new Noty({
                        type: "success",
                        text: '{{ trans("custom.welcome_user") }}: {{ backpack_user()->FullName }}',
                        timeout: 3000,
                    }).show();
                @endguest
                @php
                    Session::forget('frontend_login_popup');
                @endphp
            @endif

            @if (!$errors->isEmpty())
                $('#loginRegisterWorkShop{{old("workshop_id")}}.modal').modal('show');
            @endif
        </script>

        @stack('after_scripts')
    </body>
</html>
