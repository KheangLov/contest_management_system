<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
@php
    $user = backpack_user();
@endphp

@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('dashboard'),
        trans('backpack::base.dashboard'),
        'nav-icon la la-home'
    ],
    // 'permission' => 'canOrderList'
])

@if ($user->canLevelList() || $user->canContestList() || $user->canQuestionList() || $user->canAnswerList() || $user->canRegisteredContestList())
    <li class="nav-item nav-dropdown">
        <a
            class="nav-link nav-dropdown-toggle text-truncate"
            href="#"
            data-toggle="tooltip"
            data-placement="bottom"
            title="{!! trans('custom.contests') !!}"
        >
            <i class="nav-icon las la-award"></i>
            @lang('custom.contests')
        </a>
        <ul class="nav-dropdown-items">
            @include('partials.sidebar_link', [
                'entry' => [
                    backpack_url('category'),
                    trans('custom.categories'),
                    'nav-icon las la-archive'
                ],
                'permission' => 'canLevelList'
            ])
            @include('partials.sidebar_link', [
                'entry' => [
                    backpack_url('level'),
                    trans('custom.levels'),
                    'nav-icon las la-level-up-alt'
                ],
                'permission' => 'canLevelList'
            ])
            @include('partials.sidebar_link', [
                'entry' => [
                    backpack_url('registered_contest'),
                    trans('custom.registered_contest'),
                    'nav-icon lab la-wpforms'
                ],
                'permission' => 'canRegisteredContestList'
            ])
            @include('partials.sidebar_link', [
                'entry' => [
                    backpack_url('contest'),
                    trans('custom.contests'),
                    'nav-icon las la-award'
                ],
                'permission' => 'canContestList'
            ])
            @include('partials.sidebar_link', [
                'entry' => [
                    backpack_url('question'),
                    trans('custom.questions'),
                    'nav-icon la la-question'
                ],
                'permission' => 'canQuestionList'
            ])
            @include('partials.sidebar_link', [
                'entry' => [
                    backpack_url('answer'),
                    trans('custom.answers'),
                    'nav-icon las la-book-reader'
                ],
                'permission' => 'canAnswerList'
            ])
        </ul>
    </li>
@endif

@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('student'),
        trans('custom.students'),
        'nav-icon las la-user-graduate'
    ],
    'permission' => 'canStudentList'
])

@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('workshop'),
        trans('custom.workshops'),
        'nav-icon la la-lightbulb-o',
    ],
    'permission' => 'canWorkshopList'
])

@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('document'),
        trans('custom.document'),
        'nav-icon la la-book',
    ],
    'permission' => 'canDocumentList'
])

@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('news'),
        trans('backpack::crud.news'),
        'nav-icon la la-newspaper-o '
    ],
    'roles' => 'canNewsList'
])

@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('faq'),
        trans('backpack::crud.faq'),
        'nav-icon la la-comments-o'
    ],
    'roles' => 'canFaqList'
])

@if ($user->isAdminRole() || $user->canUserList())
    <li class="nav-item nav-dropdown">
        <a
            class="nav-link nav-dropdown-toggle text-truncate"
            href="#"
            data-toggle="tooltip"
            data-placement="bottom"
            title="{!! trans('custom.authentication') !!}"
        >
            <i class="nav-icon la la-users"></i>
            @lang('custom.authentication')
        </a>
        <ul class="nav-dropdown-items">
            @include('partials.sidebar_link', [
                'entry' => [
                    backpack_url('user'),
                    trans('custom.users'),
                    'nav-icon la la-user'
                ],
                'permission' => 'canUserList'
            ])
            @include('partials.sidebar_link', [
                'entry' => [
                    backpack_url('role'),
                    trans('custom.roles'),
                    'nav-icon la la-id-badge'
                ],
                'roles' => 'isAdminRole'
            ])
            @include('partials.sidebar_link', [
                'entry' => [
                    backpack_url('permission'),
                    trans('custom.permissions'),
                    'nav-icon la la-key'
                ],
                'roles' => 'isAdminRole'
            ])
        </ul>
    </li>
@endif

@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('setting'),
        trans('custom.settings'),
        'nav-icon la la-cog'
    ],
    'roles' => 'isAdminRole'
])
@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('log'),
        trans('custom.logs'),
        'nav-icon la la-terminal'
    ],
    'roles' => 'isAdminRole'
])
@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('elfinder'),
        trans('backpack::crud.file_manager'),
        'nav-icon la la-files-o'
    ],
    'roles' => 'isAdminRole'
])
@if ($user->isAdminRole())
    <li class="nav-item nav-dropdown">
        <a
            class="nav-link nav-dropdown-toggle text-truncate"
            href="#"
            data-toggle="tooltip"
            data-placement="bottom"
            title="{!! trans('translation::translation.language') !!}"
        >
            <i class="nav-icon las la-language"></i>
            @lang('translation::translation.language')
        </a>
        <ul class="nav-dropdown-items">
            @include('partials.sidebar_link', [
                'entry' => [
                    route('languages.index'),
                    trans('translation::translation.languages'),
                    'nav-icon las la-globe'
                ],
            ])
            @include('partials.sidebar_link', [
                'entry' => [
                    route('languages.translations.index', config('app.locale')),
                    trans('translation::translation.translations'),
                    'nav-icon las la-language'
                ],
            ])
        </ul>
    </li>
@endif
