@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.view_statistic'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.my_contests') => route('my_contest'),
            trans('custom.view_statistic') => '#',
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
    $contest = optional($entry->contest);
@endphp

@section('content')
    <div id="overviews" class="section wb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 blog-post-single">
                    <div class="blog-item">
                        <div class="post-content">
                            <div class="post-date">
                                @php
                                    $date = $entry->StartDateTime;
                                @endphp
                                <span class="day">{{ $date->day }}</span>
                                <span class="month">{{ $date->shortLocaleMonth }}</span>
                            </div>
                            <div class="meta-info-blog">
                                {{-- <span><i class="fa fa-calendar"></i> <a href="#">{{ $date->toDateString() }}</a> </span> --}}
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
                            </div>
                            <div class="blog-title">
                                <h2>
                                    <a href="#" title="">
                                        {{ trans('custom.contest_title') }}: {{ $contest->TitleLang }}
                                    </a>
                                </h2>
                            </div>
                            <div class="blog-desc row">
                                <div class="col-md-6">
                                    <ul class="list-group mb-3 rounded-0 border-0 shadow-sm">
                                        <li class="list-group-item bg-secondary rounded-0 border-0" aria-disabled="true">
                                            <h6 class="m-0 font-weight-bold text-white p-0">
                                                {{ trans('custom.student_stat') }}:
                                            </h6>
                                        </li>
                                        @php
                                            $user = optional($entry->user);
                                        @endphp
                                        <li class="list-group-item rounded-0 border-0" aria-disabled="true">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold">
                                                            {{ trans('custom.name') }}:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $user->FullName }}
                                                        </span>
                                                    </div>
                                                    {{-- <div class="mb-1">
                                                        <span class="font-weight-bold">
                                                            Gender:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $user->gender }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold">
                                                            Date of Birth:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $user->DobFormat }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold">
                                                            School:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $user->school }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold">
                                                            Address:
                                                        </span>
                                                        <span class="text-muted">
                                                            {{ $user->address }}
                                                        </span>
                                                    </div> --}}
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold d-inline-block">
                                                            {{ trans('custom.started') }}:
                                                        </span>
                                                        <span class="d-inline-block text-muted">
                                                            {{ $date->toDateTimeString() }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold d-inline-block">
                                                            {{ trans('custom.ended') }}:
                                                        </span>
                                                        <span class="d-inline-block text-muted">
                                                            {{ optional($user->score)->created_at }}
                                                        </span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="font-weight-bold d-inline-block">
                                                            {{ trans('custom.took') }}:
                                                        </span>
                                                        <span class="d-inline-block text-muted">
                                                            {{ $entry->duration }}mn
                                                        </span>
                                                    </div>
                                                    <div class="mt-2">
                                                        @php
                                                            $score = optional($user->score)->score;
                                                        @endphp
                                                        <h2 class="font-weight-bold d-inline-block">
                                                            {{ trans('custom.score') }}:
                                                        </h2>
                                                        <h2 class="d-inline-block font-weight-bold {{ $score < 50 ? 'text-danger' : 'text-success' }}">
                                                            {{ $score }}pt
                                                        </h2>
                                                        <span class="d-block">
                                                            <a href="{{ route('view_certificate', ['regContestId' => $entry->id]) }}" class="btn btn-link p-0" target="_blank">
                                                                {{ trans('custom.download_certificate') }}
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <img src="{{ asset($user->ProfileOrDefault) }}" alt="" class="img-fluid">
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12">
                                    <div class="blog-title">
                                        <h2>
                                            <a href="#" title="">
                                                {{ trans('custom.all_q_and_a') }}
                                            </a>
                                        </h2>
                                    </div>
                                    @forelse ($entry->statistics as $statistic)
                                        @php
                                            $question = optional($statistic->question);
                                        @endphp
                                        <ul class="list-group mb-3 rounded-0 border-0 shadow-sm">
                                            <li class="list-group-item bg-secondary rounded-0 border-0" aria-disabled="true">
                                                <h6 class="m-0 font-weight-bold text-white p-0">{!! $question->TitleLang !!}</h6>
                                            </li>
                                            @forelse ($question->answers as $answer)
                                                <li class="list-group-item rounded-0 border-0" aria-disabled="true">
                                                    {{-- {{ $question->answer_id == $answer->id ? ' bg-success text-white' : '' }} --}}
                                                    <p class="d-inline-block m-0{{ $answer->id == $statistic->chose_answer_id ? ' bg-info text-white' : '' }}">
                                                        - {!! $answer->TitleLang !!}
                                                    </p>
                                                    <span class="font-weight-bold">
                                                        {{ $answer->score ? '(' . $answer->score . 'pt)' : '' }}
                                                    </span>
                                                </li>
                                            @empty
                                                <li class="list-group-item rounded-0 border-0" aria-disabled="true">
                                                    <p class="m-0">- {{ trans('custom.no_answers') }}</p>
                                                </li>
                                            @endforelse
                                        </ul>
                                    @empty
                                        <p>{{ trans('custom.no_questions') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
@endsection
