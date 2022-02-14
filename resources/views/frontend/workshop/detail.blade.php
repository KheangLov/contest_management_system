@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.workshop_detail'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.workshop') => route('workshop'),
            trans('custom.workshop_detail') => '#',
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
    <div id="overviews" class="section wb">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 blog-post-single">
                    <div class="blog-item">
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="meta-info-blog mt-0">
                                        <span class="font-weight-bold"><i class="fa fa-calendar"></i> {{trans('custom.start_date')}} : {{ $entry->StartDateFormat }} </span>
                                        <span class="font-weight-bold"><i class="fa fa-calendar"></i> {{trans('custom.end_date')}} : {{$entry->EndDateFormat }} </span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="post-date">
                                        @php
                                            $date = Carbon\Carbon::parse($entry->start_date)
                                        @endphp
                                        <span class="day">{{ $date->day }}</span>
                                        <span class="month">{{ $date->shortLocaleMonth }}</span>
                                        @if($entry->CheckUserAlreadyJoin)
                                            {{-- <div class="pricingTable-sign-up"> --}}
                                                <span class="day ml-2"><span>{{trans('custom.joined')}}</span></span>
                                            {{-- </div> --}}
                                        @else
                                            @if(backpack_user())
                                                {{-- <div class="pricingTable-sign-up"> --}}
                                                    <span class="day ml-2" style="cursor: pointer;" data-toggle="modal" data-target="#modelConfirmUserAlreadyLogin{{$entry->id}}"><span>{{trans('custom.join')}}</span></span>
                                                {{-- </div> --}}
                                            @else
                                                {{-- <div class="pricingTable-sign-up"> --}}
                                                    <span class="day ml-2" style="cursor: pointer;" data-toggle="modal" data-target="#loginRegisterWorkShop{{$entry->id}}"><span>{{trans('custom.join')}}</span></span>
                                                {{-- </div> --}}
                                            @endif
                                        @endif
                                        @if (backpack_user() && optional($entry->workshopJoiners)->where('id', backpack_user()->id)->first())
                                            <span class="day ml-2" style="cursor: pointer;">
                                                <span>
                                                    <a href="{{ route('view_workshop_certificate', $entry->id) }}" class="text-white" target="_blank">
                                                        {{ trans('custom.download') }}
                                                    </a>
                                                </span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="blog-title">
                                <h2><a href="#" title="">{{ $entry->TitleLang }}</a></h2>
                            </div>
                            <div class="blog-desc">
                                {!! $entry->DescriptionLang !!}
                                {{-- <img src="{{ asset($entry->image) }}" alt="{{ $entry->image }}" class="img-fluid"> --}}
                                {{-- @foreach ($entry->gallery as $gallery)
                                    <img src="{{ asset($gallery) }}" alt="{{ $gallery }}" class="img-fluid">
                                @endforeach --}}

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
                <div class="col-lg-4 blog-post-single">
                    @include("frontend.workshop.joiner_list")
                </div>
            </div>
        </div>
    </div>
    @include('frontend.modal.modal_register_workshop', ['id' => $entry->id])
    @include('frontend.modal.join_for_user_login', ['id' => $entry->id])
@endsection
