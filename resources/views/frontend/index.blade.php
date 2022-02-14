@extends('frontend.layout.app')

@php
    $sliders = json_decode(config('settings.slider_frontend' . $prefix));
    $histories = json_decode(config('settings.history_timeline' . $prefix))
@endphp
@section('content')
    <div id="carouselExampleControls" class="carousel slide bs-slider box-slider" data-ride="carousel" data-pause="hover" data-interval="false" >
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @foreach ($sliders as $key => $slider)
                <li data-target="#carouselExampleControls" data-slide-to="{{ $key }}"{{ $loop->first ? ' class="active"' : '' }}></li>
            @endforeach
        </ol>
        <div class="carousel-inner" role="listbox">
            @foreach ($sliders as $slider)
                <div class="carousel-item{{ $loop->first ? ' active' : '' }}">
                    <div class="first-section" style="background-image:url('{{ asset($slider->image) }}')">
                        {!! $slider->content !!}
                    </div>
                </div>
            @endforeach

            <!-- Left Control -->
            <a class="new-effect carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="fa fa-angle-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <!-- Right Control -->
            <a class="new-effect carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="fa fa-angle-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div id="overviews" class="section wb">
        <div class="container">
            @include('frontend.news.index',['news' => $news])
            {{-- <div class="section-title row text-center">
                <div class="col-md-8 offset-md-2">
                    <h3>{{ trans('custom.home_page_first_sect_title') }}</h3>
                    <p class="lead">
                        {{ trans('custom.home_page_first_sect_description') }}
                    </p>
                </div>
            </div><!-- end title --> --}}

            @if ($contest)
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="message-box">
                            <h2>{{ $contest->TitleLang }}</h2>
                            <p>
                                {!! $contest->DescriptionStripeStringLong !!}
                            </p>

                            <a href="{{ route('contest_detail', ['id' => $contest->id]) }}" class="hover-btn-new orange">
                                <span>{{ trans('custom.read_more') }}</span>
                            </a>
                        </div><!-- end messagebox -->
                    </div><!-- end col -->

                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="post-media wow fadeIn">
                            <img src="{{ asset($contest->image) }}" alt="{{ $contest->image }}" class="img-fluid img-rounded">
                        </div><!-- end media -->
                    </div><!-- end col -->
                </div>
            @endif

            @if ($workshop)
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="post-media wow fadeIn">
                            <img src="{{ asset($workshop->image) }}" alt="{{ $workshop->image }}" class="img-fluid img-rounded">
                        </div><!-- end media -->
                    </div><!-- end col -->

                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="message-box">
                            <h2>{{ $workshop->TitleLang }}</h2>
                            <p>
                                {!! $workshop->DescriptionStripeStringLong !!}
                            </p>

                            <a href="{{ route('workshop_details', ['id' => $workshop->id]) }}" class="hover-btn-new orange">
                                <span>{{ trans('custom.read_more') }}</span>
                            </a>
                        </div><!-- end messagebox -->
                    </div><!-- end col -->

                </div><!-- end row -->
            @endif
        </div><!-- end container -->
    </div><!-- end section -->

    <section class="section lb page-section">
        <div class="container">
            <div class="section-title row text-center">
                <div class="col-md-8 offset-md-2">
                    <h3>{{ trans('custom.our_history') }}</h3>
                    <p class="lead">
                        {{ trans('custom.our_history_description') }}
                    </p>
                </div>
            </div><!-- end title -->
            <div class="timeline">
                <div class="timeline__wrap">
                    <div class="timeline__items">
                        @foreach ($histories as $history)
                            <div class="timeline__item">
                                <div class="timeline__content" style="background: url({{ asset($history->image) }}) no-repeat center; background-size: cover;">
                                    {!! $history->content !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('after_scripts')
    <script src="{{ asset('js/timeline.min.js') }}"></script>
    <script>
        timeline(document.querySelectorAll('.timeline'), {
            forceVerticalMode: 700,
            mode: 'horizontal',
            verticalStartPosition: 'left',
            visibleItems: {{ count($histories) > 4 ? 4 : count($histories) }}
        });
    </script>
@endpush
