@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.contest_detail'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.contest') => route('contest'),
            trans('custom.contest_detail') => '#',
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
    <div id="overviews" class="section wb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 blog-post-single">
                    <div class="blog-item">
                        <div class="image-blog">
                            <img src="images/blog_single.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="post-content">
                            <div class="post-date">
                                @php
                                    $date = $entry->CreatedAtDate;
                                @endphp
                                <span class="day">{{ $date->day }}</span>
                                <span class="month">{{ $date->shortLocaleMonth }}</span>
                            </div>
                            <div class="meta-info-blog">
                                <span><i class="fa fa-calendar"></i> <a href="#">{{ $date->toDateString() }}</a> </span>
                                <span>
                                    <i class="fa fa-tag"></i>
                                    <a href="#">
                                        {{ optional($entry->level)->LevelCategory }}
                                    </a>
                                </span>
                                {{-- <span><i class="fa fa-tag"></i>  <a href="#">News</a> </span>
                                <span><i class="fa fa-comments"></i> <a href="#">12 Comments</a></span> --}}
                            </div>
                            <div class="blog-title">
                                <h2><a href="#" title="">{{ $entry->TitleLang }}</a></h2>
                            </div>
                            <div class="blog-desc">
                                {!! $entry->DescriptionLang !!}
                                <img src="{{ asset($entry->image) }}" alt="{{ $entry->image }}" class="mx-auto d-block">
                                {{-- @foreach ($entry->gallery as $gallery)
                                    <img src="{{ asset($gallery) }}" alt="{{ $gallery }}" class="img-fluid">
                                @endforeach --}}
                            </div>

                            {{-- <div class="row mt-5">
                                <div class="col-sm-12">
                                    @forelse ($entry->questions as $question)
                                        <ul class="list-group mb-3 rounded-0 border-0 shadow-sm">
                                            <li class="list-group-item bg-secondary rounded-0 border-0" aria-disabled="true">
                                                <h6 class="m-0 font-weight-bold text-white p-0">{!! $question->TitleLang !!}</h6>
                                            </li>
                                            @forelse ($question->answers as $answer)
                                                <li class="list-group-item rounded-0 border-0" aria-disabled="true">
                                                    <p class="d-inline-block m-0{{ $question->answer_id == $answer->id ? ' bg-success text-white' : '' }}">
                                                        - {!! $answer->TitleLang !!}
                                                    </p>
                                                </li>
                                            @empty
                                                <li class="list-group-item rounded-0 border-0" aria-disabled="true">
                                                    <p class="m-0">- No answers</p>
                                                </li>
                                            @endforelse
                                        </ul>
                                    @empty
                                        <p>No questions</p>
                                    @endforelse
                                </div>
                            </div> --}}
                        </div>
                    </div>

                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
@endsection
