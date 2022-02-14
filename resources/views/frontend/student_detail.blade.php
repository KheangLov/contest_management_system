@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.my_student_detail'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.my_students') => route('my_student'),
            trans('custom.my_student_detail') => '#'
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
    $user = optional($entry->user);
@endphp

@section('content')
    <div id="overviews" class="section wb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 blog-post-single">
                    <div class="blog-item">
                        <div class="post-content">
                            {{-- <div class="post-date">
                                @php
                                    $date = $entry->StartDateTime;
                                @endphp
                                <span class="day">{{ $date->day }}</span>
                                <span class="month">{{ $date->shortLocaleMonth }}</span>
                            </div> --}}
                            {{-- <div class="meta-info-blog">
                                <span>
                                    <i class="fa fa-tag"></i>
                                    <a href="#">
                                        {{ optional($contest->level)->LevelCategory }}
                                    </a>
                                </span>
                                <span>
                                    <i class="fa fa-clock"></i>
                                    <a href="#">
                                        {{ $contest->duration }}mn
                                    </a>
                                </span>
                            </div> --}}
                            {{-- <div class="blog-title">
                                <h2>
                                    <a href="#" title="">
                                        {{ trans('custom.contest_title') }}: {{ $contest->TitleLang }}
                                    </a>
                                </h2>
                            </div> --}}
                            <div class="blog-desc row">
                                <div class="col-md-6">
                                    <ul class="list-group mb-3 rounded-0 border-0 shadow-sm">
                                        <li class="list-group-item bg-secondary rounded-0 border-0" aria-disabled="true">
                                            <h6 class="m-0 font-weight-bold text-white p-0">
                                                {{ trans('custom.student_information') }}:
                                            </h6>
                                        </li>
                                        <li class="list-group-item rounded-0 border-0" aria-disabled="true">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold mr-1">
                                                            {{ trans('custom.name') }}:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $entry->FullName }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold mr-1">
                                                            {{ trans('custom.gender') }}:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $entry->gender }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold mr-1">
                                                            {{ trans('custom.date_of_birth') }}:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $entry->dob }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold mr-1">
                                                            {{ trans('custom.school') }}:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $entry->school }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold mr-1">
                                                            {{ trans('custom.email') }}:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $entry->email }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold mr-1">
                                                            {{ trans('custom.phone') }}:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $entry->phone }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold mr-1">
                                                            {{ trans('custom.address') }}:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $entry->address }}
                                                        </span>
                                                    </div>
                                                    @if ($user->count())
                                                        <div class="mb-1">
                                                            <span class="font-weight-bold mr-1">
                                                                {{ trans('custom.link_to_contest') }}:
                                                            </span>
                                                            <span class="text-muted text-lowercase click_to_copy">
                                                                <span class="d-none">
                                                                    {{ route('deep_link_login') . '?login_token=' . $user->login_token }}
                                                                </span>
                                                                {{ trans('custom.click_to_copy') }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-5 text-center">
                                                    <img src="{{ asset($entry->ProfileOrDefault) }}" alt="" class="img-fluid">
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <div class="blog-title">
                                        <h2>
                                            <a href="#">
                                                {{ trans('custom.registered_contest') }}
                                            </a>
                                        </h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            @forelse ($user->userRegContests ?? [] as $rc)
                                                <ul class="list-group mb-3 rounded-0 border-0 shadow-sm">
                                                    <li class="list-group-item bg-secondary rounded-0 border-0" aria-disabled="true">
                                                        <h6 class="m-0 font-weight-bold text-white p-0">{!! $rc->ContestTitle !!}</h6>
                                                    </li>
                                                    <li class="list-group-item rounded-0 border-0" aria-disabled="true">
                                                        <div class="row">
                                                            <div class="col-md-7">

                                                                @if ($rc->start_date)
                                                                    <div class="mb-1">
                                                                        <span class="font-weight-bold d-inline-block">
                                                                            {{ trans('custom.started') }}:
                                                                        </span>
                                                                        <span class="d-inline-block text-muted">
                                                                            {{ $rc->start_date }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <span class="font-weight-bold d-inline-block">
                                                                            {{ trans('custom.ended') }}:
                                                                        </span>
                                                                        <span class="d-inline-block text-muted">
                                                                            {{ optional($rc->score)->created_at }}
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <div class="mb-1">
                                                                        <span class="font-weight-bold d-inline-block">
                                                                            {{ trans('custom.expired') }}:
                                                                        </span>
                                                                        <span class="d-inline-block text-muted">
                                                                            {{ optional($rc->contest)->end_at }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <span class="font-weight-bold mr-1">
                                                                            {{ trans('custom.link_to_contest') }}:
                                                                        </span>
                                                                        <span class="text-muted text-lowercase click_to_copy">
                                                                            <span class="d-none">
                                                                                {{ route('deep_link_login') . '?login_token=' . $user->login_token . '&contest_id=' . $rc->id }}
                                                                            </span>
                                                                            {{ trans('custom.click_to_copy') }}
                                                                        </span>
                                                                    </div>
                                                                @endif


                                                                <div class="mb-1">
                                                                    <span class="font-weight-bold d-inline-block">
                                                                        {{ trans('custom.took') }}:
                                                                    </span>
                                                                    <span class="d-inline-block text-muted">
                                                                        {{ $rc->duration }}mn
                                                                    </span>
                                                                </div>
                                                                <div class="mt-2">
                                                                    @php
                                                                        $score = optional($rc->score)->score;
                                                                    @endphp
                                                                    <h2 class="font-weight-bold d-inline-block">
                                                                        {{ trans('custom.score') }}:
                                                                    </h2>
                                                                    <h2 class="d-inline-block font-weight-bold {{ $score < 50 ? 'text-danger' : 'text-success' }}">
                                                                        {{ $score }}pt
                                                                    </h2>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <img src="{{ asset(optional($rc->contest)->ImageOrDefault) }}" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            @empty
                                                <p>{{ trans('custom.no_contests') }}</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
@endsection

@push('after_styles')
    <style>
        .click_to_copy:hover,
        .click_to_copy:focus {
            cursor: pointer;
        }
    </style>
@endpush

@push('after_scripts')
    <script>
        $(function() {
            $('.click_to_copy').on('click', function() {
                var element = $(this);
                var temp = $("<input>");
                $("body").append(temp);
                temp.val(element.find('span').text()).select();
                document.execCommand("copy");
                temp.remove();
                element.popover({
                    content: '{{ trans("custom.copied") }}',
                    placement: 'bottom',
                });
                element.popover("show");
                setTimeout(() => element.popover("hide"), 2000);
            });
        });
    </script>
@endpush
