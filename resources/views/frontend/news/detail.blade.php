@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.news_detail'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.news_detail') => '#',
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
                        <div class="post-content">
                            <div class="blog-title">
                                <h2><a href="#" title="">{{ $entry->TitleLang }}</a></h2>
                            </div>
                            <div class="meta-info-blog">
                                <span>
                                    {{ trans('custom.created_at') }}:
                                    <a href="javascript:void(0)">
                                        {{ $entry->CreatedAtFormat }}
                                    </a>
                                </span>
                            </div>
                            <div class="blog-desc">
                                {!! $entry->DescriptionLang !!}
                            </div>
                            <div id="carouselExampleControls" class="carousel slide bs-slider box-slider" data-ride="carousel" data-pause="hover" data-interval="false" >
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    @if ($entry->MergeImageGallery)
                                        @foreach ($entry->MergeImageGallery as $key => $image)
                                            <li data-target="#carouselExampleControls" data-slide-to="0" class="{{ $key == 0 ? 'active' : ''}}"></li>
                                        @endforeach
                                    @endif
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    @if ($entry->MergeImageGallery)
                                        @foreach ($entry->MergeImageGallery as $key => $image)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : ''}}">
                                                <div id="home" class="first-section" style="background-image:url('{{$image}}');">
                                                    <div class="dtab">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm-12 text-right">
                                                                    <div class="big-tagline" style="height: 500px;">
                                                                    </div>
                                                                </div>
                                                            </div><!-- end row -->
                                                        </div><!-- end container -->
                                                    </div>
                                                </div><!-- end section -->
                                            </div>
                                        @endforeach
                                    @endif

                                    <a class="new-effect carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                        <span class="fa fa-angle-left" aria-hidden="true"></span>
                                        <span class="sr-only">{{trans('custom.previous')}}</span>
                                    </a>

                                    <!-- Right Control -->
                                    <a class="new-effect carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                        <span class="fa fa-angle-right" aria-hidden="true"></span>
                                        <span class="sr-only">{{trans('custom.next')}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
