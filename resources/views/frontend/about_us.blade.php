@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.about_us'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.about_us') => '#',
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
    <div id="overviews" class="section lb">
        <div class="container">
            <div class="section-title row text-center">
                <div class="col-md-8 offset-md-2">
                    <h3>
                        {!! trans('custom.about_us_first_sect_title') !!}
                    </h3>
                    <p class="lead">
                        {!! trans('custom.about_us_first_sect_description') !!}
                    </p>
                </div>
            </div><!-- end title -->

            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="message-box">
                        <h4>{!! trans('custom.about_us_second_sect_title_top') !!}</h4>
                        <h2>{!! trans('custom.about_us_second_sect_title') !!}</h2>
                        {!! trans('custom.about_us_second_sect_description') !!}
                        <a href="#" class="hover-btn-new orange">
                            <span>{{ trans('custom.learn_more') }}</span>
                        </a>
                    </div><!-- end messagebox -->
                </div><!-- end col -->

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="post-media wow fadeIn">
                        <img src="{{ asset('images/about_02.jpg') }}" alt="images/about_02.jpg" class="img-fluid img-rounded">
                    </div><!-- end media -->
                </div><!-- end col -->
            </div>
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="post-media wow fadeIn">
                        <img src="{{ asset('images/about_02.jpg') }}" alt="images/about_02.jpg" class="img-fluid img-rounded">
                    </div><!-- end media -->
                </div><!-- end col -->

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="message-box">
                        <h2>{!! trans('custom.about_us_third_sect_title') !!}</h2>
                        {!! trans('custom.about_us_third_sect_description') !!}
                        <a href="#" class="hover-btn-new orange">
                            <span>{{ trans('custom.learn_more') }}</span>
                        </a>
                    </div><!-- end messagebox -->
                </div><!-- end col -->

            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <div class="hmv-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="inner-hmv">
                        <div class="icon-box-hmv"><i class="flaticon-achievement"></i></div>
                        <h3>{!! trans('custom.about_us_mission') !!}</h3>
                        <div class="tr-pa">M</div>
                        <p>
                            {!! trans('custom.about_us_mission_description') !!}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="inner-hmv">
                        <div class="icon-box-hmv"><i class="flaticon-eye"></i></div>
                        <h3>{!! trans('custom.about_us_vision') !!}</h3>
                        <div class="tr-pa">V</div>
                        <p>
                            {!! trans('custom.about_us_vision_description') !!}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="inner-hmv">
                        <div class="icon-box-hmv"><i class="flaticon-history"></i></div>
                        <h3>{!! trans('custom.about_us_history') !!}</h3>
                        <div class="tr-pa">H</div>
                        <p>
                            {!! trans('custom.about_us_history_description') !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
